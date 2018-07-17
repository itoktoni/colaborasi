<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\base\Voucher;

/**
 * VoucherSearch represents the model behind the search form of `common\models\base\Voucher`.
 */
class VoucherSearch extends Voucher
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'voucher_type', 'discount_type', 'discount_counter', 'status'], 'integer'],
            [['name', 'code', 'description', 'start_date', 'end_date', 'created_at', 'updated_at'], 'safe'],
            [['discount_prosentase', 'discount_price'], 'number'],
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
        $query = Voucher::find()
        ->where(['>=',self::tableName().'.status',self::STATUS_INACTIVE]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->load($params,'');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'voucher_type' => $this->voucher_type,
            'discount_type' => $this->discount_type,
            'discount_counter' => $this->discount_counter,
            'discount_prosentase' => $this->discount_prosentase,
            'discount_price' => $this->discount_price,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
