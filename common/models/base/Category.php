<?php

namespace common\models\base;

use Yii;
use yii\behaviors\SluggableBehavior;
use \godzie44\yii\behaviors\image\ImageBehavior;
use yii\imagine\Image;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string $image
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property int $status
 *
 * @property SubCategory[] $subCategories
 */
class Category extends \yii\db\ActiveRecord
{
    
    const STATUS_DELETED = -9;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'slug',
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
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['status'], 'integer'],
            [['slug', 'name', 'description'], 'string', 'max' => 255],
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
            'image' => 'Image',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
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

            Image::resize($originFile, 370, 340, false, true)->save($thumbnFile, ['quality' => 100]);
            return ['filename' => $filename, 'extension' => '.' . $this->image->extension];
        
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubCategories()
    {
        return $this->hasMany(SubCategory::className(), ['category' => 'id']);
    }
}
