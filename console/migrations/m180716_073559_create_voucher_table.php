<?php

use yii\db\Migration;

/**
 * Handles the creation of table `voucher`.
 */
class m180716_073559_create_voucher_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('voucher', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'code' => $this->string()->notNull(),
            'description' => $this->text(),
            'voucher_type' => $this->tinyinteger(),
            'discount_type' => $this->tinyinteger(),
            'discount_counter' => $this->integer(),
            'discount_prosentase' => $this->decimal(),
            'discount_price' => $this->decimal(),  
            'start_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'end_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),          
        ], $tableOptions);

        /**
         * Onetimeusage percentage
         */
        $this->insert('voucher', [
            'id' => 1,
            'name' => 'Voucher Onetimeusage',
            'code' => 'onetimeusage',
            'description' => 'Onetime Usage Percentage',
            'voucher_type' => 1, // VOUCHER_ONETIMEUSAGE = 1, VOUCHER_TIMELINE = 2, VOUCHER_COUNTERBASED = 3; 
            'discount_type' => 1 , //DISCOUNT_PERCENTAGE = 1, DISCOUNT_FIXED = 2;
            'discount_counter' => 0,
            'discount_prosentase' => 30, //if discount_type = 1
            'discount_price' => 0, //if discount_type = 2
            'start_date' => date('Y-m-d H:i:s'),
            'end_date' => date('Y-m-d H:i:s'),
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        /**
         * Onetimeusage fixed
         */
        $this->insert('voucher', [
            'id' => 2,
            'name' => 'Voucher Onetimeusage percentage',
            'code' => 'onetimeusagefixed',
            'description' => 'Onetime Usage Fixed',
            'voucher_type' => 1, // VOUCHER_ONETIMEUSAGE = 1, VOUCHER_TIMELINE = 2, VOUCHER_COUNTERBASED = 3; 
            'discount_type' => 2 , //DISCOUNT_PERCENTAGE = 1, DISCOUNT_FIXED = 2;
            'discount_counter' => 0,
            'discount_prosentase' => 0, //if discount_type = 1
            'discount_price' => 10000, //if discount_type = 2
            'start_date' => date('Y-m-d H:i:s'),
            'end_date' => date('Y-m-d H:i:s'),
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        /**
         *  timeline
         */
        $this->insert('voucher', [
            'id' => 3,
            'name' => 'Voucher Timeline',
            'code' => 'timeline',
            'description' => 'Timeline Dummy',
            'voucher_type' => 2, // VOUCHER_ONETIMEUSAGE = 1, VOUCHER_TIMELINE = 2, VOUCHER_COUNTERBASED = 3; 
            'discount_type' => 2, //DISCOUNT_PERCENTAGE = 1, DISCOUNT_FIXED = 2;
            'discount_counter' => 0,
            'discount_prosentase' => 0, //if discount_type = 1
            'discount_price' => 10000, //if discount_type = 2
            'start_date' => date('Y-m-d H:i:s'),
            'end_date' => date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s') . ' +1 day')),
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        
        /**
         *  timeline
         */
        $this->insert('voucher', [
            'id' => 4,
            'name' => 'Voucher Counter Based',
            'code' => 'counterbase',
            'description' => 'Counter based Dummy',
            'voucher_type' => 2, // VOUCHER_ONETIMEUSAGE = 1, VOUCHER_TIMELINE = 2, VOUCHER_COUNTERBASED = 3; 
            'discount_type' => 2, //DISCOUNT_PERCENTAGE = 1, DISCOUNT_FIXED = 2;
            'discount_counter' => 5,
            'discount_prosentase' => 0, //if discount_type = 1
            'discount_price' => 0, //if discount_type = 2
            'start_date' => date('Y-m-d H:i:s'),
            'end_date' => date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s') . ' +1 day')),
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $rows =
            [
            [2, 'Voucher', 'voucher', 0, '-', 1],
        ];
        $this->batchInsert('feature',
            ['feature_group', 'name', 'slug', 'sort', 'icon', 'status'],
            $rows);

        $rows = [
            [1, 10, 2],
        ];
        $this->batchInsert('permission',
            ['roles', 'feature', 'access'],
            $rows);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('voucher');
    }
}
