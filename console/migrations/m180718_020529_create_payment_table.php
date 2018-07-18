<?php

use yii\db\Migration;

/**
 * Handles the creation of table `payment`.
 */
class m180718_020529_create_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('payment', [
            'id' => $this->primaryKey(),
            'invoice' => $this->string(), //unique
            'payment_type' => $this->tinyinteger(),
            'shipping_type' => $this->tinyinteger(),
            'user' => $this->integer(),
            'user_name' => $this->string(),
            'user_address' => $this->string(),
            'user_email' => $this->string(),
            'user_social_media_type' => $this->tinyinteger(),
            'user_social_media_id' => $this->string(),
            'voucher' => $this->integer(),
            'voucher_name' => $this->string(),
            'voucher_discount_type' => $this->integer(),
            'voucher_discount_value' => $this->decimal(),
            'tax_amount' => $this->integer(),
            'total_bruto' => $this->decimal(),
            'total_bruto_dollar' => $this->decimal(),
            'total_discount_rupiah' => $this->decimal(),
            'total_discount_dollar' => $this->decimal(),
            'total_tax_rupiah' => $this->decimal(),
            'total_tax_dollar' => $this->decimal(),
            'total_shipping_rupiah' => $this->decimal(),
            'total_shipping_dollar' => $this->decimal(),
            'total_net_rupiah' => $this->decimal(),
            'total_net_dollar' => $this->decimal(),
            'paypal_payment_id' => $this->string(),
            'paypal_amount_dollar' => $this->string(),
            'paypal_amount_rupiah' => $this->string(),
            'paypal_payer_id' => $this->string(),
            'paypal_payer_email' => $this->string(),
            'paypal_token' => $this->string(),
            'shipping_province' => $this->string(),
            'shipping_city' => $this->string(),
            'shipping_courier' => $this->string(),
            'shipping_courier_service' => $this->string(),
            'cc_transaction_id' => $this->string(),
            'cc_number' => $this->string(),
            'cc_month' => $this->string(),
            'cc_year' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'payment_status' => $this->tinyinteger(),
            'status' => $this->tinyinteger()
        ]);


        $this->createTable('payment_detail', [
            'id' => $this->primaryKey(),
            'payment' => $this->integer(), //foreign key payment
            'product' => $this->integer(),
            'qty' => $this->integer(),
            'product_name' => $this->string(),
            'product_origin_price' => $this->decimal(),
            'product_discount_price' => $this->decimal(),
            'product_sell_price' => $this->decimal(),
            'status' => $this->tinyinteger()
        ]);

        $this->addForeignKey(
            'fk-payment-payment-detail', 'payment_detail', 'payment', 'payment', 'id', 'CASCADE'
        );

        $this->addForeignKey(
            'fk-payment-detail-product', 'payment_detail', 'product', 'product', 'id', 'CASCADE'
        );

        $this->addForeignKey(
            'fk-payment-user', 'payment', 'user', 'user', 'id', 'CASCADE'
        );
        $this->addForeignKey(
            'fk-payment-voucher', 'payment', 'voucher', 'voucher', 'id', 'CASCADE'
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('payment_detail');
        $this->dropTable('payment');
        
    }
}
