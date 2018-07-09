<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "product_content".
 *
 * @property int $id
 * @property int $product
 * @property int $embed_type
 * @property int $content_type
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 * @property int $status
 *
 * @property Product $product0
 */
class Productcontent extends \yii\db\ActiveRecord
{
    
    const STATUS_DELETED = -9;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product', 'embed_type', 'content_type', 'status'], 'integer'],
            [['embed_type', 'content_type'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['content'], 'string', 'max' => 255],
            [['product'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product' => 'id']],
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
            'embed_type' => 'Embed Type',
            'content_type' => 'Content Type',
            'content' => 'Content',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
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
