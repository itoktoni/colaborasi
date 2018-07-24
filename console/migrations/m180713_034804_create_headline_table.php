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

        $rows = [[1, 'SNSD - Holiday Night', 'SNSD Album', 'http://res.cloudinary.com/itoktoni/image/upload/v1531989015/o7hobpwa3uhevxhm9s3s.jpg', 'https://frontend.dev.co/product/holiday', '2018-07-19 03:30:30', '2018-07-19 03:30:30'],
        [2, 'SNSD - Catch Me If You Can', 'SNSD Album', 'http://res.cloudinary.com/itoktoni/image/upload/v1531989087/w4tgmk4evablkjjurlmv.jpg', 'https://frontend.dev.co/product/catch-me-if-you-can', '2018-07-19 03:37:53', '2018-07-19 03:37:53'],
        [3, 'Jurrasic World - Fallen Kingdom', 'Universal Studio Movie', 'http://res.cloudinary.com/itoktoni/image/upload/v1531989278/pq9exfamv4kxhs6z2t85.png', 'https://frontend.dev.co/product/jurassic-world-fallen-kingdom-2018', '2018-07-19 08:34:33', '2018-07-19 08:34:33']];

        $this->batchInsert('headline', [
            'id', 'title', 'subtitle', 'image', 'link', 'created_at', 'updated_at'],
            $rows);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('headline');
    }
}
