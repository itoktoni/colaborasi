<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\base\Product;

/**
 * ProductSearch represents the model behind the search form of `common\models\base\Product`.
 */
class ProductSearch extends Product
{

    public $min;
    public $max;


    public $result;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'brand', 'headline', 'product_view', 'status','category','subcategory'], 'integer'],
            [['min','max'], 'number'],
            [['slug', 'name', 'synopsis', 'description', 'image', 'image_path', 'image_thumbnail', 'image_portrait', 'meta_description', 'meta_keyword', 'product_download_url', 'product_download_path', 'created_at', 'updated_at'], 'safe'],
            [['price', 'price_discount'], 'number'],
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
        $query = Product::find();

        if(isset($params['subcategory']) && $params['subcategory'])
        {
            
            $query->joinWith('productCategories');
        }
        
        $query->where(['>=',self::tableName().'.status',self::STATUS_INACTIVE]);
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

                case "popular":
                $dataProvider->setSort(['defaultOrder' => ['product_view' => SORT_DESC]]);
                break;                
                
                case "price_low":
                $dataProvider->setSort(['defaultOrder' => ['price' => SORT_ASC]]);
                break;                
                case "price_high":
                $dataProvider->setSort(['defaultOrder' => ['price' => SORT_DESC]]);
                break;                
            } 
            
            unset($params['sort_order']);
        }

        if(isset($params['min']) && isset($params['max']) && $params['min'] && $params['max']){
            $query->andFilterWhere(['>=', 'price', $params['min']]);
            $query->andFilterWhere(['<=', 'price', $params['max']]);
        }
        
        $this->load($params,'');

        if($this->subcategory){
            $query->andFilterWhere(['product_category.sub_category' => $this->subcategory]);
        }
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'price' => $this->price,
            'category' => $this->category,
            'price_discount' => $this->price_discount,
            'brand' => $this->brand,
            'headline' => $this->headline,
            'product_view' => $this->product_view,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'synopsis', $this->synopsis])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'image_path', $this->image_path])
            ->andFilterWhere(['like', 'image_thumbnail', $this->image_thumbnail])
            ->andFilterWhere(['like', 'image_portrait', $this->image_portrait])
            ->andFilterWhere(['like', 'meta_description', $this->meta_description])
            ->andFilterWhere(['like', 'meta_keyword', $this->meta_keyword])
            ->andFilterWhere(['like', 'product_download_url', $this->product_download_url])
            ->andFilterWhere(['like', 'product_download_path', $this->product_download_path]);
        $this->result = $dataProvider;
        return $dataProvider;
    }


    public function getMax(){
        // return $this->result->orderBy('price DESC')->one();
        return $query = Product::find()->select(['price'])->orderBy('price DESC')->one();
    }


    public function getMin(){
        return $query = Product::find()->select(['price'])->orderBy('price ASC')->one();
    }
}
