<?php

use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\base\Permission;
use backend\components\CMS;
use backend\components\SearchWidget;
use backend\components\TableWidget;

/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Subcategories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subcategory-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if(YII::$app->cms->check_permission()):?>    <p>
        <?= Html::a('Create Subcategory', ['create'], ['class' => 'btn btn-primary pull-right']) ?>
    </p>
    <?php endif;

    echo SearchWidget::widget(
    [
		'action'=> Url::to('/subcategory'),
		'field' =>
        ['Subcategory' =>
            [
                'name' => 'name',
                'placeholder' => 'Find Subcategory',
                'class' => 'form-control',
            ],
        ], 'status' => backend\components\CMS::StatusWidget(),
    ]
);
echo TableWidget::widget([
    'action' => 'Subcategory',
    'action_url' => 'subcategory',
    'data' => $dataProvider,
    'header' => [    'category','slug','name','description','created At','updated At',
    'Status', 'Action'],
    'field' => [    'category' => 'category','slug' => 'slug','name' => 'name','description' => 'description','created_at' => 'created_at','updated_at' => 'updated_at',    'status' =>
        ['callback' =>
            ['class' => 'backend\components\CMS', 'method' => 'getStatus'],
        ],
    ]]);
?>

<?php
echo yii\widgets\LinkPager::widget([
    'pagination' => $pages,
    'options' => [
        'class' => 'pagination pull-right',
    ],
]);
?>
</div>