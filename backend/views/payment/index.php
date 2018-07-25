<?php

use backend\components\CMS;
use backend\components\SearchWidget;
use backend\components\TableWidget;
use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payments-index container-fluid">

    <h2><?=Html::encode($this->title)?></h2>
    <div class="row">

    <?php
$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    'id',
    'invoice',
    'created_at',
    'payment_type',
    'shipping_type',
    'user_name',
    'user_address',
    'user_email',
    'voucher_name',
    'voucher_discount_type',
    'voucher_discount_value',
    'total_bruto',
    'total_discount_rupiah',
    'total_tax_rupiah',
    'total_shipping_rupiah',
    'total_net_rupiah',
    'paypal_payment_id',
    'paypal_payer_email',
    'paypal_amount_rupiah',
    'paypal_payment_id',
    'shipping_province',
    'shipping_city',
    'shipping_courier',
    'shipping_type',
    'shipping_receiver',
    'shipping_address',
    'shipping_phone_number',
    'shipping_email',
    'cc_transaction_id',
    'cc_number',
    'cc_month',
    'cc_year',
    'payment_status',
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
        'invoice' => [
            'name' => 'invoice',
            'placeholder' => 'Find Invoice',
            'class' => 'form-control',
            'columnCss' => 'col-md-2',
        ],
        'email' => [
            'name' => 'email',
            'placeholder' => 'Find Email',
            'class' => 'form-control',
            'columnCss' => 'col-md-2',
        ],
        'username' => [
            'name' => 'username',
            'placeholder' => 'Find Username',
            'class' => 'form-control',
            'columnCss' => 'col-md-2',

        ],
        'social_media_type' => [
            'is_dropdown' => true,
            'name' => 'social_media_type',
            'placeholder' => 'Filter Social Media Type',
            'multiple' => true,
            'item' => CMS::socialmediaType(),
            'class' => 'form-control',
            'columnCss' => 'col-md-3',
            'clearfix' => true,
        ],
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
        'voucher' => [
            'is_widget' => true,
            'clearfix' => false,
            'widget_content' => kartik\typeahead\Typeahead::widget([
                'name' => 'voucher',
                'value' => Yii::$app->request->get('voucher'),
                'id' => 'voucher_dropdown',
                'options' => ['placeholder' => 'Filter voucher as you type ...'],
                'pluginOptions' => ['highlight' => true],
                'dataset' => [
                    [
                        'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('name')",
                        'display' => 'name',
                        'prefetch' => Url::to('/api/voucher', true),
                        'remote' => [
                            'url' => Url::to('/api/voucher', true) . '?keyword=%QUERY',
                            'wildcard' => '%QUERY',
                            'ajax' => ['type' => "GET"],
                        ],
                    ],
                ]])],
        'brand' => [
            'is_widget' => true,
            'clearfix' => true,
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
                ]])],

        'payment_type' => [
            'is_dropdown' => true,
            'name' => 'payment_type',
            'placeholder' => 'Select payment Type',
            'item' => CMS::paymentType(),
            'class' => 'form-control',
            'columnCss' => 'col-md-2',
        ],

        'payment_status' => [
            'is_dropdown' => true,
            'name' => 'payment_status',
            'placeholder' => 'Filter Payment Status',
            'multiple' => true,
            'item' => CMS::paymentStatus(),
            'class' => 'form-control',
            'columnCss' => 'col-md-2',
            'clearfix' => true,
        ],
        'price_range_start' => [
            'name' => 'price_range_start',
            'placeholder' => 'Transaction Total Start',
            'class' => 'form-control',
            'columnCss' => 'col-md-2',
        ],
        'price_range_to' => [
            'name' => 'price_range_to',
            'type' => 'number',
            'placeholder' => 'Transaction Total End',
            'class' => 'form-control',
            'columnCss' => 'col-md-2',
            'clearfix' => true,
        ]];
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
        'action' => Url::to('/payment'),
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
			<?php $labels[] = $item->created_at;?>
			<?php $data[] = $item->counter;?>
		<?php endforeach;?>

        <?php if(count($data) == 1):
                $data[] = $item->counter;
                $labels[] = $item->created_at;
        endif;?>
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
							'label' => "Payment",
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
             <?php 
            $labels = $data = [];
            foreach($productchart->getModels() as $item):?>
                <?php $labels[] = $item->create_at;?>
                <?php $data[] = $item->counter;?>
            <?php endforeach;?>

            <?php if(count($data) == 1):
                $data[] = $item->create_at;
                $labels[] = $item->counter;
            endif;?>

            <div class="clearfix">&nbsp;</div>
            <?= \dosamigos\chartjs\ChartJs::widget([
				'type' => 'line',
				'id' => 'chart_product',
				'options' => [
					'height' => 400,
					'width' => 400
				],
				'data' => [
					'labels' => $labels,
					'datasets' => [
						[
							'label' => "Product",
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
                    <h4 class="card-title" style="visibility: hidden;">Payments</h4>
                    <div class="table-responsive">
                    <?php
echo TableWidget::widget([
    'action' => 'Payments',
    'action_url' => 'payments',
    'data' => $dataProvider->getModels(),
    'action_button' => false,
    'header' => ['Invoice',
        'Payment Type',
        'Shipping Type',
        'User', 'Social Media', 'Voucher','Total Bruto', 'Total Discount Rupiah', 'Total Tax Rupiah', 'Total Shipping Rupiah', 'Total Net Rupiah', 'Payment Status', 'Status'],
    'field' => [
        'invoice' => 'invoice',
        'payment_type' =>
        ['callback' =>
            ['class' => 'backend\components\CMS', 'method' => 'getPaymentType'],
        ],
        'shipping_type' =>
        ['callback' =>
            ['class' => 'backend\components\CMS', 'method' => 'getShipping'],
        ],
        'user_name' => ['combination' => true, 'format' => '{user_name}{user_email}'],
        'user_social_media_type' =>
        ['callback' =>
            ['class' => 'backend\components\CMS', 'method' => 'getSocialMediaType'],
        ],
        'voucher_name' => ['combination' => true, 'format' => '{voucher_name}{voucher_discount_type}{voucher_discount_value}'],
        'total_bruto' => 'total_bruto', 'total_discount_rupiah' => 'total_discount_rupiah', 'total_tax_rupiah' => 'total_tax_rupiah', 'total_shipping_rupiah' => 'total_shipping_rupiah', 'total_net_rupiah' => 'total_net_rupiah',
        'payment_status' => ['callback' =>
            ['class' => 'backend\components\CMS', 'method' => 'getPaymentStatus'],
        ],
        'status' =>
        ['callback' =>
            ['class' => 'backend\components\CMS', 'method' => 'getStatus'],
        ],
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