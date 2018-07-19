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

    public function actionCC(){
        
        \Stripe\Stripe::setApiKey(Yii::$app->params['stripe_key']);
        $token = $_POST['stripeToken'];

        try {
                $charge = \Stripe\Charge::create([
                    'amount' => 999,
                    'currency' => 'usd',
                    'description' => 'description',
                    'source' => $token,
                    'receipt_email' => $_POST['shipping_email'],
                ]);

                if($charge->paid == true){
                    d($charge);
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
        // $payment_insert = [];
        // $payment_detail_insert          = [];
        $payment_insert_value           = [];
        $payment_detail_insert_value    = [];
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

        /*$payment_insert[] = [
            'invoice', 'payment_type', 'shipping_type', 
            'user', 'user_name', 'user_address', 'user_email', 'user_social_media_type', 'user_social_media_id',
            'total_bruto', 'total_bruto_dollar', 'total_discount_rupiah', 'total_discount_dollar', 
            'total_shipping_rupiah', 'total_shipping_dollar', 'total_net_rupiah', 'total_net_dollar',
            'shipping_province', 'shipping_city', 'shipping_courier', 'shipping_courier_service', 
            'shipping_receiver', 'shipping_address', 'shipping_phone_number', 'shipping_email',
            'created_at', 'updated_at', 'payment_status', 'status'
        ];*/

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
            $total_idr, $total_usd, $discount, $discount_usd, 
            $voucher_id, $voucher_name, $discount_type, $discount,
            $shipping_idr, $shipping_usd, $grand_total_idr, $grand_total_usd,
            $_POST['province'], $_POST['city'], $_POST['courier'], $_POST['jasa'],
            $_POST['shipping_receiver'], $_POST['shipping_address'], $_POST['shipping_mobile'], $_POST['shipping_email'],
            date('Y-m-d H:i:s'), date('Y-m-d H:i:s'), 0, 1
        ];

        $insert_payment = Yii::$app->db
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
                            ], $payment_insert_value)
                            ->execute();

    	die();
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

    		$payment_id = $_SESSION['payment_id'];
    		$paymentId 	= $_GET['paymentId'];
    		$payment 	= Payment::get($paymentId, $apiContext);

    		$execution 	= new PaymentExecution();
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

		            $each[] 			= [$sale_id, $pi->email, $pi->payer_id, $payment->id, $payment_id, $amount, time()];

		            Yii::$app->db->createCommand()->batchInsert('paypal_detail',['ltransaction_id', 'lpayer_email', 'lpayer_id', 'paypal_payment_id', 'payment_id', 'lamount', 'created_at'], $each)->execute();

		            // header('Location: http://onestopclick.com');
        			// die();

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