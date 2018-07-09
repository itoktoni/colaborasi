<?php

use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\base\Permission;
use backend\components\CMS;
use backend\components\SearchWidget;
use backend\components\TableWidget;

/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Productcontents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="productcontent-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if(YII::$app->cms->check_permission()):?>    <p>
        <?= Html::a('Create Productcontent', ['create'], ['class' => 'btn btn-primary pull-right']) ?>
    </p>
    <?php endif;

    echo SearchWidget::widget(
    [
		'action'=> Url::to('/productcontent'),
		'field' =>
        ['Productcontent' =>
            [
                'name' => 'name',
                'placeholder' => 'Find Productcontent',
                'class' => 'form-control',
            ],
        ], 'status' => backend\components\CMS::StatusWidget(),
    ]
);
echo TableWidget::widget([
    'action' => 'Productcontent',
    'action_url' => 'productcontent',
    'data' => $dataProvider,
    'header' => [    'product','embed Type','content Type','content','created At','updated At',
    'Status', 'Action'],
    'field' => [    'product' => 'product','embed_type' => 'embed_type','content_type' => 'content_type','content' => 'content','created_at' => 'created_at','updated_at' => 'updated_at',    'status' =>
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