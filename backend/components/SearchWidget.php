<?php
namespace backend\components;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class SearchWidget extends Widget{
	public $field = [];
	public $class = 'form-control col-md-4';
	public $container_class = 'col-md-3';
	public $method = 'get';
	public $action = '';

	public $source = false;

	public $status = false;
	public $model = false;
	public $status_field = false;

	public function init(){
		parent::init();
		if(!$this->field){
			$this->field = ['name' => 'Search by name'];
		}
		if(!$this->action){
			$this->action = Url::to('');
		}

	}

	public function run(){
		return $this->render('widget\search', [
			'field' => $this->field,
			'class' => $this->class,
			'method' => $this->method,
			'action' => $this->action,
			'status' => $this->status,
			'status_field' => $this->status_field
		]);
	}
}
?>