<?php

namespace frontend\controllers;
use yii;
use common\models\base\Member;
use common\models\base\Payments;
use common\models\base\PaymentDetail;
use yii\helpers\Url;
use frontend\models\ChangePassword;

class ProfileController extends \yii\web\Controller
{
	public function behavior()
	{
		$this->layout = 'main';
	}

	public function actionIndex()
	{
		$this->view->params['menu'] = 'profile';

		$model 		= new ChangePassword();
		$message 	= '';

		if ( Yii::$app->request->post() )
		{
			if ( $model->load(Yii::$app->request->post()) && $model->updateprofile() ) 
			{
				Yii::$app->session->setFlash('success', "Profile Updated!");
			} 
			else 
			{
				Yii::$app->session->setFlash('error', "Error While Updating Profile!");
			}
		}

		$fixed 		= Member::find()
						->select('*')
						->andwhere(['status' => Member::STATUS_ACTIVE])
						->andwhere(['id' => Yii::$app->user->identity->id])
						->one();

		return $this->render('index', [
			'fixed' 			=> $fixed, 
			'updatepassword' 	=> $model, 
			'updateprofile' 	=> $model,
		]);
	}

	public function actionChangepassword()
	{
		$this->view->params['menu'] = 'profile';

		$model 		= new ChangePassword();
		$message 	= '';

		if ( Yii::$app->request->post() )
		{
			if ( $model->load(Yii::$app->request->post()) && $model->updatepassword() ) 
			{
				Yii::$app->session->setFlash('success', "Password Changed!");
			} 
			else 
			{
				Yii::$app->session->setFlash('error', "Error While Changing Password!");
			}
		}

		$fixed 		= Member::find()
						->select('*')
						->andwhere(['status' => Member::STATUS_ACTIVE])
						->andwhere(['id' => Yii::$app->user->identity->id])
						->one();

		return $this->render('index', [
			'fixed' 			=> $fixed, 
			'updatepassword' 	=> $model, 
			'updateprofile' 	=> $model,
		]);
	}

	public function actionPurchase()
	{
		$this->view->params['menu'] = 'purchase';

		$purchase 	= Payments::find()->all();

		return $this->render('purchase', ['purchase' => $purchase]);
	}

	public function actionDownload()
	{
		$this->view->params['menu'] = 'download';
		return $this->render('download');
	}

	public function object_to_array($data){
	    if (is_array($data) || is_object($data))
	    {
	        $result = array();
	        foreach ($data as $key => $value)
	        {
	            $result[$key] = $this->object_to_array($value);
	        }
	        return $result;
	    }
	    return $data;
	}
}