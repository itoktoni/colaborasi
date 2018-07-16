<?php

use yii\db\Migration;

/**
 * Handles the creation of table `subscribe`.
 */
class m180716_073244_create_subscribe_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('subscribe', [
            'id' => $this->primaryKey(),
            'email' => $this->string(64)->unique(),
            'created_at' => $this->datetime(),
            'updated_at' => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('subscribe');
    }
}
