<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "member_download".
 *
 * @property int $id
 * @property string $key
 * @property int $product
 * @property int $member
 * @property string $expiration_date
 * @property string $create_at
 * @property string $updated_at
 * @property int $status
 */
class MemberDownload extends \yii\db\ActiveRecord
{
    public $product_name;
    public $download_url;
    const STATUS_AVAILABLE = 1,STATUS_EXPIRED = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'member_download';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product', 'member', 'status'], 'integer'],
            [['expiration_date', 'create_at', 'updated_at'], 'safe'],
            [['key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'product' => 'Product',
            'member' => 'Member',
            'expiration_date' => 'Expiration Date',
            'create_at' => 'Create At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }


    public function beforeSave($insert){
        if($insert){
            $this->key = __generateUniqueRandomString('key');
        }

        return parent::beforeSave($insert);
    }

    public function __generateUniqueRandomString($attribute, $length = 32) {
			
        $randomString = Yii::$app->getSecurity()->generateRandomString($length);
                
        if(!$this->findOne([$attribute => $randomString]))
            return $randomString;
        else
            return $this->generateUniqueRandomString($attribute, $length);
                
    }
}
