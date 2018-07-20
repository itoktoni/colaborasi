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
			if ( $model->load(Yii::$app->request->post()) && $model->updatepassword() ) 
			{
				$message = 'Password Successfully Changed';
			} 
			else 
			{
				$model->addError('current_password',"Your password doesn't match previous one");
			}

			if ( $model->load(Yii::$app->request->post()) && $model->updateprofile() ) 
			{
				$message = 'Profile Updated.';
			} 
			else 
			{
				$message = 'Failed to Update Profile.';
			}
		}

		$fixed 		= Member::find()
						->select('*')
						->andwhere(['status' => Member::STATUS_ACTIVE])
						->andwhere(['id' => Yii::$app->user->identity->id])
						->one();

		$purchase 	= Payments::find()->all();

		return $this->render('index', [
			'fixed' 			=> $fixed, 
			'updatepassword' 	=> $model, 
			'updateprofile' 	=> $model,
			'message' 			=> $message,
			'purchase' 			=> $purchase,
		]);

		//return $this->render('index');
	}

	public function actionPurchase()
	{
		$this->view->params['menu'] = 'purchase';
		return $this->render('purchase');
	}

	public function actionDownload()
	{
		$this->view->params['menu'] = 'download';
		return $this->render('download');
	}

	public function actionAjaxdetail()
	{
		$post 	= Yii::$app->request->post();
		$id 	= $post['id'];

		$items 	= Payments::find()->where(['id' => $id])->all();
		foreach ($items as $item) :
			$payment_id = $item->payment_id;
			$discount 	= $item->discount;
		endforeach;

		$datas 	= PaymentDetail::find()->where(['payment_id' => $payment_id])->all();
		$total 	= 0;
		
		$html 	= '';
		$html 	= '
		<section class="popup-detail">
			<div class="wrapper-detail">
				<div class="center-detail container">
					<div class="close" onclick="close_popup_detail()">
						<img class="image" src="'.Url::to("@web/images/img/cancel.svg").'">
					</div>
					<div class="content-detail">
						<table class="table-detail">
							<thead class="header">
								<tr>
									<th class="w15">Item</th>
									<th class="w35">Description</th>
									<th class="w20">Price</th>
									<th class="w10">Quantity</th>
									<th class="w20">Sub Total</th>
								</tr>
							</thead>
							<tbody>';

		foreach ( $datas as $key => $data) :

			$detail = $this->object_to_array(json_decode($data['data']));

			$html 	.= '
								<tr>
									<td class="w15">
										<a href="#">
											<img class="image" src="'.Url::to('@uploadfile/'.$detail['image'].'').'">
										</a>
									</td>
									<td class="w35">
										<p class="title">'.$detail['name'].'</p>
										<p class="code">Code: '.$detail['code'].'</p>
									</td>
									<td class="w20">
										<p class="price">IDR '.number_format($data['sell_price'],0,'','.').'</p>
									</td>
									<td class="w10">
										<p class="qty">1</p>
									</td>
									<td class="w20">
										<p class="sub">IDR '.number_format($data['sell_price'],0,'','.').'</p>
									</td>
								</tr>';

			$total = $total + $data['sell_price'];

		endforeach;

		$grand_total = $total - $discount;

		$html 	.= '
								<tr class="noborder">
									<td colspan="4" class="label-cart" style="padding-top: 30px;">Cart Sub Total</td>
									<td class="w20 data-cart" style="padding-top: 30px;">IDR '.number_format($total,0,'','.').'</td>
								</tr>
								<tr class="noborder">
									<td colspan="4" class="label-cart">Discount</td>
									<td class="w20 data-cart">IDR '.number_format($discount,0,'','.').'</td>
								</tr>
								<tr class="noborder">
									<td colspan="4" class="label-cart"><strong>Total</strong></td>
									<td class="w20 data-cart"><span>IDR '.number_format($grand_total,0,'','.').'</span></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</section>';
		
		$return['content'] = $html;
		echo json_encode($return);
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