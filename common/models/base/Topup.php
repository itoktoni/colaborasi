<?php

namespace common\models\base;

/**
 * This is the model class for table "topup".
 *
 * @property int    $id
 * @property int    $member
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
            [['member', 'status'], 'integer'],
            [['create_at', 'update_at', 'expire_at', 'amount'], 'safe'],
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
