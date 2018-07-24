<?php

namespace common\models\base;

use Yii;
use common\models\base\Member;

/**
 * This is the model class for table "payment".
 *
 * @property int $id
 * @property string $invoice
 * @property int $payment_type
 * @property int $shipping_type
 * @property int $user
 * @property string $user_name
 * @property string $user_address
 * @property string $user_email
 * @property int $user_social_media_type
 * @property string $user_social_media_id
 * @property int $voucher
 * @property string $voucher_name
 * @property int $voucher_discount_type
 * @property string $voucher_discount_value
 * @property int $tax_amount
 * @property string $total_bruto
 * @property string $total_bruto_dollar
 * @property string $total_discount_rupiah
 * @property string $total_discount_dollar
 * @property string $total_tax_rupiah
 * @property string $total_tax_dollar
 * @property string $total_shipping_rupiah
 * @property string $total_shipping_dollar
 * @property string $total_net_rupiah
 * @property string $total_net_dollar
 * @property string $paypal_payment_id
 * @property string $paypal_amount_dollar
 * @property string $paypal_amount_rupiah
 * @property string $paypal_payer_id
 * @property string $paypal_payer_email
 * @property string $paypal_token
 * @property string $shipping_province
 * @property string $shipping_city
 * @property string $shipping_courier
 * @property string $shipping_courier_service
 * @property string $shipping_receiver
 * @property string $shipping_address
 * @property string $shipping_phone_number
 * @property string $shipping_email
 * @property string $cc_transaction_id
 * @property string $cc_number
 * @property string $cc_month
 * @property string $cc_year
 * @property string $created_at
 * @property string $updated_at
 * @property int $payment_status
 * @property int $status
 *
 * @property User $user0
 * @property Voucher $voucher0
 * @property PaymentDetail[] $paymentDetails
 */
class Payments extends \yii\db\ActiveRecord
{

    public $counter;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payment_type', 'shipping_type', 'user', 'user_social_media_type', 'voucher', 'voucher_discount_type', 'tax_amount', 'payment_status', 'status'], 'integer'],
            [['voucher_discount_value', 'total_bruto', 'total_bruto_dollar', 'total_discount_rupiah', 'total_discount_dollar', 'total_tax_rupiah', 'total_tax_dollar', 'total_shipping_rupiah', 'total_shipping_dollar', 'total_net_rupiah', 'total_net_dollar'], 'number'],
            [['created_at', 'updated_at','counter'], 'safe'],
            [['invoice', 'user_name', 'user_address', 'user_email', 'user_social_media_id', 'voucher_name', 'paypal_payment_id', 'paypal_amount_dollar', 'paypal_amount_rupiah', 'paypal_payer_id', 'paypal_payer_email', 'paypal_token', 'shipping_province', 'shipping_city', 'shipping_courier', 'shipping_courier_service', 'shipping_receiver', 'shipping_address', 'shipping_phone_number', 'shipping_email', 'cc_transaction_id', 'cc_number', 'cc_month', 'cc_year'], 'string', 'max' => 255],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => Member::className(), 'targetAttribute' => ['user' => 'id']],
            [['voucher'], 'exist', 'skipOnError' => true, 'targetClass' => Voucher::className(), 'targetAttribute' => ['voucher' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invoice' => 'Invoice',
            'payment_type' => 'Payment Type',
            'shipping_type' => 'Shipping Type',
            'user' => 'User',
            'user_name' => 'User Name',
            'user_address' => 'User Address',
            'user_email' => 'User Email',
            'user_social_media_type' => 'User Social Media Type',
            'user_social_media_id' => 'User Social Media ID',
            'voucher' => 'Voucher',
            'voucher_name' => 'Voucher Name',
            'voucher_discount_type' => 'Voucher Discount Type',
            'voucher_discount_value' => 'Voucher Discount Value',
            'tax_amount' => 'Tax Amount',
            'total_bruto' => 'Total Bruto',
            'total_bruto_dollar' => 'Total Bruto Dollar',
            'total_discount_rupiah' => 'Total Discount Rupiah',
            'total_discount_dollar' => 'Total Discount Dollar',
            'total_tax_rupiah' => 'Total Tax Rupiah',
            'total_tax_dollar' => 'Total Tax Dollar',
            'total_shipping_rupiah' => 'Total Shipping Rupiah',
            'total_shipping_dollar' => 'Total Shipping Dollar',
            'total_net_rupiah' => 'Total Net Rupiah',
            'total_net_dollar' => 'Total Net Dollar',
            'paypal_payment_id' => 'Paypal Payment ID',
            'paypal_amount_dollar' => 'Paypal Amount Dollar',
            'paypal_amount_rupiah' => 'Paypal Amount Rupiah',
            'paypal_payer_id' => 'Paypal Payer ID',
            'paypal_payer_email' => 'Paypal Payer Email',
            'paypal_token' => 'Paypal Token',
            'shipping_province' => 'Shipping Province',
            'shipping_city' => 'Shipping City',
            'shipping_courier' => 'Shipping Courier',
            'shipping_courier_service' => 'Shipping Courier Service',
            'shipping_receiver' => 'Shipping Receiver',
            'shipping_address' => 'Shipping Address',
            'shipping_phone_number' => 'Shipping Phone Number',
            'shipping_email' => 'Shipping Email',
            'cc_transaction_id' => 'Cc Transaction ID',
            'cc_number' => 'Cc Number',
            'cc_month' => 'Cc Month',
            'cc_year' => 'Cc Year',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'payment_status' => 'Payment Status',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVoucher0()
    {
        return $this->hasOne(Voucher::className(), ['id' => 'voucher']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentDetails()
    {
        return $this->hasMany(PaymentDetail::className(), ['payment' => 'id']);
    }
}
