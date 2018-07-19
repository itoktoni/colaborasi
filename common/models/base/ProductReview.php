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
