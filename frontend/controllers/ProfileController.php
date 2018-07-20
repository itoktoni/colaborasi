<?php

namespace frontend\controllers;
use yii;
use common\models\base\Member;
use common\models\base\MemberDownload;
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
		$downloads = MemberDownload::find()->select(['key', 'expiration_date','member_download.create_at','member_download.updated_at', 'member_download.status', 'product.name product_name'])->join('left join', 'product','member_download.product=product.id')->where(['member' => YII::$app->user->identity->id])->orderBy(['member_download.id' => SORT_DESC])->all();
		$this->view->params['menu'] = 'download';
		return $this->render('download', ['downloads' => $downloads]);
	}

	public function actionGrab()
	{	

		$access_token = Yii::$app->request->get('key');

		if(!$access_token){
			throw new yii\web\ForbiddenHttpException;
		}


		$download_link = MemberDownload::find()
		->select(['member_download.*', 'product.name product_name','product.product_download_url download_url'])
		->join('left join', 'product','member_download.product=product.id')
		->where(['member' => YII::$app->user->identity->id,'key' => $access_token])->one();

		if($download_link)
		{
			if($download_link->status > 0){
				$download_link->expiration_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +1 day'));
				$download_link->status = 0;
				$download_link->save();
			}

			if(!$download_link->status && strtotime(date('Y-m-d H:i:s')) > strtotime($download_link->expiration_date)){
				$download_link->save();
				throw new yii\web\ForbiddenHttpException;
			}
			
			
			if(!$download_link->download_url){
				throw new yii\web\NotFoundHttpException;
			}
			$dl = explode("/",$download_link->download_url);
			$url = count($dl)-1;
			$idz = count($dl)-2;
			return $this->redirect(str_replace($dl[$idz].'/'.$dl[$url],'fl_attachment/'.$dl[$idz].'/'.$dl[$url], $download_link->download_url));
		}else{
			throw new yii\web\ForbiddenHttpException;
		}		
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