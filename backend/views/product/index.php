<?php

use backend\components\CMS;
use backend\components\SearchWidget;
use backend\components\TableWidget;
use backend\models\base\Permission;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">

<h2><?php echo $this->title; ?></h2>
<div class="row">
    <div class="col-md-12">

    <?php echo SearchWidget::widget(
    [
        'action' => Url::to('/product'),
        'field' =>
        ['Product' =>
            [
                'name' => 'name',
                'placeholder' => 'Find Product',
                'class' => 'form-control',
            ],
        ], 'status' => backend\components\CMS::StatusWidget(),
    ]
); ?>
    </div>
</div>

<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="purple">
                    <?php if (YII::$app->cms->check_permission(Permission::FULL_ACCESS)): ?>
                        <a href="/product/create" class="" title="" rel="tooltip" data-original-title="Create Product">
                            <i class="material-icons">add</i>
                        </a>
                    <?php endif;?>
                </div>
                <div class="card-content">
                    <h4 class="card-title" style="visibility: hidden;">Feature</h4>
                    <div class="table-responsive">
<?php
echo TableWidget::widget([
    'action' => 'Product',
    'action_url' => 'product',
    'data' => $dataProvider,
    'header' => ['name', 'synopsis', 'price', 'price Discount', 'brand', 'image','headline','updated At',
        'Status', ],
    'field' => ['name' => 'name', 'synopsis' => 'synopsis', 'price' => 'price', 'price_discount' => 'price_discount', 'brand' => 'brand', 'image' => 'image', 'headline' => 'headline', 'updated_at' => 'updated_at', 'status' =>
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
