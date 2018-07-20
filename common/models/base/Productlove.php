<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "product_category".
 *
 * @property int $id
 * @property int $product
 * @property int $sub_category
 *
 * @property Product $product0
 * @property SubCategory $subCategory
 */
class Productlove extends \yii\db\ActiveRecord
{
    
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_love';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product', 'member','product'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product' => 'Product',
            'member' => 'Member',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct0()
    {
        return $this->hasOne(Product::className(), ['id' => 'product']);
    }

}
