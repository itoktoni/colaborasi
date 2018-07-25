<?php

use backend\components\CMS;
use backend\components\SearchWidget;
use backend\components\TableWidget;
use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Downloads';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="Downloads-index container-fluid">

    <h2><?=Html::encode($this->title)?></h2>
    <div class="row">

    <?php
$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    'id',
    'key',
    'product_name',
    'member',
    'counter',
    'status',
];?>

<div class="col-md-12">
        <?php

$datepicker_options = [
    'name' => 'date_range',
    'id' => 'rangepicker',
    //
    // 'value2' => (isset($date_end)?$date_end:''),
    'convertFormat' => true,
    'useWithAddon' => true,
    'presetDropdown' => true,
    'pluginOptions' => [
        'locale' => [
            'format' => 'Y-m-d',
            'separator' => ' to ',
        ],
        'opens' => 'left',
    ],
    'pluginEvents' => [
        "apply.daterangepicker" => "function() { $('#form-search').submit();}",
    ],
];
$status = false;

if (Yii::$app->request->get('date_range')) {
    $datepicker_options['value'] = Yii::$app->request->get('date_range');
    $status = true;
    $search_input = [
        'range' =>
        ['is_widget' => true, 'columnCss' => 'col-md-2', 'clearfix' => true, 'widget_content' => '<div class="input-group col-md-12"><div class="row"><label class="form-label">Payment Date Range</label>' .
            DateRangePicker::widget($datepicker_options) . '</div></div>', 'clearfix' => true],
        'product' => [
            'is_widget' => true,
            'widget_content' => kartik\typeahead\Typeahead::widget([
                'name' => 'product',
                'value' => Yii::$app->request->get('product'),
                'id' => 'product_dropdown',
                'options' => ['placeholder' => 'Filter product as you type ...'],
                'pluginOptions' => ['highlight' => true],
                'dataset' => [
                    [
                        'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('name')",
                        'display' => 'name',
                        'prefetch' => Url::to('/api/product', true),
                        'remote' => [
                            'url' => Url::to('/api/product', true) . '?keyword=%QUERY',
                            'wildcard' => '%QUERY',
                            'ajax' => ['type' => "GET"],
                        ],
                    ],
                ]])],
        'brand' => [
            'is_widget' => true,
            'widget_content' => kartik\typeahead\Typeahead::widget([
                'name' => 'brand',
                'value' => Yii::$app->request->get('brand'),
                'id' => 'brand_dropdown',
                'options' => ['placeholder' => 'Filter brand as you type ...'],
                'pluginOptions' => ['highlight' => true],
                'dataset' => [
                    [
                        'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('name')",
                        'display' => 'name',
                        'prefetch' => Url::to('/api/brand', true),
                        'remote' => [
                            'url' => Url::to('/api/brand', true) . '?keyword=%QUERY',
                            'wildcard' => '%QUERY',
                            'ajax' => ['type' => "GET"],
                        ],
                    ],
                ]])]];
} else {
    $search_input =
        [
        'range' =>
        ['is_widget' => true, 'columnCss' => 'col-md-2', 'clearfix' => true, 'widget_content' => '<div class="input-group col-md-12"><div class="row"><label class="form-label">Payment Date Range</label>' .
            DateRangePicker::widget($datepicker_options) . '</div></div>', 'clearfix' => true],
    ];
}

echo SearchWidget::widget(
    [
        'action' => Url::to('/download'),
        'id' => 'form-search',
        'field' =>
        $search_input,
        'status' => $status,
    ]
);?>
                </div>
    </div>

<?php if (isset($dataProvider) && $dataProvider): ?>
		<div class="pull-left">
			<?php echo kartik\export\ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'fontAwesome' => true,
    'id' => 'helpmeexport',
]);
?>
		</div>
	<div class="clearfix">&nbsp;</div>
    <div class="row">
    <div class="col-md-4">
    <div class="card">
        <div class="card-content">

        <?php 
		$labels = $data = [];
		foreach($chartdata->getModels() as $item):?>
			<?php $labels[] = $item->product_name;?>
			<?php $data[] = $item->counter;?>
		<?php endforeach;?>

        
        <?= \dosamigos\chartjs\ChartJs::widget([
				'type' => 'line',
				'id' => 'chart',
				'options' => [
					'height' => 400,
					'width' => 400
				],
				'data' => [
					'labels' => $labels,
					'datasets' => [
						[
							'label' => "Download",
							'backgroundColor' => "rgba(156,39,176,0.2)",
							'borderColor' => "rgba(179,181,198,1)",
							'pointBackgroundColor' => "rgba(179,181,198,1)",
							'pointBorderColor' => "#fff",
							'pointHoverBackgroundColor' => "#fff",
							'pointHoverBorderColor' => "rgba(179,181,198,1)",
							'data' => $data
						],
					]
				]
			]);
			?>
            </div>
        </div>
    </div>
        <div class="col-md-8">
            <div class="card">

                <div class="card-content">
                    <h4 class="card-title" style="visibility: hidden;">Downloads</h4>
                    <div class="table-responsive">
                    <?php
echo TableWidget::widget([
    'action' => 'download',
    'action_url' => 'download',
    'action_button' => false,
    'data' => $dataProvider->getModels(),
    'header' => ['product','Download Count'],
    'field' => [
        'product_name','counter'
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
    <?php endif;?>
</div>


<?php
$this->registerJs(" $(document).ready(function() { $('.dropdown-toggle').dropdown(); });");