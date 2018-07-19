<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_review`.
 */
class m180719_070337_create_product_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('product_review', [
            'id' => $this->primaryKey(),
            'member' => $this->integer(),
            'product' => $this->integer(),
            'star' => $this->tinyinteger(),
            'comment' => $this->text(),
            'status' => $this->tinyinteger()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('product_review');
    }
}
