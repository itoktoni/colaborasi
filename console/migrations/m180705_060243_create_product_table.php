<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product`.
 */
class m180705_060243_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('product', [
            'id' => $this->primaryKey(),
            'slug' => $this->string()->notNull(),
            'name' => $this->string(64)->notNull(),
            'synopsis' => $this->string(),
            'description' => $this->text(),
            'price' => $this->decimal(),
            'price_discount' => $this->decimal(),
            'brand' => $this->integer()->notNull(),
            'image' => $this->string(),
            'image_path' => $this->string(),
            'image_thumbnail' => $this->string(),
            'image_portrait' => $this->string(),
            'headline' => $this->boolean(),
            'meta_description' => $this->string(),
            'meta_keyword' => $this->string(),
            'product_download_url' => $this->string(),
            'product_download_path' => $this->string(),
            'product_view' => $this->integer(),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);


        $this->createTable('product_content', [
            'id' => $this->primaryKey(),
            'product' => $this->integer(),
            'embed_type' => $this->tinyinteger(1)->notNull(),
            'content_type' => $this->tinyinteger(1)->notNull(),
            'content' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->createTable('brand', [
            'id' => $this->primaryKey(),
            'slug' => $this->string()->notNull(),
            'name' => $this->string(),
            'description' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'slug' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->createTable('sub_category', [
            'id' => $this->primaryKey(),
            'category' => $this->integer(),
            'slug' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(1),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('product_content');
        $this->dropTable('product');
        $this->dropTable('brand');
        $this->dropTable('category');
        $this->dropTable('sub_category');
    }
}
