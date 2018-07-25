<?php

namespace frontend\controllers;

use common\models\base\Member;
use common\models\base\MemberDownload;
use common\models\base\PaymentDetail;
use common\models\base\Payments;
use common\models\base\Voucher;
use frontend\components\CMS;
use frontend\components\Paypal;
use kartik\mpdf\Pdf;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use Yii;
use yii\db\Expression;
use yii\web\Controller;

class ContinuepaymentController extends Controller
{
    public $voucher = false;

    public function actionIndex()
    {
        $payment_method = YII::$app->request->post('payment_method');

        if ($payment_method == 'paypal') {
            return $this->actionPaypal();
        } elseif ($payment_method == 'cc') {
            return $this->actionCC();
        } elseif ($payment_method == 'balance') {
            return $this->actionBalance();
        }

        Yii::$app->session->setFlash('error', 'You cannot access that page directly');
        $this->redirect(['/cart']);
    }

    public function actionSendemail($invoice)
    {
        // $invoice = 'PAY1807190007';

        $header = Payments::find()->where(['invoice' => $invoice])->one();
        $detail = PaymentDetail::find()
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
            'filename' => 'files/so/'.$invoice.'.pdf',
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'options' => ['title' => 'Invoice '.$invoice],
        ]);
        $pdf->render();

        Yii::$app->mailer->compose('@app/mail/html', [
            'header' => $header,
            'details' => $detail,
        ])
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($header->user_email)
            ->setSubject('Notification Order From System')
            ->attach('../web/files/so/'.$invoice.'.pdf')
            ->send();
    }

    public function actionBalance()
    {
        $total_idr = 0;
        $counter_new = 0;
        $status_new = 1;
        $discount = 0;
        $payment_insert_value = [];
        $payment_detail = $product_download = [];
        $voucher_id = $voucher_name = $discount_type = '';

        // get invoice ID
        $invoice = CMS::getInvoiceCode('payment', 'invoice');

        // get user
        $user_id = Yii::$app->user->id;
        $user = Member::find()->where(['id' => $user_id])->one();
        $user_name = $user->name;
        $user_address = $user->address;
        $user_email = $user->email;
        $user_social_media_type = $user->social_media_type;
        $user_social_media_id = $user->social_media_id;

        // get total order
        Yii::$app->session->set('invoice', $invoice);

        foreach ($_SESSION['cart'] as $key => $value):
            $total_idr = $total_idr + $value['price'];
        endforeach;

        $total_usd = CMS::currencyConverter('IDR', 'USD', $total_idr);

        // get voucher
        if (!empty($_SESSION['voucher'])):

            $voucher_id = $_SESSION['voucher']['id'];
        $voucher_code = $_SESSION['voucher']['code'];
        $voucher_name = $_SESSION['voucher']['name'];
        $voucher_type = $_SESSION['voucher']['voucher_type'];
        $discount_type = $_SESSION['voucher']['discount_type'];
        $discount_counter = $_SESSION['voucher']['discount_counter'];
        $discount_prosentase = $_SESSION['voucher']['discount_prosentase'];
        $discount_price = $_SESSION['voucher']['discount_price'];

        if (!$this->__check_voucher($voucher_type, $voucher_id)) {
            return $this->redirect(['/checkout']);
        }

        if ($discount_type == CMS::DISCOUNT_PERCENTAGE):
                $discount = ($discount_prosentase / 100) * $total_idr; elseif ($discount_type == CMS::DISCOUNT_FIXED):
                $discount = $discount_price;
        endif;

        endif;

        $discount_usd = CMS::currencyConverter('IDR', 'USD', $discount);

        $shipping_idr = YII::$app->request->post('total_ongkir');
        $shipping_usd = CMS::currencyConverter('IDR', 'USD', $shipping_idr);
        $grand_total_idr = ($total_idr - $discount) + $shipping_idr;
        $grand_total_usd = CMS::currencyConverter('IDR', 'USD', $grand_total_idr);

        if ($grand_total_idr > YII::$app->user->identity->balance) {
            Yii::$app->session->setFlash('error', "You don't have enough balance, please top up first");

            return $this->redirect(['/checkout']);
        }

        $payment_insert_value[] = [
            $invoice, CMS::PAYMENT_BALANCE, (YII::$app->request->post('shipping_type')) ? CMS::SHIPPING_ON : CMS::SHIPPING_OFF,
            $user_id, $user_name, $user_address, $user_email, $user_social_media_type, $user_social_media_id,
            $voucher_id, $voucher_name, $discount_type, $discount,
            $total_idr, $total_usd, $discount, $discount_usd,
            $shipping_idr, $shipping_usd, $grand_total_idr, $grand_total_usd,
            YII::$app->request->post('province'), YII::$app->request->post('city'), YII::$app->request->post('courier'), YII::$app->request->post('jasa'),
            YII::$app->request->post('shipping_receiver'), YII::$app->request->post('shipping_address'), YII::$app->request->post('shipping_mobile'), YII::$app->request->post('shipping_email'),
            date('Y-m-d H:i:s'), date('Y-m-d H:i:s'), 0, 1,
        ];

        if ($this->insertPayment($payment_insert_value)):
            $payment_id = CMS::getMaxID('payment');

        foreach ($_SESSION['cart'] as $key => $value):
                $payment_detail[] = [$payment_id, $value['id'], $value['qty'], $value['name'], $value['price'], 0, $value['price'], 1];
        $product_download[] = $value['id'];
        endforeach;
        $this->__generate_download_link($product_download);

        Yii::$app->db
                ->createCommand()
                ->batchInsert('payment_detail', ['payment', 'product', 'qty', 'product_name', 'product_origin_price', 'product_discount_price', 'product_sell_price', 'status'], $payment_detail)
                ->execute();

        $member = Member::find()->where(['id' => YII::$app->user->identity->id])->one();
        $member->balance = $member->balance - $grand_total_idr;
        $member->save(false);
        if ($this->voucher) {
            $this->voucher->save(false);
        }

        return $this->redirect(['/payment-success']);
        endif;

        return $this->redirect(['/checkout']);
    }

    public function actionCC()
    {
        \Stripe\Stripe::setApiKey(Yii::$app->params['stripe_key']);
        // dd(post('cvc'));

        if (!post('cardnumber') || !post('year') || !post('month') || !post('cvc')) {
            Yii::$app->session->setFlash('error', 'Please fill credit card field first');

            return $this->redirect(['/checkout']);
        }

        $token = \Stripe\Token::create(array(
            'card' => array(
                'number' => YII::$app->request->post('cardnumber'),
                'exp_month' => YII::$app->request->post('month'),
                'exp_year' => YII::$app->request->post('year'),
                'cvc' => YII::$app->request->post('cvc'),
            ),
        ));

        if ($token) {
            $token = $token->id;
        } else {
            Yii::$app->session->setFlash('error', 'Invalid Token');

            return $this->redirect(['/checkout']);
        }

        $total_idr = 0;
        $counter_new = 0;
        $status_new = 1;
        $discount = 0;
        $payment_insert_value = [];
        $payment_detail = $product_download = [];
        $voucher_id = $voucher_name = $discount_type = '';

        // get invoice ID
        $invoice = CMS::getInvoiceCode('payment', 'invoice');

        // get user
        $user_id = Yii::$app->user->id;
        $user = Member::find()->where(['id' => $user_id])->one();
        $user_name = $user->name;
        $user_address = $user->address;
        $user_email = $user->email;
        $user_social_media_type = $user->social_media_type;
        $user_social_media_id = $user->social_media_id;

        // get total order
        Yii::$app->session->set('invoice', $invoice);

        foreach ($_SESSION['cart'] as $key => $value):
            $total_idr = $total_idr + $value['price'];
        endforeach;

        $total_usd = CMS::currencyConverter('IDR', 'USD', $total_idr);

        // get voucher
        if (!empty($_SESSION['voucher'])):

            $voucher_id = $_SESSION['voucher']['id'];
        $voucher_code = $_SESSION['voucher']['code'];
        $voucher_name = $_SESSION['voucher']['name'];
        $voucher_type = $_SESSION['voucher']['voucher_type'];
        $discount_type = $_SESSION['voucher']['discount_type'];
        $discount_counter = $_SESSION['voucher']['discount_counter'];
        $discount_prosentase = $_SESSION['voucher']['discount_prosentase'];
        $discount_price = $_SESSION['voucher']['discount_price'];

        if (!$this->__check_voucher($voucher_type, $voucher_id)) {
            return $this->redirect(['/checkout']);
        }

        if ($discount_type == CMS::DISCOUNT_PERCENTAGE):
                $discount = ($discount_prosentase / 100) * $total_idr; elseif ($discount_type == CMS::DISCOUNT_FIXED):
                $discount = $discount_price;
        endif;

        endif;

        $discount_usd = CMS::currencyConverter('IDR', 'USD', $discount);

        $shipping_idr = YII::$app->request->post('total_ongkir');
        $shipping_usd = CMS::currencyConverter('IDR', 'USD', $shipping_idr);
        $grand_total_idr = ($total_idr - $discount) + $shipping_idr;
        $grand_total_usd = CMS::currencyConverter('IDR', 'USD', $grand_total_idr);

        $payment_insert_value[] = [
            $invoice, CMS::PAYMENT_CC, (YII::$app->request->post('shipping_type')) ? CMS::SHIPPING_ON : CMS::SHIPPING_OFF,
            $user_id, $user_name, $user_address, $user_email, $user_social_media_type, $user_social_media_id,
            $voucher_id, $voucher_name, $discount_type, $discount,
            $total_idr, $total_usd, $discount, $discount_usd,
            $shipping_idr, $shipping_usd, $grand_total_idr, $grand_total_usd,
            YII::$app->request->post('province'), YII::$app->request->post('city'), YII::$app->request->post('courier'), YII::$app->request->post('jasa'),
            YII::$app->request->post('shipping_receiver'), YII::$app->request->post('shipping_address'), YII::$app->request->post('shipping_mobile'), YII::$app->request->post('shipping_email'),
            date('Y-m-d H:i:s'), date('Y-m-d H:i:s'), 0, 1,
        ];

        if ($this->insertPayment($payment_insert_value)):
            $payment_id = CMS::getMaxID('payment');

        foreach ($_SESSION['cart'] as $key => $value):
                $payment_detail[] = [$payment_id, $value['id'], $value['qty'], $value['name'], $value['price'], 0, $value['price'], 1];
        $product_download[] = $value['id'];
        endforeach;
        $this->__generate_download_link($product_download);

        Yii::$app->db
                ->createCommand()
                ->batchInsert('payment_detail', ['payment', 'product', 'qty', 'product_name', 'product_origin_price', 'product_discount_price', 'product_sell_price', 'status'], $payment_detail)
                ->execute();
        endif;

        if($grand_total_idr > 1000000){
            Yii::$app->session->setFlash('error', 'For Testing, Total Max 1.000.000');
            return $this->redirect(['/checkout']);

        }

        try {
            $charge = \Stripe\Charge::create([
                'amount' => $grand_total_idr.'00',
                'currency' => 'idr',
                'description' => $invoice,
                'source' => $token,
                'receipt_email' => YII::$app->request->post('shipping_email'),
            ]);

            if ($charge->paid == true) {
                $invoice = $_SESSION['invoice'];
                $payment_data = Payments::find()->where(['invoice' => $invoice])->one();
                $payment_data->cc_transaction_id = $charge->id;
                $payment_data->cc_number = YII::$app->request->post('cardnumber');
                $payment_data->cc_month = YII::$app->request->post('month');
                $payment_data->cc_year = YII::$app->request->post('year');
                $payment_data->save();
                if ($this->voucher) {
                    $this->voucher->save(false);
                }

                $this->actionSendemail($invoice);

                return $this->redirect(['/payment-success']);
            } else {
                Yii::$app->session->setFlash('error', 'Payment Transaction Failed');
            }
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', $e);
        }

        return $this->redirect(['/checkout']);
    }

    public function actionPaypal()
    {
        $total_idr = 0;
        $counter_new = 0;
        $status_new = 1;
        $discount = 0;
        $payment_insert_value = [];
        $payment_detail = $product_download = [];
        $voucher_id = $voucher_name = $discount_type = '';

        // get invoice ID
        $invoice = CMS::getInvoiceCode('payment', 'invoice');

        // get user
        $user_id = Yii::$app->user->id;
        $user = Member::find()->where(['id' => $user_id])->one();
        $user_name = $user->name;
        $user_address = $user->address;
        $user_email = $user->email;
        $user_social_media_type = $user->social_media_type;
        $user_social_media_id = $user->social_media_id;

        // get total order
        Yii::$app->session->set('invoice', $invoice);

        foreach ($_SESSION['cart'] as $key => $value):
            $total_idr = $total_idr + $value['price'];
        endforeach;

        $total_usd = CMS::currencyConverter('IDR', 'USD', $total_idr);

        // get voucher
        if (!empty($_SESSION['voucher'])):

            $voucher_id = $_SESSION['voucher']['id'];
        $voucher_code = $_SESSION['voucher']['code'];
        $voucher_name = $_SESSION['voucher']['name'];
        $voucher_type = $_SESSION['voucher']['voucher_type'];
        $discount_type = $_SESSION['voucher']['discount_type'];
        $discount_counter = $_SESSION['voucher']['discount_counter'];
        $discount_prosentase = $_SESSION['voucher']['discount_prosentase'];
        $discount_price = $_SESSION['voucher']['discount_price'];

        if (!$this->__check_voucher($voucher_type, $voucher_id)) {
            return $this->redirect(['/checkout']);
        }

        if ($discount_type == CMS::DISCOUNT_PERCENTAGE):
                $discount = ($discount_prosentase / 100) * $total_idr; elseif ($discount_type == CMS::DISCOUNT_FIXED):
                $discount = $discount_price;
        endif;

        endif;

        $discount_usd = CMS::currencyConverter('IDR', 'USD', $discount);

        $shipping_idr = YII::$app->request->post('total_ongkir');
        $shipping_usd = CMS::currencyConverter('IDR', 'USD', $shipping_idr);
        $grand_total_idr = ($total_idr - $discount) + $shipping_idr;
        $grand_total_usd = CMS::currencyConverter('IDR', 'USD', $grand_total_idr);

        $payment_insert_value[] = [
            $invoice, CMS::PAYMENT_PAYPAL, (YII::$app->request->post('shipping_type')) ? CMS::SHIPPING_ON : CMS::SHIPPING_OFF,
            $user_id, $user_name, $user_address, $user_email, $user_social_media_type, $user_social_media_id,
            $voucher_id, $voucher_name, $discount_type, $discount,
            $total_idr, $total_usd, $discount, $discount_usd,
            $shipping_idr, $shipping_usd, $grand_total_idr, $grand_total_usd,
            YII::$app->request->post('province'), YII::$app->request->post('city'), YII::$app->request->post('courier'), YII::$app->request->post('jasa'),
            YII::$app->request->post('shipping_receiver'), YII::$app->request->post('shipping_address'), YII::$app->request->post('shipping_mobile'), YII::$app->request->post('shipping_email'),
            date('Y-m-d H:i:s'), date('Y-m-d H:i:s'), 0, 1,
        ];

        if ($this->insertPayment($payment_insert_value)):
            $payment_id = CMS::getMaxID('payment');

        foreach ($_SESSION['cart'] as $key => $value):
                $payment_detail[] = [$payment_id, $value['id'], $value['qty'], $value['name'], $value['price'], 0, $value['price'], 1];
        $product_download[] = $value['id'];
        endforeach;
        $this->__generate_download_link($product_download);

        Yii::$app->db
                ->createCommand()
                ->batchInsert('payment_detail', ['payment', 'product', 'qty', 'product_name', 'product_origin_price', 'product_discount_price', 'product_sell_price', 'status'], $payment_detail)
                ->execute();
        if ($this->voucher) {
            $this->voucher->save(false);
        }

        endif;

        $p = new Paypal();
        $response = $p->teszt($grand_total_usd, $invoice);

        $url = $response->links[1]->href;
        $this->actionSendemail($invoice);
        header('Location: '.$url);

        die();
    }

    public function insertPayment($data = [])
    {
        return Yii::$app->db
            ->createCommand()
            ->batchInsert('payment', [
                'invoice', 'payment_type', 'shipping_type',
                'user', 'user_name', 'user_address', 'user_email', 'user_social_media_type', 'user_social_media_id',
                'voucher', 'voucher_name', 'voucher_discount_type', 'voucher_discount_value',
                'total_bruto', 'total_bruto_dollar', 'total_discount_rupiah', 'total_discount_dollar',
                'total_shipping_rupiah', 'total_shipping_dollar', 'total_net_rupiah', 'total_net_dollar',
                'shipping_province', 'shipping_city', 'shipping_courier', 'shipping_courier_service',
                'shipping_receiver', 'shipping_address', 'shipping_phone_number', 'shipping_email',
                'created_at', 'updated_at', 'payment_status', 'status',
            ], $data)
            ->execute();
    }

    public function insertPaymentdetail($data = [])
    {
        $insert = Yii::$app->db
            ->createCommand()
            ->batchInsert('payment_detail', ['payment', 'product', 'qty', 'product_name', 'product_origin_price', 'product_discount_price', 'product_sell_price', 'status'], $data)
            ->execute();

        return $insert;
    }

    public function actionExecute()
    {
        $each = [];
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AcQ7K1xxsb08Rau-dOoC3VZ2hVRWhjlMMz-0ynDqWaBBY2qXoZuJ-O7k9ZakBYAk9jboQSSxjjaAG0Iw', // ClientID
                'EJk3DZMikLrssMBK_THeextkQd7vIMoGgklryCPqHuI4EN6gCBdOS-PcDj188-Zo1ZyJlCxbrQEStrJd' // ClientSecret
            )
        );

        if (YII::$app->request->get('success') && YII::$app->request->get('success') == 'true'):

            $invoice = $_SESSION['invoice'];
        $payment_data = Payments::find()->where(['invoice' => $invoice])->one();
        $payment_id = $payment_data->id;
        $total_idr = $payment_data->total_net_rupiah;

        $paymentId = YII::$app->request->get('paymentId');
        $payment = Payment::get($paymentId, $apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId(YII::$app->request->get('PayerID'));

        try {
            $result = $payment->execute($execution, $apiContext);
            try {
                $payment = Payment::get($paymentId, $apiContext);
                $pi = $payment->payer->payer_info;
                $transactions = $payment->getTransactions();
                $related_resources = $transactions[0]->getRelatedResources();
                $sale = $related_resources[0]->getSale();
                $sale_id = $sale->getId();
                $amount = $transactions[0]->amount->total;

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

                return $this->redirect(['/payment-success']);
            } catch (Exception $e) {
                return $this->redirect(['/site/failed']);
            }
        } catch (Exception $e) {
            ResultPrinter::printError('Executed Payment', 'Payment', null, null, $e);
        }

        endif;
    }

    /**
     * Check Voucher type and availability
     * wawa.
     */
    private function __check_voucher($voucher_type, $voucher_id)
    {
        if ($voucher_type == CMS::VOUCHER_COUNTERBASED) {
            $this->voucher = Voucher::find()
                ->where(['id' => $voucher_id])
                ->andWhere(['=', 'status', CMS::STATUS_ACTIVE])
                ->andWhere(['>', 'discount_counter', 1])
                ->one();

            if (!$this->voucher) {
                Yii::$app->session->setFlash('error', 'Vouchers are all used');

                return false;
            }
            --$this->voucher->discount_counter;
            $this->voucher->save(false);
        } elseif ($voucher_type == CMS::VOUCHER_ONETIMEUSAGE) {
            $this->voucher = Voucher::find()
                ->where(['id' => $voucher_id])
                ->andWhere(['status' => CMS::STATUS_ACTIVE])
                ->one();
            if (!$this->voucher) {
                Yii::$app->session->setFlash('error', 'Voucher already used');

                return false;
            }
            $this->voucher->status = 0;
        } elseif ($voucher_type == CMS::VOUCHER_TIMELINE) {
            $this->voucher = Voucher::find()
                ->where(['id' => $voucher_id])
                ->andWhere(['status' => CMS::STATUS_ACTIVE])
                ->andWhere(['<', 'start_date', new Expression('NOW()')])
                ->andWhere(['>', 'end_date', new Expression('NOW()')])
                ->one();
            if (!$this->voucher) {
                Yii::$app->session->setFlash('error', 'Voucher Expired');

                return false;
            }
        }

        if (!$this->voucher) {
            Yii::$app->session->setFlash('error', 'Voucher not found or already used');

            return false;
        }

        return true;
    }

    /**
     * private function Generate key to Member download table.
     *
     * return boolean
     *
     * author : wawa
     */
    private function __generate_download_link($product = [])
    {
        $save = array();
        $member = YII::$app->user->identity->id;

        foreach ($product as $key => $item) {
            $save[] = [$this->__generateUniqueRandomString(), $item, $member, MemberDownload::STATUS_AVAILABLE];
        }

        Yii::$app->db->createCommand()
            ->batchInsert(MemberDownload::tableName(), [
                'key',
                'product',
                'member',
                'status',
            ], $save)
            ->execute();
    }

    private function __generateUniqueRandomString($length = 64)
    {
        return Yii::$app->getSecurity()->generateRandomString($length);
    }
}
