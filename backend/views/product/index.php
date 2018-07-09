<?php

use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\base\Permission;
use backend\components\CMS;
use backend\components\SearchWidget;
use backend\components\TableWidget;

/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if(YII::$app->cms->check_permission()):?>    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-primary pull-right']) ?>
    </p>
    <?php endif;

    echo SearchWidget::widget(
    [
		'action'=> Url::to('/product'),
		'field' =>
        ['Product' =>
            [
                'name' => 'name',
                'placeholder' => 'Find Product',
                'class' => 'form-control',
            ],
        ], 'status' => backend\components\CMS::StatusWidget(),
    ]
);
echo TableWidget::widget([
    'action' => 'Product',
    'action_url' => 'product',
    'data' => $dataProvider,
    'header' => [    'slug','name','synopsis','description','price','price Discount','brand','image','image Path','image Thumbnail','image Portrait','headline','meta Description','meta Keyword','product Download Url','product Download Path','product View','created At','updated At',
    'Status', 'Action'],
    'field' => [    'slug' => 'slug','name' => 'name','synopsis' => 'synopsis','description' => 'description','price' => 'price','price_discount' => 'price_discount','brand' => 'brand','image' => 'image','image_path' => 'image_path','image_thumbnail' => 'image_thumbnail','image_portrait' => 'image_portrait','headline' => 'headline','meta_description' => 'meta_description','meta_keyword' => 'meta_keyword','product_download_url' => 'product_download_url','product_download_path' => 'product_download_path','product_view' => 'product_view','created_at' => 'created_at','updated_at' => 'updated_at',    'status' =>
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