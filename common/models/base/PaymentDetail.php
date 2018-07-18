<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "payment_detail".
 *
 * @property int $id
 * @property int $payment
 * @property int $product
 * @property int $qty
 * @property string $product_name
 * @property string $product_origin_price
 * @property string $product_discount_price
 * @property string $product_sell_price
 * @property int $status
 *
 * @property Product $product0
 * @property Payment $payment0
 */
class PaymentDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payment', 'product', 'qty', 'status'], 'integer'],
            [['product_origin_price', 'product_discount_price', 'product_sell_price'], 'number'],
            [['product_name'], 'string', 'max' => 255],
            [['product'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product' => 'id']],
            [['payment'], 'exist', 'skipOnError' => true, 'targetClass' => Payment::className(), 'targetAttribute' => ['payment' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'payment' => 'Payment',
            'product' => 'Product',
            'qty' => 'Qty',
            'product_name' => 'Product Name',
            'product_origin_price' => 'Product Origin Price',
            'product_discount_price' => 'Product Discount Price',
            'product_sell_price' => 'Product Sell Price',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct0()
    {
        return $this->hasOne(Product::className(), ['id' => 'product']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayment0()
    {
        return $this->hasOne(Payment::className(), ['id' => 'payment']);
    }
}
