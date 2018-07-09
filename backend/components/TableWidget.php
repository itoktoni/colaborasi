<?php
namespace backend\components;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class TableWidget extends Widget{
    public $header 		= [];
	public $field 		= [];
	public $class 		= 'table table-responsive';
	public $action_url 	= '';
    public $action 		= '';
    
    public $action_edit 		= true;
    public $action_delete 		= true;

    public $status_toggle 		= false;
	public $status_toggle_url 	= false;
	
	public $data 		= false;

	public function init(){
		parent::init();
		if(!$this->header)
		{
			$this->header = ['name' => 'Name'];
		}
		if(!$this->field)
		{
			$this->field = ['name' => 'name'];
		}
	}

	public function run()
	{
		return $this->render('widget\table', 
			[
				'dataProvider' 		=> $this->data,
	            'header' 			=> $this->header,
				'field' 			=> $this->field,
				'class' 			=> $this->class,
	            'action' 			=> $this->action,
	            'action_url' 		=> $this->action_url,
				'action_edit' 		=> $this->action_edit,
				'status_toggle' 	=> $this->status_toggle,
				'status_toggle_url' => $this->status_toggle_url,
	            'action_delete' 	=> $this->action_delete
			]
		);
	}
}
?>