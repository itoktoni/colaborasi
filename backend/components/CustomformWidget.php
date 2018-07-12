<?php
namespace backend\components;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class CustomformWidget extends Widget{
	public $data = false;
	public $back_url = false;
	public $back_text = false;
	public $action_url = false;
	public $field = false;
	public $page = false;
	public $form_option = false;
	
	public $model = false;
	// public $back_text = false;

	public function init(){
		parent::init();
		// $action_url = new ActiveForm();
	}

	public function run()
	{
		return $this->render('widget\form', 
			[
				'page' 				=> $this->page,
				'action_url' 		=> $this->action_url,
				'field' 			=> $this->field,
				'dataProvider' 		=> $this->data,
				'model' 			=> $this->model,
				'back_text' 		=> $this->back_text,
				'back_url' 			=> $this->back_url,
				'form_option'		=> $this->form_option
			]
		);
	}
}
?>