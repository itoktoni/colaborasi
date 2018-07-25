<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "topup".
 *
 * @property int $id
 * @property int $member
 * @property string $amount
 * @property string $create_at
 * @property string $update_at
 * @property string $expire_at
 * @property string $status
 */
class Topup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'topup';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['member'], 'integer'],
            [['amount'], 'number'],
            [['create_at', 'update_at', 'expire_at', 'status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member' => 'Member',
            'amount' => 'Amount',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'expire_at' => 'Expire At',
            'status' => 'Status',
        ];
    }
}
