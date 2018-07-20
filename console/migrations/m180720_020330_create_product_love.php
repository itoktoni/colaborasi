<?php

use yii\db\Migration;

/**
 * Class m180720_020330_create_product_love
 */
class m180720_020330_create_product_love extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('product_love', [
            'id' => $this->primaryKey(),
            'member' => $this->integer(),
            'product' => $this->integer(),
            'status' => $this->tinyinteger()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('product_love');
    }

}
