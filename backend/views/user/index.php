<?php
use backend\components\CMS;
use backend\components\SearchWidget;
use backend\components\TableWidget;
use backend\models\base\Permission;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">

    <h2>Users</h2>
    <div class="row">
        <div class="col-md-12">
            <?php
            echo SearchWidget::widget(
                [
                    'action' => Url::to('/user'),
                    'field' => [
                        'User' => [
                            'name' => 'name',
                            'placeholder' => 'Find User',
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
                    <a href="/user/create" class="" title="" rel="tooltip" data-original-title="Create User">
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
                                'action' => 'User',
                                'action_url' => 'user',
                                'data' => $dataProvider,
                                'header' => ['Email', 'Name', 'Roles', 'Status'],
                                'field' => [
                                    'email' => 'email',
                                    'name' => 'name',
                                    'roles' => 'roles_name',
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