<?php
namespace backend\components;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class SearchWidget extends Widget{
	public $field 			= [];
	public $class 			= 'form-control col-md-4';
	public $container_class = 'col-md-3';
	public $method 			= 'get';
	public $action 			= '';
	public $id				= 'form-search';

	public $source 			= false;

	public $status 			= false;
	public $model 			= false;
	public $sort 			= true;
	public $sort_field 		= false;
	public $status_field 	= false;

	public function init(){
		parent::init();
		if(!$this->field)
		{
			$this->field = ['name' => 'Search by name'];
		}
		if(!$this->action)
		{
			$this->action = Url::to('');
		}

	}

	public function run(){
		return $this->render('widget\search', 
			[
				'id'			=> $this->id,
				'field' 		=> $this->field,
				'class' 		=> $this->class,
				'method'		=> $this->method,
				'action' 		=> $this->action,
				'sort' 			=> $this->sort,
				'sort_field' 	=> $this->sort_field,
				'status' 		=> $this->status,
				'status_field' 	=> $this->status_field
			]
		);
	}
}
?>