<?php

use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\base\Permission;
use backend\components\CMS;
use backend\components\SearchWidget;
use backend\components\TableWidget;

/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Feature Groups';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="feature-group-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if(YII::$app->cms->check_permission()):?>    
        <p>
            <?= Html::a('Create Feature Group', ['create'], ['class' => 'btn btn-primary pull-right']) ?>
        </p>
    <?php endif;

    echo SearchWidget::widget(
        [
    		'action'  => Url::to('/feature-group'),
    		'field'   => [
                'FeatureGroup'      => [
                    'name'          => 'name',
                    'placeholder'   => 'Find Feature Group',
                    'class'         => 'form-control',
                ],
            ], 
            'status' => backend\components\CMS::StatusWidget(),
        ]
    );

    echo TableWidget::widget(
        [
            'action'        => 'Feature Group',
            'action_url'    => 'feature-group',
            'data'          => $dataProvider,
            'header'        => ['name','slug','sort','icon','Status','Action'],
            'field'         =>  [
                'name'      => 'name',
                'slug'      => 'slug',
                'sort'      => 'sort',
                'icon'      => 'icon',    
                'status'    => [
                    'callback' => ['class' => 'backend\components\CMS', 'method' => 'getStatus'],
                ],
            ]
        ]
    );

    ?>

    <?php
    echo yii\widgets\LinkPager::widget(
        [
            'pagination'    => $pages,
            'options'       => [
                'class'     => 'pagination pull-right',
            ],
        ]
    );
    ?>

</div>