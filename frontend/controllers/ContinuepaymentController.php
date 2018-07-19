<?php
namespace frontend\controllers;

use Yii;
use common\models\base\Product;
use common\models\base\Payments;
use common\models\base\PaymentDetail;
use common\models\base\Member;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\components\Paypal;
use frontend\components\CMS;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\ExecutePayment;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use kartik\mpdf\Pdf;
use yii\mail;

class ContinuepaymentController extends Controller
{
    public function actionIndex()
    {
        $payment_method = $_POST['payment_method'];

        if ( $payment_method == 'paypal' ) :
            $this->actionPaypal();
        elseif ( $payment_method == 'cc' ) :
            $this->actionCC();
        endif;
    }

    public function actionSendemail(){

        $invoice = 'PAY1807190007';

        $header = Payments::find()->where(['invoice' => $invoice])->one();
        $detail = PaymentDetail::find()
        // ->leftJoin('product', 'product.product_id_category = category.category_id')
        ->where(['payment' => $header->id])->all();

        $content = $this->renderPartial('@app/views/pdf/so', [
            'header' => $header,
            'detail' => $detail,
        ]);

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_FILE,
            'filename' => 'files/so/'.$invoice . '.pdf',
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'options' => ['title' => 'Laporan Harian']
        ]);
        $pdf->render();

        Yii::$app->mailer->compose('@app/mail/html', [
                     'header' => $header,
                     'details' => $detail,
                ])
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo($header->user_email)
                ->setSubject('Notification Order From System')
                ->attach('../web/files/so/' . $invoice . '.pdf')
                ->send();
    }

    public function actionCC(){
        
        // d($_POST);
        \Stripe\Stripe::setApiKey(Yii::$app->params['stripe_key']);
        $token = $_POST['stripeToken'];

        $total_idr 		= 0;
    	$counter_new 	= 0;
    	$status_new 	= 1;
    	$discount 		= 0;
        $payment_insert_value           = [];
        $payment_detail = [];
        $voucher_id     = $voucher_name  = $discount_type = '';

        // get invoice ID
    	$invoice 		= CMS::getInvoiceCode('payment', 'invoice');

        // get user
        $user_id        = Yii::$app->user->id;
        $user           = Member::find()->where(['id' => $user_id])->one();
        $user_name      = $user->name;
        $user_address   = $user->address;
        $user_email     = $user->email;
        $user_social_media_type = $user->social_media_type;
        $user_social_media_id   = $user->social_media_id;

        // get total order
    	Yii::$app->session->set('invoice', $invoice);

    	foreach ($_SESSION['cart'] as $key => $value) :
    		$total_idr 			= $total_idr + $value['price'];
    	endforeach;

    	$total_usd = CMS::currencyConverter( 'IDR', 'USD', $total_idr );

        // get voucher
    	if ( !empty( $_SESSION['voucher'] ) ) :

    		$voucher_id 			= $_SESSION['voucher']['id'];
    		$voucher_code 			= $_SESSION['voucher']['code'];
    		$voucher_name 			= $_SESSION['voucher']['name'];
    		$voucher_type 			= $_SESSION['voucher']['voucher_type'];
    		$discount_type 			= $_SESSION['voucher']['discount_type'];
    		$discount_counter 		= $_SESSION['voucher']['discount_counter'];
    		$discount_prosentase 	= $_SESSION['voucher']['discount_prosentase'];
    		$discount_price 		= $_SESSION['voucher']['discount_price'];

    		if ( $voucher_type == CMS::VOUCHER_COUNTERBASED ) :
    			$counter_new 		= $discount_counter - 1;
    		elseif ( $voucher_type == CMS::VOUCHER_ONETIMEUSAGE ) :
    			$status_new 		= 0;
    		endif;

    		if ( $discount_type == CMS::DISCOUNT_PERCENTAGE ) :
				$discount = ($discount_prosentase / 100) * $total_idr;
			elseif ( $discount_type == CMS::DISCOUNT_FIXED ) :
				$discount = $discount_price;
			endif;

    	endif;

        $discount_usd       = CMS::currencyConverter( 'IDR', 'USD', $discount );

        $shipping_idr       = $_POST['total_ongkir'];
        $shipping_usd       = CMS::currencyConverter( 'IDR', 'USD', $shipping_idr );
        $grand_total_idr    = ($total_idr - $discount) + $shipping_idr;
        $grand_total_usd    = CMS::currencyConverter( 'IDR', 'USD', $grand_total_idr );

        $payment_insert_value[]       = [
            $invoice, CMS::PAYMENT_CC, CMS::SHIPPING_ON,
            $user_id, $user_name, $user_address, $user_email, $user_social_media_type, $user_social_media_id,
            $voucher_id, $voucher_name, $discount_type, $discount,
            $total_idr, $total_usd, $discount, $discount_usd, 
            $shipping_idr, $shipping_usd, $grand_total_idr, $grand_total_usd,
            $_POST['province'], $_POST['city'], $_POST['courier'], $_POST['jasa'],
            $_POST['shipping_receiver'], $_POST['shipping_address'], $_POST['shipping_mobile'], $_POST['shipping_email'],
            date('Y-m-d H:i:s'), date('Y-m-d H:i:s'), 0, 1
        ];

        if ( $this->insertPayment( $payment_insert_value ) ) :
            $payment_id = CMS::getMaxID('payment');

            foreach ($_SESSION['cart'] as $key => $value) :
                $payment_detail[]   = [$payment_id, $value['id'], $value['qty'], $value['name'], $value['price'], 0, $value['price'], 1];
            endforeach;

            Yii::$app->db
                ->createCommand()
                ->batchInsert('payment_detail',['payment', 'product', 'qty', 'product_name', 'product_origin_price', 'product_discount_price', 'product_sell_price', 'status'], $payment_detail)
                ->execute();
        endif;

        try {
                $charge = \Stripe\Charge::create([
                    'amount' => $grand_total_idr, 
                    'currency' => 'idr',
                    'description' => $invoice,
                    'source' => $token,
                    'receipt_email' => $_POST['shipping_email'],
                ]);

                if($charge->paid == true){
                    $invoice      = $_SESSION['invoice'];
                    $payment_data = Payments::find()->where(['invoice' => $invoice])->one();
                    $payment_data->cc_transaction_id = $charge->id;
                    $payment_data->cc_number = $_POST['cardnumber'];
                    $payment_data->cc_month = $_POST['month'];
                    $payment_data->cc_year = $_POST['year'];
                    $payment_data->save();

                    return $this->redirect(['/site/success']);

                }
                else{
                    Yii::$app->session->setFlash('error', 'Payment Transaction Failed');
                }
        } catch (Exception $e) {

            Yii::$app->session->setFlash('error', $e);

        }

      return $this->redirect(['card/checkout']);

    }

	public function actionPaypal()
    {
    	$total_idr 		= 0;
    	$counter_new 	= 0;
    	$status_new 	= 1;
    	$discount 		= 0;
        $payment_insert_value           = [];
        $payment_detail = [];
        $voucher_id     = $voucher_name  = $discount_type = '';

        // get invoice ID
    	$invoice 		= CMS::getInvoiceCode('payment', 'invoice');

        // get user
        $user_id        = Yii::$app->user->id;
        $user           = Member::find()->where(['id' => $user_id])->one();
        $user_name      = $user->name;
        $user_address   = $user->address;
        $user_email     = $user->email;
        $user_social_media_type = $user->social_media_type;
        $user_social_media_id   = $user->social_media_id;

        // get total order
    	Yii::$app->session->set('invoice', $invoice);

    	foreach ($_SESSION['cart'] as $key => $value) :
    		$total_idr 			= $total_idr + $value['price'];
    	endforeach;

    	$total_usd = CMS::currencyConverter( 'IDR', 'USD', $total_idr );

        // get voucher
    	if ( !empty( $_SESSION['voucher'] ) ) :

    		$voucher_id 			= $_SESSION['voucher']['id'];
    		$voucher_code 			= $_SESSION['voucher']['code'];
    		$voucher_name 			= $_SESSION['voucher']['name'];
    		$voucher_type 			= $_SESSION['voucher']['voucher_type'];
    		$discount_type 			= $_SESSION['voucher']['discount_type'];
    		$discount_counter 		= $_SESSION['voucher']['discount_counter'];
    		$discount_prosentase 	= $_SESSION['voucher']['discount_prosentase'];
    		$discount_price 		= $_SESSION['voucher']['discount_price'];

    		if ( $voucher_type == CMS::VOUCHER_COUNTERBASED ) :
    			$counter_new 		= $discount_counter - 1;
    		elseif ( $voucher_type == CMS::VOUCHER_ONETIMEUSAGE ) :
    			$status_new 		= 0;
    		endif;

    		if ( $discount_type == CMS::DISCOUNT_PERCENTAGE ) :
				$discount = ($discount_prosentase / 100) * $total_idr;
			elseif ( $discount_type == CMS::DISCOUNT_FIXED ) :
				$discount = $discount_price;
			endif;

    	endif;

        $discount_usd       = CMS::currencyConverter( 'IDR', 'USD', $discount );

        $shipping_idr       = $_POST['total_ongkir'];
        $shipping_usd       = CMS::currencyConverter( 'IDR', 'USD', $shipping_idr );
        $grand_total_idr    = ($total_idr - $discount) + $shipping_idr;
        $grand_total_usd    = CMS::currencyConverter( 'IDR', 'USD', $grand_total_idr );

        $payment_insert_value[]       = [
            $invoice, CMS::PAYMENT_PAYPAL, CMS::SHIPPING_ON,
            $user_id, $user_name, $user_address, $user_email, $user_social_media_type, $user_social_media_id,
            $voucher_id, $voucher_name, $discount_type, $discount,
            $total_idr, $total_usd, $discount, $discount_usd, 
            $shipping_idr, $shipping_usd, $grand_total_idr, $grand_total_usd,
            $_POST['province'], $_POST['city'], $_POST['courier'], $_POST['jasa'],
            $_POST['shipping_receiver'], $_POST['shipping_address'], $_POST['shipping_mobile'], $_POST['shipping_email'],
            date('Y-m-d H:i:s'), date('Y-m-d H:i:s'), 0, 1
        ];

        if ( $this->insertPayment( $payment_insert_value ) ) :
            $payment_id = CMS::getMaxID('payment');

            foreach ($_SESSION['cart'] as $key => $value) :
                $payment_detail[]   = [$payment_id, $value['id'], $value['qty'], $value['name'], $value['price'], 0, $value['price'], 1];
            endforeach;

            Yii::$app->db
                ->createCommand()
                ->batchInsert('payment_detail',['payment', 'product', 'qty', 'product_name', 'product_origin_price', 'product_discount_price', 'product_sell_price', 'status'], $payment_detail)
                ->execute();
        endif;

        $p          = new Paypal();
        $response   = $p->teszt( $grand_total_usd, $invoice );

        $url        = $response->links[1]->href;

        header('Location: '.$url);

    	die();
    }

    public function insertPayment( $data = [] )
    {
        $insert = Yii::$app->db
                            ->createCommand()
                            ->batchInsert('payment', [
                                'invoice', 'payment_type', 'shipping_type', 
                                'user', 'user_name', 'user_address', 'user_email', 'user_social_media_type', 'user_social_media_id',
                                'voucher', 'voucher_name', 'voucher_discount_type', 'voucher_discount_value',
                                'total_bruto', 'total_bruto_dollar', 'total_discount_rupiah', 'total_discount_dollar', 
                                'total_shipping_rupiah', 'total_shipping_dollar', 'total_net_rupiah', 'total_net_dollar',
                                'shipping_province', 'shipping_city', 'shipping_courier', 'shipping_courier_service', 
                                'shipping_receiver', 'shipping_address', 'shipping_phone_number', 'shipping_email',
                                'created_at', 'updated_at', 'payment_status', 'status'
                            ], $data)
                            ->execute();

        return $insert;
    }

    public function insertPaymentdetail( $data = [] )
    {
        $insert = Yii::$app->db
                ->createCommand()
                ->batchInsert('payment_detail',['payment', 'product', 'qty', 'product_name', 'product_origin_price', 'product_discount_price', 'product_sell_price', 'status'], $data)
                ->execute();
        return $insert;
    }

    public function actionExecute()
    {
    	$each    	= [];
    	$apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AS67obv6-6brdBi1keEpq1oOMxi4WhnFcHx4aItcXG8pc6y2WG5Jk1mJiHYpbZwhYxpEumP0GBKXIS1s',     // ClientID
                'EIyGLVEjSXg2JQSjo72LGHNCGFNGWor6nZjwP2O75VPUx-Q7RVbixoSEgEzNNklLBwLdbqAA7fpg_asU'      // ClientSecret
            )
        );

    	if ( isset($_GET['success']) && $_GET['success'] == 'true' ) :

    		$invoice      = $_SESSION['invoice'];
            $payment_data = Payments::find()->where(['invoice' => $invoice])->one();
            $payment_id   = $payment_data->id;
            $total_idr    = $payment_data->total_net_rupiah;

    		$paymentId 	  = $_GET['paymentId'];
    		$payment      = Payment::get($paymentId, $apiContext);

    		$execution 	  = new PaymentExecution();
			$execution->setPayerId($_GET['PayerID']);

			try 
			{
	        	$result = $payment->execute($execution, $apiContext);
	        	try 
	        	{
            		$payment 			= Payment::get($paymentId, $apiContext);
            		$pi 				= $payment->payer->payer_info;
		            $transactions 		= $payment->getTransactions();
		            $related_resources 	= $transactions[0]->getRelatedResources();
		            $sale 				= $related_resources[0]->getSale();
		            $sale_id 			= $sale->getId();
		            $amount 			= $transactions[0]->amount->total;

		            Yii::$app->db->createCommand()
                        ->update('payment', [
                            'paypal_payment_id' => $payment->id, 
                            'paypal_amount_dollar' => $amount, 
                            'paypal_amount_rupiah' => $total_idr, 
                            'paypal_payer_id' => $pi->payer_id, 
                            'paypal_payer_email' => $pi->email, 
                            'paypal_token' => $sale_id,
                        ], ['invoice' => $invoice])
                        ->execute();

        			return $this->redirect(['/site/success']);
            	}
            	catch (Exception $e)
            	{
            		return $this->redirect(['/site/failed']);
            	}
	        }
	        catch (Exception $e)
	        {
	        	ResultPrinter::printError("Executed Payment", "Payment", null, null, $e);
	        }

    	endif;
    }
}