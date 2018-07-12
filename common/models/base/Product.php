<?php

namespace common\models\base;

use common\models\CartInterface;
use Yii;
use \godzie44\yii\behaviors\image\ImageBehavior;
use yii\imagine\Image;
use yii\behaviors\SluggableBehavior;
use yii\helpers\FileHelper;

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
 * @property int $discount_flag
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
class Product extends \yii\db\ActiveRecord implements CartInterface
{

    const STATUS_DELETED = -9;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public $subcategory;
    public $content;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'immutable'=>true
            ],
            [
                'class' => ImageBehavior::className(),
                'imageAttr' => 'image',
                'images' => [
                    '_default' => ['default' => []], //save default upload image
                    '_small' => ['resize' => [500, 500]], //and save resized copy
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'brand', 'status', 'category', 'price'], 'required'],
            [['description'], 'string'],
            [['price', 'price_discount'], 'number'],
            [['brand', 'headline', 'product_view', 'status','discount_flag'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['slug'], 'unique'],
            [['slug', 'synopsis', 'image', 'image_path', 'image_thumbnail', 'image_portrait', 'meta_description', 'meta_keyword', 'product_download_url', 'product_download_path'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 64],
            [['brand'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::className(), 'targetAttribute' => ['brand' => 'id']],
            [['image'], 'file', 'extensions' => 'png, jpg, jpeg'],
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
            'discount_flag' => 'Discount Flag',
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
     * [upload description]
     * @param  [type]  $path     [description]
     * @param  boolean $filename [description]
     * @return [type]            [description]
     */
    public function upload($path, $filename = false)
    {
        
            if (!$this->image) {
                return false;
            }

            FileHelper::createDirectory($path, $mode = 0775, $recursive = true);

            if (!$filename) {
                $filename = $this->image->BaseName;
            }

            $originFile = $path . $filename . '.' . $this->image->extension;
            $this->image->saveAs($originFile);
            $thumbnFile = $path . $filename . '-thumb.' . $this->image->extension;
            $portrait = $path . $filename . '-portrait.' . $this->image->extension;
            $headline = $path . $filename . '-headline.' . $this->image->extension;

            Image::resize($originFile, 250, 250, false, true)->save($thumbnFile, ['quality' => 80]);
            Image::resize($originFile, 500, 250, false, true)->save($portrait, ['quality' => 80]);
            Image::resize($originFile, 750, 750, false, true)->save($headline, ['quality' => 100]);
            // $this->save();
            return ['filename' => $filename, 'extension' => '.' . $this->image->extension];
        
    }

    public function product_upload($path, $filename = false)
    {
        if (!$this->product_download_url) {
            return false;
        }
        FileHelper::createDirectory($path, $mode = 0775, $recursive = true);

        if (!$filename) {
            $filename = $this->product_download_url->BaseName;
        }

        $originFile = $path . $filename . '.' . $this->product_download_url->extension;
        $this->product_download_url->saveAs($originFile);

        return ['filename' => $filename, 'extension' => '.' . $this->product_download_url->extension];
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

       /**
     * Returns the price for the cart item
     *
     * @return int
     */
    public function getPrice(){
        return $this->price;
      }
  /**
   * Returns the label for the cart item (displayed in cart etc)
   *
   * @return int|string
   */
  public function getLabel(){
    return $this->name;
  }
  /**
   * Returns unique id to associate cart item with product
   *
   * @return int|string
   */
  public function getUniqueId(){
    return $this->id;
  }


}
