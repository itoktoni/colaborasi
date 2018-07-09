<?php
namespace backend\components;

use yii;
use yii\helpers\Html;
use common\models\Category;
use backend\models\base\Permission;

class CMS {

    private static $_menu = '';

    const VOUCHER_ONETIMEUSAGE = 1, VOUCHER_TIMELINE = 2, VOUCHER_COUNTERBASED = 3;
    const STATUS_INACTIVE = 0, STATUS_ACTIVE = 1, STATUS_DELETED = -9;
    const TOPUP_REJECTED = -1, TOPUP_WAITING = 0, TOPUP_USER_CONFIRMED = 1, TOPUP_ADMIN_CONFIRMED = 2, TOPUP_FINISH = 3;
    const REVIEW_ACCEPTED = 1, REVIEW_WAITING = 0, REVIEW_DELETED = -9;
    const PAYMENT_BALANCE = 1, PAYMENT_PAYPAL = 2;
    const BANK_BCA = 1,BANK_MANDIRI = 2;
    const DISCOUNT_PERCENTAGE = 1, DISCOUNT_FIXED = 2;

    /**
    * [getMenu description]
    * @return [type] [description]
    */
    public function getMenu(){
        $session = Yii::$app->session;
        return $session['menu'];
    }

    public function getOtherMenu(){
        return ['Brand' => 'brand', 'Contact' => 'contact'];
    }

    public function activeMenu($source, $comparator, $stringreturn = 'class="active"', $default = false){
        if($source == $comparator){
            return $stringreturn;
        }
        return $default;
    }

    /**
    * [check_permission description]
    * @param  [type] $access_type [description]
    * @return [type]              [description]
    */
    public function check_permission($access_type = Permission::FULL_ACCESS){
        $session = Yii::$app->session;
        if(!isset($session['menu']['list'][strtolower(Yii::$app->controller->id)])){
            return false;
        }
        if($session['menu']['list'][strtolower(Yii::$app->controller->id)]['access'] == $access_type){
            return TRUE;
        }
        return false;
    }

    /**
    * [get_permission description]
    * @return [type] [description]
    */
    public function get_permission(){
        $session = Yii::$app->session;
        return $session['menu']['list'][strtolower(Yii::$app->controller->id)]['access'];  
    }

    public function getStatusTopup($var){
        return CMS::statusTopup()[$var];
    }

    public function statusTopup(){
        [CMS::TOPUP_REJECTED => "Rejected", CMS::TOPUP_WAITING => "Waiting for Payment",  CMS::TOPUP_USER_CONFIRMED => "Confirmed by User", CMS::TOPUP_ADMIN_CONFIRMED => "Confirmed by Admin", CMS::TOPUP_FINISH => "Confirmed by Finished"];
    }

    /**
    * [paymentType description]
    * @return [type] [description]
    */
    public function paymentType(){
        return [CMS::PAYMENT_BALANCE =>'Balance', CMS::PAYMENT_PAYPAL => 'Paypal'];
    }

    /**
    * [getPaymentType description]
    * @param  [type] $var [description]
    * @return [type]      [description]
    */
    public function getPaymentType($var){
        return CMS::paymentType()[$var];
    }

    /**
    * [getStatusReview description]
    * @param  [type] $var [description]
    * @return [type]      [description]
    */
    public function getStatusReview($var){
        return CMS::statusReview()[$var];
    }

    public function statusReview(){
        return [CMS::REVIEW_ACCEPTED => "Accepted",CMS::REVIEW_WAITING => "Waiting for Review",CMS::REVIEW_DELETED => 'Deleted'];
    }

    /**
    * [getPaymentBank description]
    * @return [type] [description]
    */
    public function getPaymentBank($var){
        return (isset(CMS::paymentBank()[$var]))?CMS::paymentBank()[$var]:false;
    }

    public function paymentBank(){
        return [CMS::BANK_BCA => 'BCA',CMS::BANK_MANDIRI => 'Mandiri'];
    }

    public function status($deleted = false){
        if($deleted){
            return [CMS::STATUS_ACTIVE => 'Active',CMS::STATUS_INACTIVE => 'Inactive',CMS::STATUS_DELETED => 'Deleted'];
        }
        return [CMS::STATUS_ACTIVE => 'Active',CMS::STATUS_INACTIVE => 'Inactive'];
    }

    public function paymentWidget(){
        return Html::dropDownList('payment' ,CMS::paymentType());
    }

    public function statusWidget(){
        return Html::dropDownList('status' ,CMS::status());
    }

    /**
    * [voucher_type description]
    * @return [type] [description]
    */
    public function voucher_type(){
        return [CMS::VOUCHER_ONETIMEUSAGE => 'One time Usage', CMS::VOUCHER_TIMELINE => 'Timeline',CMS::VOUCHER_COUNTERBASED => 'Counter Based'];
    }

    /**
    * [get_voucher_type description]
    * @param  [type] $type [description]
    * @return [type]       [description]
    */
    public function get_voucher_type($type){
        return CMS::voucher_type()[$type];
    }

    public function discount_type(){
        return [CMS::DISCOUNT_PERCENTAGE => 'Percentage', CMS::DISCOUNT_FIXED => 'Fixed'];
    }

    /**
    * [get_voucher_type description]
    * @param  [type] $type [description]
    * @return [type]       [description]
    */
    public function get_discount_type($type)
    {
        return CMS::discount_type()[$type];
    }

    /**
    * [getDiscountType description]
    * @param  [type] $type [description]
    * @return [type]       [description]
    */
    public function getDiscountType($type){
        return CMS::get_discount_type($type);
    }

    public function getStatus($status){
        return CMS::status(true)[$status];
    }

}
?>