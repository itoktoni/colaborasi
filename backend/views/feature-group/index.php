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

<div class="container-fluid">
    
    <h2>Feature Group</h2>
    <div class="row">
        <div class="col-md-12">
            <?php
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
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="purple">
                    <?php if (YII::$app->cms->check_permission(Permission::FULL_ACCESS)): ?>
                        <a href="/feature-group/create" class="" title="" rel="tooltip" data-original-title="Create Feature Group">
                            <i class="material-icons">add</i>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="card-content">
                    <h4 class="card-title" style="visibility: hidden;">Feature Group</h4>
                    <div class="table-responsive">
                        <?php
                            echo TableWidget::widget(
                                [
                                    'action'        => 'Feature Group',
                                    'action_url'    => 'feature-group',
                                    'data'          => $dataProvider,
                                    'header'        => ['Name','Slug','Sort','Icon','Status'],
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