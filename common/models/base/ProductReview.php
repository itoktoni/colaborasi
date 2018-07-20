<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "product_review".
 *
 * @property int $id
 * @property int $member
 * @property int $product
 * @property int $star
 * @property string $comment
 * @property int $status
 */
class ProductReview extends \yii\db\ActiveRecord
{

        
    const STATUS_DELETED = -9;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['member', 'product', 'star', 'status'], 'integer'],
            [['status'], 'safe'],
            [['comment'], 'string'],
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
            'product' => 'Product',
            'star' => 'Star',
            'comment' => 'Comment',
            'status' => 'Status',
        ];
    }
}
