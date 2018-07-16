<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "voucher".
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string $code
 * @property string $description
 * @property string $discount_prosentase
 * @property string $discount_price
 * @property string $start_date
 * @property string $end_date
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 */
class Voucher extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = -9;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'voucher';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'name', 'code'], 'required'],
            [['description'], 'string'],
            [['discount_prosentase', 'discount_price'], 'number'],
            [['start_date', 'end_date', 'created_at', 'updated_at'], 'safe'],
            [['status'], 'integer'],
            [['slug', 'name', 'code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'name' => 'Name',
            'code' => 'Code',
            'description' => 'Description',
            'discount_prosentase' => 'Discount (%)',
            'discount_price' => 'Discount (IDR)',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
