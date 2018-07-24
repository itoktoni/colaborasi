<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\base\MemberDownload;

/**
 * DownloadSearch represents the model behind the search form of `common\models\base\MemberDownload`.
 */
class DownloadSearch extends MemberDownload
{

    public $product_name;
    public $counter;
    public $date_range;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'member', 'status'], 'integer'],
            [['key', 'product', 'expiration_date', 'create_at', 'updated_at','date_range'], 'safe'],
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
    public function search($params, $getresult = true)
    {
        $query = MemberDownload::find()->select(['member_download.*,product.name product_name,COUNT(*) counter'])->join('left join','product','member_download.product=product.id');
        // ->where(['>=',self::tableName().'.status',self::STATUS_INACTIVE]);
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
        if (isset($params['sort_order']) && $params['sort_order']) {
            switch ($params['sort_order']) {
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

        $query->groupBy(['product']);

        $this->load($params,'');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        
        if ($this->date_range) {
            $date = explode(' to ', $this->date_range);
            if (!$this->__validateDate($date[0]) && !$this->__validateDate($date[1])) {
                throw new Exception("Bad date format", 403);
            }

            if ($date[0] === $date[1]) {
                $query->where(['date(create_at)' => $date[0]]);
            } else {
                $query->where(['between', 'date(create_at)', $date[0], $date[1]]);
            }
        }

        if ($this->product) {
            $query->where(['product.name' => $this->product]);
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            // 'product' => $this->product,
            'member' => $this->member,
            'expiration_date' => $this->expiration_date,
            'create_at' => $this->create_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'key', $this->key]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function getchart($params, $getresult = true)
    {
        $query = MemberDownload::find()->select(['member_download.*,product.name product_name,COUNT(*) counter'])
        ->join('left join','product','member_download.product=product.id');
        // ->where(['>=',self::tableName().'.status',self::STATUS_INACTIVE]);
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
        if (isset($params['sort_order']) && $params['sort_order']) {
            switch ($params['sort_order']) {
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

        $query->groupBy(['product']);

        $this->load($params,'');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        if ($this->date_range) {
            $date = explode(' to ', $this->date_range);
            if (!$this->__validateDate($date[0]) && !$this->__validateDate($date[1])) {
                throw new Exception("Bad date format", 403);
            }

            if ($date[0] === $date[1]) {
                $query->where(['date(create_at)' => $date[0]]);
            } else {
                $query->where(['between', 'date(create_at)', $date[0], $date[1]]);
            }
        }

        if ($this->product) {
            $query->where(['product.name' => $this->product]);
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            // 'product' => $this->product,
            'member' => $this->member,
            'expiration_date' => $this->expiration_date,
            'create_at' => $this->create_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'key', $this->key]);

        return $dataProvider;
    }

    /**
     * [__validateDate description]
     * @param  [type] $date   [description]
     * @param  string $format [description]
     * @return [type]         [description]
     */
    private function __validateDate($date, $format = 'Y-m-d')
    {
        $d = \DateTime::createFromFormat($format, $date);
        try {
            if (!strtotime($date)) {
                throw new Exception("Bad date format", 403);
            }

        } catch (Exception $e) {
            throw new Exception("Bad date format", 403);
        }
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }
    
}
