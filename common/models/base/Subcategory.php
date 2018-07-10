<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "sub_category".
 *
 * @property int $id
 * @property int $category
 * @property string $slug
 * @property string $name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property int $status
 *
 * @property ProductCategory[] $productCategories
 * @property Category $category0
 */
class Subcategory extends \yii\db\ActiveRecord
{
    public $category_name;
    const STATUS_DELETED = -9;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sub_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category', 'status'], 'integer'],
            [['slug', 'name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['slug', 'name', 'description'], 'string', 'max' => 255],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Category',
            'slug' => 'Slug',
            'name' => 'Name',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCategories()
    {
        return $this->hasMany(ProductCategory::className(), ['sub_category' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory0()
    {
        return $this->hasOne(Category::className(), ['id' => 'category']);
    }
}
