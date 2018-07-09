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
        <form action="/user" method="get">

                 <div class="col-md-3">
                     <div class="form-group is-empty">
                         <input type="text" name="name" class="form-control" placeholder="Find User" value="" id="user">
                         <span class="material-input"></span>
                         <span class="material-input"></span>
                     </div>
                 </div>

                 <div class="col-md-2">
                     <div class="form-group is-empty" style="margin-top: 11px;">
                         <select class="selectpicker" data-style="select-with-transition" multiple title="Choose Status" data-size="7" name="status">
                             <option disabled>All Status</option>
                             <option value="1">Active</option>
                             <option value="0">Inactive</option>
                         </select>
                     </div>
                 </div>

                 <div class="clearfix"></div>

                 <div class="col-md-12 text-right">
                     <a href="/user" class="btn btn-sm btn-default" rel="tooltip" title="" data-original-title="Reset Search"><i class="material-icons">sync</i></a>
                     <button type="submit" class="btn btn-sm btn-primary" rel="tooltip" title="" data-original-title="Search"><i class="material-icons">search</i></button>
                 </div>

                 </form>
<?php
echo SearchWidget::widget(
    [
        'action' => Url::to('/user'),
        'field' =>
        ['User' =>
            [
                'name' => 'name',
                'placeholder' => 'Find User',
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
                    <!-- <ul class="pagination" style="float: right;">
                        <li>
                            <a href="javascript:void(0);"> prev<div class="ripple-container"></div></a>
                        </li>
                        <li class="active">
                            <a href="javascript:void(0);">1</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">next </a>
                        </li>
                    </ul> -->
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