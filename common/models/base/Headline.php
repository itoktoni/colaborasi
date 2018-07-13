<?php

namespace common\models\base;

use Yii;
use \godzie44\yii\behaviors\image\ImageBehavior;
use yii\imagine\Image;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "headline".
 *
 * @property int $id
 * @property string $title
 * @property string $subtitle
 * @property string $image
 * @property string $link
 * @property string $created_at
 * @property string $updated_at
 */
class Headline extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'headline';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'subtitle', 'image', 'link'], 'string', 'max' => 255],
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

            Image::resize($originFile, 1920, 570, false, true)->save($thumbnFile, ['quality' => 100]);
            return ['filename' => $filename, 'extension' => '.' . $this->image->extension];
        
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'subtitle' => 'Subtitle',
            'image' => 'Image',
            'link' => 'Link',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
