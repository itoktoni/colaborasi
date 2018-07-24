<?php

namespace common\models\base;

use common\models\base\Payments;
use yii\base\Exception;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PaymentSearch represents the model behind the search form of `common\models\base\Payments`.
 */
class PaymentSearch extends Payments
{

    public $date_range;
    public $counter;
    public $price_range_start;
    public $price_range_to;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'payment_type', 'shipping_type', 'user', 'user_social_media_type', 'voucher', 'voucher_discount_type', 'tax_amount', 'payment_status', 'status'], 'integer'],
            [['invoice', 'user_name', 'user_address', 'user_email', 'user_social_media_id', 'voucher_name', 'paypal_payment_id', 'paypal_amount_dollar', 'paypal_amount_rupiah', 'paypal_payer_id', 'paypal_payer_email', 'paypal_token', 'shipping_province', 'shipping_city', 'shipping_courier', 'shipping_courier_service', 'shipping_receiver', 'shipping_address', 'shipping_phone_number', 'shipping_email', 'cc_transaction_id', 'cc_number', 'cc_month', 'cc_year', 'created_at', 'updated_at', 'date_range', 'price_range_start', 'price_range_to'], 'safe'],
            [['voucher_discount_value', 'total_bruto', 'total_bruto_dollar', 'total_discount_rupiah', 'total_discount_dollar', 'total_tax_rupiah', 'total_tax_dollar', 'total_shipping_rupiah', 'total_shipping_dollar', 'total_net_rupiah', 'total_net_dollar'], 'number'],
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
        $query = Payments::find();
        // ->where(['>=',self::tableName().'.status',self::STATUS_INACTIVE]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->load($params, '');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->price_range_start) {
            if ($this->price_range_to) {
                $query->where(['>=', 'total_net_rupiah', $this->price_range_start]);
            } else {
                $query->where(['between', 'total_net_rupiah', $this->price_range_start, $this->price_range_to]);
            }
        }

        if ($this->date_range) {
            $date = explode(' to ', $this->date_range);
            if (!$this->__validateDate($date[0]) && !$this->__validateDate($date[1])) {
                throw new Exception("Bad date format", 403);
            }

            if ($date[0] === $date[1]) {
                $query->where(['date(created_at)' => $date[0]]);
            } else {
                $query->where(['between', 'created_at', $date[0], $date[1]]);
            }
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'payment_type' => $this->payment_type,
            'shipping_type' => $this->shipping_type,
            'user' => $this->user,
            'user_social_media_type' => $this->user_social_media_type,
            'voucher' => $this->voucher,
            'voucher_discount_type' => $this->voucher_discount_type,
            'voucher_discount_value' => $this->voucher_discount_value,
            'tax_amount' => $this->tax_amount,
            'total_bruto' => $this->total_bruto,
            'total_bruto_dollar' => $this->total_bruto_dollar,
            'total_discount_rupiah' => $this->total_discount_rupiah,
            'total_discount_dollar' => $this->total_discount_dollar,
            'total_tax_rupiah' => $this->total_tax_rupiah,
            'total_tax_dollar' => $this->total_tax_dollar,
            'total_shipping_rupiah' => $this->total_shipping_rupiah,
            'total_shipping_dollar' => $this->total_shipping_dollar,
            'total_net_rupiah' => $this->total_net_rupiah,
            'total_net_dollar' => $this->total_net_dollar,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'payment_status' => $this->payment_status,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'invoice', $this->invoice])
            ->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'user_address', $this->user_address])
            ->andFilterWhere(['like', 'user_email', $this->user_email])
            ->andFilterWhere(['like', 'user_social_media_id', $this->user_social_media_id])
            ->andFilterWhere(['like', 'voucher_name', $this->voucher_name])
            ->andFilterWhere(['like', 'paypal_payment_id', $this->paypal_payment_id])
            ->andFilterWhere(['like', 'paypal_amount_dollar', $this->paypal_amount_dollar])
            ->andFilterWhere(['like', 'paypal_amount_rupiah', $this->paypal_amount_rupiah])
            ->andFilterWhere(['like', 'paypal_payer_id', $this->paypal_payer_id])
            ->andFilterWhere(['like', 'paypal_payer_email', $this->paypal_payer_email])
            ->andFilterWhere(['like', 'paypal_token', $this->paypal_token])
            ->andFilterWhere(['like', 'shipping_province', $this->shipping_province])
            ->andFilterWhere(['like', 'shipping_city', $this->shipping_city])
            ->andFilterWhere(['like', 'shipping_courier', $this->shipping_courier])
            ->andFilterWhere(['like', 'shipping_courier_service', $this->shipping_courier_service])
            ->andFilterWhere(['like', 'shipping_receiver', $this->shipping_receiver])
            ->andFilterWhere(['like', 'shipping_address', $this->shipping_address])
            ->andFilterWhere(['like', 'shipping_phone_number', $this->shipping_phone_number])
            ->andFilterWhere(['like', 'shipping_email', $this->shipping_email])
            ->andFilterWhere(['like', 'cc_transaction_id', $this->cc_transaction_id])
            ->andFilterWhere(['like', 'cc_number', $this->cc_number])
            ->andFilterWhere(['like', 'cc_month', $this->cc_month])
            ->andFilterWhere(['like', 'cc_year', $this->cc_year]);

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
        $query = Payments::find()->select(['date(payment.created_at) created_at,COUNT(*) counter']);
        // ->where(['>=',self::tableName().'.status',self::STATUS_INACTIVE]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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

        $this->load($params, '');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->price_range_start) {
            if ($this->price_range_to) {
                $query->where(['>=', 'total_net_rupiah', $this->price_range_start]);
            } else {
                $query->where(['between', 'total_net_rupiah', $this->price_range_start, $this->price_range_to]);
            }
        }

        if ($this->date_range) {
            $date = explode(' to ', $this->date_range);
            if (!$this->__validateDate($date[0]) && !$this->__validateDate($date[1])) {
                throw new Exception("Bad date format", 403);
            }

            if ($date[0] === $date[1]) {
                $query->where(['date(created_at)' => $date[0]]);
            } else {
                $query->where(['between', 'date(created_at)', $date[0], $date[1]]);
            }
        }

        $query->groupBy(['date(created_at)']);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'payment_type' => $this->payment_type,
            'shipping_type' => $this->shipping_type,
            'user' => $this->user,
            'user_social_media_type' => $this->user_social_media_type,
            'voucher' => $this->voucher,
            'voucher_discount_type' => $this->voucher_discount_type,
            'voucher_discount_value' => $this->voucher_discount_value,
            'tax_amount' => $this->tax_amount,
            'total_bruto' => $this->total_bruto,
            'total_bruto_dollar' => $this->total_bruto_dollar,
            'total_discount_rupiah' => $this->total_discount_rupiah,
            'total_discount_dollar' => $this->total_discount_dollar,
            'total_tax_rupiah' => $this->total_tax_rupiah,
            'total_tax_dollar' => $this->total_tax_dollar,
            'total_shipping_rupiah' => $this->total_shipping_rupiah,
            'total_shipping_dollar' => $this->total_shipping_dollar,
            'total_net_rupiah' => $this->total_net_rupiah,
            'total_net_dollar' => $this->total_net_dollar,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'payment_status' => $this->payment_status,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'invoice', $this->invoice])
            ->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'user_address', $this->user_address])
            ->andFilterWhere(['like', 'user_email', $this->user_email])
            ->andFilterWhere(['like', 'user_social_media_id', $this->user_social_media_id])
            ->andFilterWhere(['like', 'voucher_name', $this->voucher_name])
            ->andFilterWhere(['like', 'paypal_payment_id', $this->paypal_payment_id])
            ->andFilterWhere(['like', 'paypal_amount_dollar', $this->paypal_amount_dollar])
            ->andFilterWhere(['like', 'paypal_amount_rupiah', $this->paypal_amount_rupiah])
            ->andFilterWhere(['like', 'paypal_payer_id', $this->paypal_payer_id])
            ->andFilterWhere(['like', 'paypal_payer_email', $this->paypal_payer_email])
            ->andFilterWhere(['like', 'paypal_token', $this->paypal_token])
            ->andFilterWhere(['like', 'shipping_province', $this->shipping_province])
            ->andFilterWhere(['like', 'shipping_city', $this->shipping_city])
            ->andFilterWhere(['like', 'shipping_courier', $this->shipping_courier])
            ->andFilterWhere(['like', 'shipping_courier_service', $this->shipping_courier_service])
            ->andFilterWhere(['like', 'shipping_receiver', $this->shipping_receiver])
            ->andFilterWhere(['like', 'shipping_address', $this->shipping_address])
            ->andFilterWhere(['like', 'shipping_phone_number', $this->shipping_phone_number])
            ->andFilterWhere(['like', 'shipping_email', $this->shipping_email])
            ->andFilterWhere(['like', 'cc_transaction_id', $this->cc_transaction_id])
            ->andFilterWhere(['like', 'cc_number', $this->cc_number])
            ->andFilterWhere(['like', 'cc_month', $this->cc_month])
            ->andFilterWhere(['like', 'cc_year', $this->cc_year]);

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
