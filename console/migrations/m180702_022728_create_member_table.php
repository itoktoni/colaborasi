<?php

use yii\db\Migration;

/**
 * Handles the creation of table `member`.
 */
class m180702_022728_create_member_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if ($this->db->driverName === 'mysql')
        {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }


        $this->createTable('member', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'address' => $this->string(),
            'address_optional' => $this->string(),
            'email' => $this->string(64),
            'balance' => $this->decimal(),
            'picture' => $this->string(),
            'social_media_type' => $this->tinyinteger(1)->notNull()->defaultValue(0),
            'social_media_id' => $this->string(),
            'password' => $this->string(),
            'password_reset_token' => $this->string()->unique(),
            'created_at' => $this->datetime(),
            'updated_at' => $this->datetime(),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(1)
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('member');
    }

}
