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
<div class="feature-index">

	<h1><?=Html::encode($this->title)?></h1>
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<?php if (YII::$app->cms->check_permission(Permission::FULL_ACCESS)): ?>
		<p>
			<?=Html::a('Create Feature', ['/feature/create'], ['class' => 'btn btn-primary pull-right'])?>
		</p>.
	<?php endif;

echo SearchWidget::widget(
    [
		'action'=> Url::to('/feature'),
		'field' =>
        ['feature' =>
            [
                'name' => 'name',
                'placeholder' => 'Find Feature',
                'class' => 'form-control',
            ],
            'slug' => [
				'name' => 'slug','placeholder' => 'Find Slug..','class' => 'form-control'
			]
        ], 'status' => backend\components\CMS::StatusWidget(),
    ]
);

echo TableWidget::widget([
    'action' => 'Feature',
    'action_url' => 'feature',
    'data' => $dataProvider,
    'header' => ['Name', 'Slug', 'Icon', 'Status', 'Action'],
    'field' => ['name' => 'name', 'slug' => 'slug', 'icon' => 'icon',
        'status' =>
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
