<?php

use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\base\Permission;
use backend\components\CMS;
use backend\components\SearchWidget;
use backend\components\TableWidget;

/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Roles';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    
    <h2>Roles</h2>
    <div class="row">
        <div class="col-md-12">
            <?php
            echo SearchWidget::widget(
                [
                    'action'    => Url::to('/roles'),
                    'field'     => [
                        'Roles' => [
                            'name'          => 'name',
                            'placeholder'   => 'Find Roles',
                            'class'         => 'form-control',
                        ],
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
                        <a href="/roles/create" class="" title="" rel="tooltip" data-original-title="Create Roles">
                            <i class="material-icons">add</i>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="card-content">
                    <h4 class="card-title" style="visibility: hidden;">Roles</h4>
                    <div class="table-responsive">
                        <?php
                            echo TableWidget::widget(
                                [
                                    'action'        => 'Roles',
                                    'action_url'    => 'roles',
                                    'data'          => $dataProvider,
                                    'header'        => ['Name','Description','Status'],
                                    'field'         => [
                                        'name'          => 'name',
                                        'description'   => 'description',
                                        'status'        => [
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