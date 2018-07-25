<?php

use yii\db\Migration;

/**
 * Class m180723_023351_create_report_feature
 */
class m180723_023351_create_report_feature extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $rows = [
            [4, 'Report', 'report', 0, 'report', 1],
        ];

        $this->batchInsert('feature_group', [
            'id',
            'name',
            'slug',
            'sort',
            'icon',
            'status'],
            $rows);

        $rows = [
            [4, 'Download Report', 'download', 1, 'cloud_download', 1],
            [4, 'Payment Report', 'payment', 0, 'payment', 1]
        ];

        $this->batchInsert('feature',
            ['feature_group', 'name', 'slug', 'sort', 'icon', 'status'],
            $rows);

        // feature role binding
        $rows = [[1, 11, 2],[1, 12, 2]];
        
        $this->batchInsert('permission',
            ['roles', 'feature', 'access'],
            $rows);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180723_023351_create_report_feature cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180723_023351_create_report_feature cannot be reverted.\n";

        return false;
    }
    */
}
