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
            [['product', 'sub_category','status'], 'required'],
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

    /**
     * Insert batch or update it if duplicate
     */
    public function insertBatch($data, $id){

        $command = Yii::$app->db->createCommand()->update(self::tableName(), ['status' => '0'], 'product='.$id);
        $command->execute();
        foreach($data as $key => $item){
            $check = self::find()->where(['product' => $item[0],'sub_category' => $item[1]])->one();
            if($check){
                unset($data[$key]);
                $check->status = 1;
                $check->save();
            }
        }

        if(!$data){
            return;
        }

        

        $command = Yii::$app->db->createCommand()->batchInsert(self::tableName(), ['product', 'sub_category'], $data);
        $command->execute();
    }
}
