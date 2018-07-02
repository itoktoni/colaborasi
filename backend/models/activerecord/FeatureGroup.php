<?php

namespace backend\models\activerecord;

use Yii;

/**
 * This is the model class for table "feature_group".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $sort
 * @property string $icon
 * @property int $status
 *
 * @property Feature[] $features
 */
class FeatureGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feature_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['sort', 'status'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 64],
            [['icon'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'sort' => 'Sort',
            'icon' => 'Icon',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeatures()
    {
        return $this->hasMany(Feature::className(), ['feature_group' => 'id']);
    }
}
