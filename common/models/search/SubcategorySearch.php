<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\base\Subcategory;

/**
 * SubcategorySearch represents the model behind the search form of `common\models\base\Subcategory`.
 */
class SubcategorySearch extends Subcategory
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category', 'status'], 'integer'],
            [['slug', 'name', 'description', 'created_at', 'updated_at'], 'safe'],
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
        $query = Subcategory::find()
        ->select(['sub_category.*','category.name category_name'])
        ->join('left join','category','sub_category.category=category.id')
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
            self::tableName().'.id' => $this->id,
            'category' => $this->category,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            self::tableName().'.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
