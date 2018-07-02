<?php

namespace backend\models\base;

use Yii;

/**
 * This is the model class for table "feature".
 *
 * @property int $id
 * @property int $feature_group
 * @property string $name
 * @property string $slug
 * @property int $sort
 * @property string $icon
 * @property int $status
 *
 * @property FeatureGroup $featureGroup
 * @property Permission[] $permissions
 */
class Feature extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feature';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['feature_group', 'sort', 'status'], 'integer'],
            [['name', 'slug'], 'required'],
            [['name', 'slug'], 'string', 'max' => 64],
            [['icon'], 'string', 'max' => 255],
            [['feature_group'], 'exist', 'skipOnError' => true, 'targetClass' => FeatureGroup::className(), 'targetAttribute' => ['feature_group' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'feature_group' => 'Feature Group',
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
    public function getFeatureGroup()
    {
        return $this->hasOne(FeatureGroup::className(), ['id' => 'feature_group']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPermissions()
    {
        return $this->hasMany(Permission::className(), ['feature' => 'id']);
    }
}
