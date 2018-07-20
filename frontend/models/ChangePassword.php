<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

class ChangePassword extends Model {
	public $current_password;
	public $password;
	public $confirm_password;
	public $firstname;
	public $lastname;
	public $phone;

	public function rules()
	{
		return  [
			[['confirm_password','password','current_password'],'required'],
			['password, confirm_password', 'string','min' => 6],
			['confirm_password', 'compare','compareAttribute' => 'password',  'message'=>"Password don't match"],
			[['firstname', 'lastname', 'phone'], 'string','max' => 200],
		];
	}

	public function updatepassword()
	{
		$model 			= new User();
		$current_user 	= $model->find()->where(['id' => Yii::$app->user->identity->id])->one();

		if ( !$current_user )
		{
			return false;
		}

		$current_user->setPassword($this->password);
		$current_user->save();

		return $current_user->username;
	}

	public function updateprofile()
	{
		$model 			= new User();
		$current_user 	= $model->find()->where(['id' => Yii::$app->user->identity->id])->one();

		if ( !$current_user )
		{
			return false;
		}

		$current_user->setFirstname($this->firstname);
		$current_user->setLastname($this->lastname);
		$current_user->setPhone($this->phone);
		$current_user->save();

		return $current_user->username;
	}
}