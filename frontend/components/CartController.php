<?php 

namespace frontend\components;

use Yii;
use yii\web\ForbiddenHttpException;

class CartController extends \yii\web\Controller
{

    public $_menu;
    public $cart;

	/**
	 * [init description]
	 * @return [type] [description]
	 */
	public function init()
	{
		
		
		
	}

	/**
	 * [beforeAction description]
	 * @param  [type] $action [description]
	 * @return [type]         [description]
	 */
    public function beforeAction($action)
    {

		$this->view->params['menu'] = false;

        $this->session = Yii::$app->session;
        
		$this->cart = Yii::$app->session->get('cart');
		if(!$this->cart){
			$this->cart = [];
		}

		// if session is not open, open session
		if ( !$this->session->isActive) { $this->session->open(); }

		return parent::beforeAction($action);
	}

	/**
	 * 
	 */
	public function getVoucher(){
		if(Yii::$app->session->get('voucher')){
			return Yii::$app->session->get('voucher');
		}

		return false;
	}

	public function getDiscount(){
		
	}
}