<?php

use backend\components\CMS;
use backend\components\SearchWidget;
use backend\components\TableWidget;
use backend\models\base\Permission;
use yii\helpers\Html;
use yii\helpers\Url; 

/* @var $this yii\web\View */
/* @var $searchModel backend\models\activerecord\FeatureSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Features';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    
    <h2>Feature</h2>
    <div class="row">
        <div class="col-md-12">
            <?php
            echo SearchWidget::widget(
                [
                    'action'    => Url::to('/feature'),
                    'field'     => [
                        'feature'           => [
                            'name'          => 'name',
                            'placeholder'   => 'Find Feature',
                            'class'         => 'form-control',
                        ],
                        'slug'              => [
                            'name'          => 'slug',
                            'placeholder'   => 'Find Slug..',
                            'class'         => 'form-control'
                        ]
                    ], 
                    'status'    => backend\components\CMS::StatusWidget(),
                ]
            );
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="purple">
                    <?php if (YII::$app->cms->check_permission(Permission::FULL_ACCESS)): ?>
                        <a href="/feature/create" class="" title="" rel="tooltip" data-original-title="Create Feature">
                            <i class="material-icons">add</i>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="card-content">
                    <h4 class="card-title" style="visibility: hidden;">Feature</h4>
                    <div class="table-responsive">
                        <?php
                            echo TableWidget::widget(
                                [
                                    'action'        => 'Feature',
                                    'action_url'    => 'feature',
                                    'data'          => $dataProvider,
                                    'header'        => ['Name', 'Slug', 'Icon', 'Status'],
                                    'field'         => ['name' => 'name', 'slug' => 'slug', 'icon' => 'icon',
                                        'status'    => [
                                            'callback' => ['class' => 'backend\components\CMS', 'method' => 'getStatus'],
                                        ],
                                    ]
                                ]
                            );
                        ?>
                    </div>
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
            </div>
        </div>
    </div>

</div>