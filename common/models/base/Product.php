<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string $synopsis
 * @property string $description
 * @property string $price
 * @property string $price_discount
 * @property int $brand
 * @property string $image
 * @property string $image_path
 * @property string $image_thumbnail
 * @property string $image_portrait
 * @property int $headline
 * @property string $meta_description
 * @property string $meta_keyword
 * @property string $product_download_url
 * @property string $product_download_path
 * @property int $product_view
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Brand $brand0
 * @property ProductCategory[] $productCategories
 * @property ProductContent[] $productContents
 */
class Product extends \yii\db\ActiveRecord
{
    
    const STATUS_DELETED = -9;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'name', 'brand'], 'required'],
            [['description'], 'string'],
            [['price', 'price_discount'], 'number'],
            [['brand', 'headline', 'product_view', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['slug', 'synopsis', 'image', 'image_path', 'image_thumbnail', 'image_portrait', 'meta_description', 'meta_keyword', 'product_download_url', 'product_download_path'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 64],
            [['brand'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::className(), 'targetAttribute' => ['brand' => 'id']],
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
            'synopsis' => 'Synopsis',
            'description' => 'Description',
            'price' => 'Price',
            'price_discount' => 'Price Discount',
            'brand' => 'Brand',
            'image' => 'Image',
            'image_path' => 'Image Path',
            'image_thumbnail' => 'Image Thumbnail',
            'image_portrait' => 'Image Portrait',
            'headline' => 'Headline',
            'meta_description' => 'Meta Description',
            'meta_keyword' => 'Meta Keyword',
            'product_download_url' => 'Product Download Url',
            'product_download_path' => 'Product Download Path',
            'product_view' => 'Product View',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand0()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCategories()
    {
        return $this->hasMany(ProductCategory::className(), ['product' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductContents()
    {
        return $this->hasMany(ProductContent::className(), ['product' => 'id']);
    }
}
