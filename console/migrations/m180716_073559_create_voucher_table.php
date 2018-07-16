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
            'slug' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'code' => $this->string()->notNull(),
            'description' => $this->text(),
            'discount_prosentase' => $this->decimal(),
            'discount_price' => $this->decimal(),  
            'start_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'end_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),          
        ], $tableOptions);

        $this->insert('voucher', [
            'id' => 1,
            'slug' => 'voucher-123',
            'name' => 'Voucher 123',
            'code' => 'VO123',
            'description' => 'Default Voucher',
            'discount_prosentase' => 0,
            'discount_price' => 10000,
            'start_date' => date('Y-m-d H:i:s'),
            'end_date' => date('Y-m-d H:i:s'),
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
