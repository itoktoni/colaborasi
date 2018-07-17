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

        $session = Yii::$app->session;
        
        $this->cart = Yii::$app->session->get('cart');

		// if session is not open, open session
		if ( !$session->isActive) { $session->open(); }

		return parent::beforeAction($action);
	}
}