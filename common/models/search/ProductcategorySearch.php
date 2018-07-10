<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\base\Productcategory;

/**
 * ProductcategorySearch represents the model behind the search form of `common\models\base\Productcategory`.
 */
class ProductcategorySearch extends Productcategory
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'product', 'sub_category'], 'integer'],
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
        $query = Productcategory::find()
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
                case "recent":
                $dataProvider->setSort(['defaultOrder' => ['updated_at' => SORT_DESC]]);
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
            'product' => $this->product,
            'sub_category' => $this->sub_category,
        ]);

        return $dataProvider;
    }
}
