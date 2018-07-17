<?php

namespace frontend\controllers;

use Yii;
use common\models\base\Product;
use common\models\base\Voucher;
use yii\web\ForbiddenHttpException;

class CartController extends \yii\web\Controller
{
	public $session;

	public function init(){
		$this->session = Yii::$app->session;
	}

	public function actionIndex()
	{
		$this->view->params['menu'] = 'cart';
		return $this->render('index',['cart' => $this->session->get('cart')]);
	}

	public function actionAdd($item = FALSE, $qty = 1)
	{
		// echo $qty;
		// die();

		if (!Yii::$app->request->post())
		{
			if (!$item)
			{
				throw new ForbiddenHttpException;
			}
		}
		else
		{
			$item 	= Yii::$app->request->post('product');
			$qty 	= Yii::$app->request->post('qty');
			if (!$item)
			{
				throw new ForbiddenHttpException;
			}
		}

		$product 	= Product::findOne($item);
		if (!$product)
		{
			throw new ForbiddenHttpException;;
		}		

		$cart 		= $this->session->get('cart');

		if ($cart)
		{
			$my_cart = $cart;
		}
		else
		{
			$my_cart = [];
		}

		if (isset($my_cart[$item]))
		{
			Yii::$app->session->setFlash('error', 'Product already added to cart!');
			return $this->redirect(Yii::$app->request->referrer);
		}
		else
		{
			$my_cart[$item] = 
			[
				'id' 	=> $product->id,  
				'slug' 	=> $product->slug, 
				'image' => $product->image_thumbnail, 
				'name' 	=> $product->name, 
				'price' => $product->price, 
				'qty' 	=> $qty
			];
		}
		

		$this->session->set('cart', $my_cart);
		if(Yii::$app->request->post('action')){
			
			if (Yii::$app->request->post('action') == 'Add to cart')
			{
				return $this->redirect(Yii::$app->request->referrer);
			}

			if (Yii::$app->request->post('action') == 'Get Product')
			{
				return $this->redirect('/checkout');
			}
		}
		Yii::$app->session->setFlash('success', 'Product Added to cart!');
		$this->redirect(Yii::$app->request->referrer);
	}

	public function actionDelete($item = FALSE)
	{
		$cart = $this->session->get('cart');
		unset($cart[$item]);
		$this->session->set('cart', $cart);
		Yii::$app->session->setFlash('success', 'Product removed from cart!');
		$this->redirect(Yii::$app->request->referrer);
	}

	public function actionUpdate($item, $qty)
	{
		$cart = $this->session->get('cart');
		$cart[$item]['qty'] = $qty;
		$this->session->set('cart', $cart);
	}

	public function actionDestroy()
	{
		$this->session->destroy();
	}

	public function actionVoucher(){
		if(Yii::$app->request->post('voucher')){
			$voucher = Voucher::find()->select(['name','code','discount_prosentase','discount_price'])->where(['code' => Yii::$app->request->post('voucher')])->one();

			if(!$voucher){
				Yii::$app->session->setFlash('error', 'Voucher is not found!');
			}else{
				Yii::$app->session->setFlash('success', 'Voucher '.$voucher->name.' Applied.');
				Yii::$app->session->set('voucher', $voucher);
			}
		}else{
			Yii::$app->session->setFlash('error', 'Error when applying voucher.');
		}
		
		$this->redirect(['/cart']);
	}

	public function actionVouchercancel(){
		Yii::$app->session->set('voucher', false);
		Yii::$app->session->setFlash('success', 'Voucher is canceled.');
		$this->redirect(['/cart']);
	}

	public function actionCheckout()
	{
		$this->view->params['menu'] = 'checkout';
		if(Yii::$app->user->isGuest)
		{
			Yii::$app->session->setFlash('error', 'Please login first before proceed to checkout');
			return $this->redirect(['/site/login']);
		}

		if(!$this->session->get('cart'))
		{
			Yii::$app->session->setFlash('error', 'Please order something first before proceed to checkout');
			return $this->redirect(['/cart']);
		}

		$province = Yii::$app->runAction('/ongkir/province');
		return $this->render('checkout',[
			'cart' => $this->session->get('cart'),
			'province' => json_decode($province),
		]);
	}
}

?>