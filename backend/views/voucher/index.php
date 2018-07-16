<?php

use backend\components\CMS;
use backend\components\SearchWidget;
use backend\components\TableWidget;
use backend\models\base\Permission;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\VoucherSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vouchers';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">

    <h2>Users</h2>
    <div class="row">
        <div class="col-md-12">
            <?php
            echo SearchWidget::widget(
                [
                    'action' => Url::to('/voucher'),
                    'field' => [
                        'Voucher' => [
                            'name' => 'name',
                            'placeholder' => 'Find Voucher',
                            'class' => 'form-control',
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
                    <a href="/voucher/create" class="" title="" rel="tooltip" data-original-title="Create Voucher">
                        <i class="material-icons">add</i>
                    </a>
                    <?php endif;?>
                </div>
                <div class="card-content">
                    <h4 class="card-title" style="visibility: hidden;">Users</h4>
                    <div class="table-responsive">
                        <?php
                        echo TableWidget::widget(
                            [
                                'action' => 'Voucher',
                                'action_url' => 'voucher',
                                'data' => $dataProvider,
                                'header' => ['Slug', 'Name', 'Code', 'Description', 'Discount(%)', 'Discount(IDR)', 'Start Date', 'End Date', 'Status'],
                                'field' => [
                                    'slug' => 'slug',
                                    'name' => 'name',
                                    'code' => 'code',
                                    'description' => 'description',
                                    'discount_prosentase' => 'discount_prosentase',
                                    'discount_price' => 'discount_price',
                                    'start_date' => 'start_date',
                                    'end_date' => 'end_date',
                                    'status' => [
                                        'callback' => ['class' => 'backend\components\CMS', 'method' => 'getStatus'],
                                    ],
                                ],
                            ]
                        );
                        ?>
                    </div>
                    <?php
                    echo yii\widgets\LinkPager::widget(
                        [
                            'pagination' => $pages,
                            'options' => [
                                'class' => 'pagination pull-right',
                            ],
                        ]
                    );
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>