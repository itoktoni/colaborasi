<?php

use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\base\Permission;
use backend\components\CMS;
use backend\components\SearchWidget;
use backend\components\TableWidget;

/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">

<h2><?php echo $this->title; ?></h2>
<div class="row">
    <div class="col-md-12">
    
<?php 
    echo SearchWidget::widget(
    [
		'action'=> Url::to('/category'),
		'field' =>
        ['Category' =>
            [
                'name' => 'name',
                'placeholder' => 'Find Category',
                'class' => 'form-control',
            ],
        ], 'status' => backend\components\CMS::StatusWidget(),
    ]
);?>

 </div>
</div>

<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="purple">
                    <?php if (YII::$app->cms->check_permission(Permission::FULL_ACCESS)): ?>
                        <a href="/category/create" class="" title="" rel="tooltip" data-original-title="Create Category">
                            <i class="material-icons">add</i>
                        </a>
                    <?php endif;?>
                </div>
                <div class="card-content">
                    <h4 class="card-title" style="visibility: hidden;">Feature</h4>
                    <div class="table-responsive">
                    <?php 
echo TableWidget::widget([
    'action' => 'Category',
    'action_url' => 'category',
    'data' => $dataProvider,
    'header' => [    'slug','name','description',
    'Status'],
    'field' => [    'slug' => 'slug','name' => 'name','description' => 'description', 'status' =>
        ['callback' =>
            ['class' => 'backend\components\CMS', 'method' => 'getStatus'],
        ],
    ]]);
?>
</div>
<?php
echo yii\widgets\LinkPager::widget([
    'pagination' => $pages,
    'options' => [
        'class' => 'pagination pull-right',
    ],
]);
?>
</div>
            </div>
        </div>
    </div>

</div>