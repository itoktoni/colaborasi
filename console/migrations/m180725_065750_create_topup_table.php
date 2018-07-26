<?php

use yii\db\Migration;

/**
 * Handles the creation of table `topup`.
 */
class m180725_065750_create_topup_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('topup', [
            'id' => $this->primaryKey(),
            'member' => $this->integer(),
            'amount' => $this->decimal(10, 2),
            'create_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'update_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'expire_at' => $this->timestamp(),
            'status' => $this->tinyinteger(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('topup');
    }
}
