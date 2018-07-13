<?php

use backend\components\CMS;
use backend\components\SearchWidget;
use backend\components\TableWidget;
use backend\models\base\Permission;
use yii\helpers\Url;

/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Headlines';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">

<h2><?php echo $this->title; ?></h2>
<div class="row">
    <div class="col-md-12">
    <?php

echo SearchWidget::widget(
    [
        'action' => Url::to('/headline'),
        'field' =>
        ['Headline' =>
            [
                'name' => 'name',
                'placeholder' => 'Find Headline',
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
                        <a href="/headline/create" class="" title="" rel="tooltip" data-original-title="Create Headline Item">
                            <i class="material-icons">add</i>
                        </a>
                    <?php endif;?>
                </div>
                <div class="card-content">
                    <h4 class="card-title" style="visibility: hidden;">Feature</h4>
                    <div class="table-responsive">
                    <?php
echo TableWidget::widget([
    'action' => 'Headline',
    'action_url' => 'headline',
    'data' => $dataProvider,
    'header' => ['title', 'subtitle', 'image', 'link'],
    'field' => ['title' => 'title', 'subtitle' => 'subtitle', 'image' => 'image', 'link' => 'link'

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