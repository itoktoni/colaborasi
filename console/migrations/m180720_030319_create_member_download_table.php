<?php

use yii\db\Migration;

/**
 * Handles the creation of table `member_download`.
 */
class m180720_030319_create_member_download_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('member_download', [
            'id' => $this->primaryKey(),
            'key' => $this->string(),
            'product' => $this->integer(),
            'member' => $this->integer(),
            'expiration_date' => $this->timestamp(),
            'create_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'status' => $this->tinyinteger()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('member_download');
    }
}
