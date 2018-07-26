<?php

namespace common\models\base;

/**
 * This is the model class for table "voucher".
 *
 * @property int    $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property int    $voucher_type
 * @property int    $discount_type
 * @property int    $discount_counter
 * @property string $discount_prosentase
 * @property string $discount_price
 * @property string $start_date
 * @property string $end_date
 * @property int    $status
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
            [['name', 'code', 'voucher_type', 'discount_type', 'status'], 'required'],
            [['start_date', 'end_date'], 'required', 'when' => function ($model) {
                return $model->voucher_type == 1 || $model->voucher_type == 2;
            }],
            [['discount_counter'], 'required', 'when' => function ($model) {
                return $model->voucher_type == 3;
            }],
            [['discount_prosentase'], 'required', 'when' => function ($model) {
                return $model->discount_type == 1;
            }],
            [['discount_price'], 'required', 'when' => function ($model) {
                return $model->discount_type == 2;
            }],
            [['code'], 'unique'],
            [['description'], 'string'],
            [['voucher_type', 'discount_type', 'discount_counter', 'status'], 'integer'],
            [['discount_prosentase', 'discount_price'], 'number'],
            [['start_date', 'end_date', 'created_at', 'updated_at'], 'safe'],
            [['name', 'code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'description' => 'Description',
            'voucher_type' => 'Voucher Type',
            'discount_type' => 'Discount Type',
            'discount_counter' => 'Discount Counter',
            'discount_prosentase' => 'Discount Prosentase',
            'discount_price' => 'Discount Price',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
