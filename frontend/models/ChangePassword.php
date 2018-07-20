<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\base\Member;

class ChangePassword extends Model {
	public $current_password;
	public $password;
	public $confirm_password;
	public $name;
	public $address;
	public $phone_number;

	public function rules()
	{
		return  [
			[['confirm_password','password','current_password'],'required'],
			['password, confirm_password', 'string','min' => 6],
			['confirm_password', 'compare','compareAttribute' => 'password',  'message'=>"Password don't match"],
			[['name', 'address', 'phone_number'], 'string','max' => 255],
		];
	}

	public function updatepassword()
	{
		$model 			= new Member();
		$current_user 	= $model->find()->where(['id' => Yii::$app->user->identity->id])->one();

		if ( !$current_user )
		{
			return false;
		}

		$current_user->setPassword($this->password);
		$current_user->save();

		return $current_user->email;
	}

	public function updateprofile()
	{
		$model 			= new Member();
		$current_user 	= $model->find()->where(['id' => Yii::$app->user->identity->id])->one();

		if ( !$current_user )
		{
			return false;
		}

		$current_user->setName($this->name);
		$current_user->setAddress($this->address);
		$current_user->setPhone($this->phone_number);
		$current_user->save();

		return $current_user->email;
	}
}