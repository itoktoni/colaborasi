<?php
namespace frontend\controllers;

use Yii;
use common\models\base\Product;
use common\models\base\Payments;
use common\models\base\PaymentDetail;
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
        endif;
    }

	public function actionPaypal()
    {
    	print_r($_POST); die();
    	/*$total_idr 		= 0;
    	$counter_new 	= 0;
    	$status_new 	= 1;
    	$discount 		= 0;

    	$invoice 		= CMS::getInvoiceCode('payment', 'invoice');

    	Yii::$app->session->set('invoice', $invoice);

    	foreach ($_SESSION['cart'] as $key => $value) :
    		$total_idr 			= $total_idr + $value['price'];
    	endforeach;

    	$total_usd = CMS::currencyConverter( 'IDR', 'USD', $total_idr );

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

    	$discount_usd 		= CMS::currencyConverter( 'IDR', 'USD', $discount );
    	$grand_total_idr	= $total_idr - $discount;
    	$grand_total_usd 	= CMS::currencyConverter( 'IDR', 'USD', $grand_total_idr );

    	die();*/
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