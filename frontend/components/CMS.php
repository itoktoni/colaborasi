<?php
namespace frontend\components;


use Yii;
use yii\helpers\Html;
use common\models\base\Category;
use common\models\base\Subcategory;
use common\models\base\Brand;
use common\models\base\Payments;

class CMS {

    const VOUCHER_ONETIMEUSAGE = 1, VOUCHER_TIMELINE = 2, VOUCHER_COUNTERBASED = 3;
    const DISCOUNT_PERCENTAGE = 1, DISCOUNT_FIXED = 2;
    const SHIPPING_ON = 1, SHIPPING_OFF = 0;
    const PAYMENT_BALANCE = 2, PAYMENT_PAYPAL = 1, PAYMENT_CC = 3;
    const STATUS_ACTIVE = 1, STATUS_INACTIVE = 0, STATUS_DELETED = -9;

	public static function getCategory(){
        return Category::find()->where(['status' => Category::STATUS_ACTIVE])->orderBy(['name' => SORT_ASC])->limit(3)->all();
    }

    public static function getSubCategory(){
		$subcategory = Subcategory::find()
						->select(['sub_category.*','category_name' => 'category.name', 'category_slug' => 'category.slug'])
						->where(['category.status' => Category::STATUS_ACTIVE, 'sub_category.status' => Category::STATUS_ACTIVE])
						->join('left join','category','category.id=sub_category.category')
						->orderBy(['category.name' => SORT_ASC,'sub_category.name' => SORT_ASC])
						->all();

		$return = [];
		foreach($subcategory as $item) :
			$return[$item->category_slug][] = $item;
		endforeach;

		return $return;
	}

	public static function activeMenu($source, $comparator, $stringreturn = 'class="sale-noti"', $default = false){
        if($source == $comparator){
            return $stringreturn;
        }
        return $default;
    }

    public static function activeSidebar($source, $comparator, $stringreturn = 'active2', $default = false){
        if($source == $comparator){
            return $stringreturn;
        }
        return $default;
    }

    public static function getCountCart() 
    {
        $session    = Yii::$app->session;
        $items      = $session->get('cart');
        $count      = 0;
        if($items){
            foreach($items as $item){
                $count += 1;
            }
        }

        return $count;
    }

    public static function currencyConverter($from, $to, $amount)
    {
        $url    = file_get_contents('https://free.currencyconverterapi.com/api/v5/convert?q=' . $from . '_' . $to . '&compact=ultra');
        $json   = json_decode($url, true);
        $rate   = implode(" ",$json);
        $total  = $rate * $amount;
        $rounded = round($total,2); //optional, rounds to a whole number
        return $rounded; //or return $rounded if you kept the rounding bit from above
    }

    public static function getMaxID($table)
    {
        $max = Yii::$app->db->createCommand( 'SELECT max(id) max FROM '.$table.'' )->queryScalar();
        return $max;
    }

    public static function getInvoiceCode( $table, $field )
    {
        $valid = Payments::find()->one();
        if ( $valid ) :
            $year = date('y', time());
            $month = date('m', time());
            $date =  date('d', time());

            $invoicecode = Yii::$app->db->createCommand( 'SELECT max(substring('.$field.', 12, 4)) max 
                                                        FROM '.$table.'
                                                        WHERE substring('.$field.', 4, 2) = :year
                                                        AND substring('.$field.', 6, 2) = :month
                                                        AND substring('.$field.', 8, 2) = :day' )
                            ->bindValue(':year', $year)
                            ->bindValue(':month', $month)
                            ->bindValue(':day', $date)
                            ->queryScalar();

        else :
            $invoicecode = '';
        endif;

        if ( empty($invoicecode) )
        { 
            $code = 1; 
        }
        else 
        { 
            $code = $invoicecode + 1; 
        }

        $mixcode = "PAY".date("y",time()).date("m",time()).date("d",time());
        if($code < 10){
            $mixcode=$mixcode."000".$code;
        }elseif($code<100){
            $mixcode=$mixcode."00".$code;
        }elseif($code<1000){
            $mixcode=$mixcode."0".$code;
        }elseif($code<10000){
            $mixcode=$mixcode.$code;
        }

        return $mixcode;
    }

}