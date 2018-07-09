<?php

use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\base\Permission;
use backend\components\CMS;
use backend\components\SearchWidget;
use backend\components\TableWidget;

/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Productcategories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="productcategory-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if(YII::$app->cms->check_permission()):?>    <p>
        <?= Html::a('Create Productcategory', ['create'], ['class' => 'btn btn-primary pull-right']) ?>
    </p>
    <?php endif;

    echo SearchWidget::widget(
    [
		'action'=> Url::to('/productcategory'),
		'field' =>
        ['Productcategory' =>
            [
                'name' => 'name',
                'placeholder' => 'Find Productcategory',
                'class' => 'form-control',
            ],
        ], 'status' => backend\components\CMS::StatusWidget(),
    ]
);
echo TableWidget::widget([
    'action' => 'Productcategory',
    'action_url' => 'productcategory',
    'data' => $dataProvider,
    'header' => [    'product','sub Category',
    'Status', 'Action'],
    'field' => [    'product' => 'product','sub_category' => 'sub_category',    'status' =>
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