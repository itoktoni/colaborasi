<?php

use yii\db\Migration;

/**
 * Class m180628_023551_backend
 */
class m180628_023551_backend extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('roles', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull(),
            'description' => $this->string(),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(1)], $tableOptions);

        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'email' => $this->string(64)->notNull(),
            'name' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'auth_key' => $this->string(32),
            'password_hash' => $this->string(),
            'password_reset_token' => $this->string()->unique(),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'roles' => $this->integer(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->createTable('feature_group', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull(),
            'slug' => $this->string(64)->notNull(),
            'sort' => $this->integer()->defaultValue(0),
            'icon' => $this->string(),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(1)], $tableOptions);

        $this->createTable('feature', [
            'id' => $this->primaryKey(),
            'feature_group' => $this->integer(),
            'name' => $this->string(64)->notNull(),
            'slug' => $this->string(64)->notNull(),
            'sort' => $this->integer()->defaultValue(0),
            'icon' => $this->string(),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(1)], $tableOptions);

        $this->createTable('permission', [
            'id' => $this->primaryKey(),
            'roles' => $this->integer(),
            'feature' => $this->integer(),
            'access' => $this->integer()->notNull()->defaultValue(1)], $tableOptions);

        $this->addForeignKey(
            'fk-roles-user', 'user', 'roles', 'roles', 'id', 'CASCADE'
        );

        $this->addForeignKey(
            'fk-feature-feature-group', 'feature', 'feature_group', 'feature_group', 'id', 'CASCADE'
        );

        $this->addForeignKey(
            'fk-permission-feature', 'permission', 'feature', 'feature', 'id', 'CASCADE'
        );

        $this->addForeignKey(
            'fk-permission-roles', 'permission', 'roles', 'roles', 'id', 'CASCADE'
        );

        $this->insert('roles', [
            'id' => 1,
            'name' => 'Super Admin',
            'description' => "Super Admin Don't Delete This",
            'status' => 1,
        ]);

        $this->insert('user', [
            'id' => 1,
            'email' => 'admin@admin.com',
            'name' => 'Super Admin',
            'password' => md5('admin'),
            'status' => 1,
            'roles' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $rows = [
            [1, 'Setting', 'setting', 4, 'settings', 1],
            [2, 'Product', 'product', 0, 'product', 1],
            // [3, 'Category', 'category', 0, 'product', 1],
        ];

        $this->batchInsert('feature_group', [
            'id',
            'name',
            'slug',
            'sort',
            'icon',
            'status'],
            $rows);

        $rows =
            [
            [1, 'Feature', 'feature', 0, '-', 1],
            [1, 'Feature Group', 'feature-group', 1, '-', 1],
            [1, 'Roles', 'roles', 2, '-', 1],
            [1, 'User', 'user', 3, '-', 1],
            [2, 'Brand', 'brand', 0, '-', 1],
            [2, 'Product', 'product', 1, '-', 1],
            [2, 'Category', 'category', 2, '-', 1],
            [2, 'Sub Category', 'sub-category', 3, '-', 1],
        ];
        $this->batchInsert('feature',
            ['feature_group', 'name', 'slug', 'sort', 'icon', 'status'],
            $rows);

        $rows = [
            [1, 1, 2], 
            [1, 2, 2], 
            [1, 3, 2], 
            [1, 4, 2], 
            [1, 5, 2],
            [1, 6, 2],
            [1, 7, 2],
            [1, 8, 2],
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
        echo "m180628_023551_backend cannot be reverted.\n";

        return false;
    }

    /*
// Use up()/down() to run migration code without a transaction.
public function up()
{

}

public function down()
{
echo "m180628_023551_backend cannot be reverted.\n";

return false;
}
 */
}
