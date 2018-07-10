<?php

namespace backend\models\search;

use backend\models\base\Feature;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * FeatureSearch represents the model behind the search form of `backend\models\base\Feature`.
 */
class FeatureSearch extends Feature
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'feature_group', 'sort', 'status'], 'integer'],
            [['name', 'slug', 'icon'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Feature::find()
        ->where(['>=',self::tableName().'.status',self::STATUS_INACTIVE]);

        // add conditions that should always apply here
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        
        /**
         * Force Sorting
         */
        if(isset($params['sort_order']) && $params['sort_order']){
            switch($params['sort_order']){
                case "asc":
                $dataProvider->setSort(['defaultOrder' => ['id' => SORT_ASC]]);
                break;
                case "desc":
                $dataProvider->setSort(['defaultOrder' => ['id' => SORT_DESC]]);
                break;
            }
            
            unset($params['sort_order']);
        }

        $this->load($params,'');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'feature_group' => $this->feature_group,
            'sort' => $this->sort,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'icon', $this->icon]);

        return $dataProvider;
    }
}
