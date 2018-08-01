<?php

namespace backend\controllers;
use yii;

class ApiController extends \yii\web\Controller
{	
	public function actionIndex()
	{
		return $this->render('index');
	}

	public function tesT(){

		
	}


	
	public function actionVoucher(){
		return $this->__request(new \common\models\base\Voucher, Yii::$app->request->get('keyword'));
	}


	public function actionBrand(){
		return $this->__request(new \common\models\base\Brand, Yii::$app->request->get('keyword'));
	}

	public function actionCategory(){
		return $this->__request(new \common\models\base\Category, Yii::$app->request->get('keyword'));
	}

	public function actionProduct(){
		return $this->__request(new \common\models\base\Product, Yii::$app->request->get('keyword'));
	}


	public function __request($model, $keyword = false)
	{
		if($keyword){
			$result = $model::find()->where(['like','name', $keyword])->asArray()->all();
		}else{
			$result = $model::find()->where(['status' => 1])->asArray()->all();
		}
		$response = Yii::$app->response;
		$response->format = \yii\web\Response::FORMAT_JSON;
		$response->data = $result;

		return $response;
	}
}
