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
class Productcategory extends \yii\db\ActiveRecord
{
    
    const STATUS_DELETED = -9;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product', 'sub_category'], 'required'],
            [['product', 'sub_category'], 'integer'],
            [['product'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product' => 'id']],
            [['sub_category'], 'exist', 'skipOnError' => true, 'targetClass' => SubCategory::className(), 'targetAttribute' => ['sub_category' => 'id']],
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
            'sub_category' => 'Sub Category',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct0()
    {
        return $this->hasOne(Product::className(), ['id' => 'product']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubCategory()
    {
        return $this->hasOne(SubCategory::className(), ['id' => 'sub_category']);
    }
}
