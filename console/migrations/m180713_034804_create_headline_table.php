<?php

use yii\db\Migration;

/**
 * Handles the creation of table `headline`.
 */
class m180713_034804_create_headline_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('headline', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'subtitle' => $this->string(),
            'image' => $this->string(),
            'link' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('headline');
    }
}
