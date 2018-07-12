<?php

use backend\components\CustomformWidget;
use common\models\base\Brand;
use common\models\base\Subcategory;
use common\models\base\Category;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\base\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card-content">
<?php echo CustomformWidget::widget([
    'back_url' => Url::to('/product/'),
    'back_text' => 'Back',
    'model' => $model,
    'page' => 3,
    'form_option' => ['options' => ['enctype' => 'multipart/form-data']],
    'field' =>
    [
        [
            'name' => ['type' => 'text', 'option' => ['maxlength' => true]],
            'slug' => ['type' => 'text', 'option' => ['maxlength' => true]],
            'category' => [
                'type' => 'dropdown_model',
                'item' => Category::find()->where(['status' => Category::STATUS_ACTIVE])->all(),
                'id' => 'id',
                'name' => 'name',
                'option' => ['title' => "Choose Category"]
            ],
            'subcategory' => ['type' => 'dropdown_model','item' => $subcategory_list,'option' => ['multiple' => true,'options' => $selected_subcategory]],
            'brand' => [
                'type' => 'dropdown_model',
                'item' => Brand::find()->where(['status' => Brand::STATUS_ACTIVE])->all(),
                'id' => 'id',
                'name' => 'name',
            ],
            'price' => ['type' => 'text','option' => ['type' => 'number']],
            'discount_flag' => ['type' => 'checkbox','option' => ['label' => 'Discounted?']],
            'price_discount' => ['type' => 'text', 'option' => ['type' => 'number']], 
        ],
        [
            'image' => ['type' => 'uploadimage'],
            'synopsis' => ['type' => 'text', 'option' => ['maxlength' => true]],
            'description' => ['type' => 'tinymce', 'option' => ['rows' => 6]],
            
            'headline' => ['type' => 'checkbox','option' => ['label' => 'Headline']],
            'meta_description' => ['type' => 'text'],
            'meta_keyword' => ['type' => 'tags'],
            'product_download_url' => ['type' => 'file','option' => ['label' => 'File Product']],
            'status' => ['type' => 'status'],

        ],
        [
            
            'content' =>     ['type' => 'html', 'content' => $content]
        ]
        
    ],
]); ?>
</div>


<?php $this->registerJs("$('#product-category').on('changed.bs.select', function (e) {
    var val = '".Url::to('/product/subcategory',true)."/'+$(this).val();
    $.ajax({
        url: val,
      }).done(function(e) {
        $('#product-subcategory').empty();
        var list = '';
        $.each(e.data, function(i, value){
            list += '<option value='+value.id+'>'+value.name+'</option>'
        });

        $('#product-subcategory').html(list);
        
        $('#product-subcategory').selectpicker('refresh');
      });
});

$('#product-discount_flag').click(function(e){
    __init_discount_field($(this));
});

function __init_discount_field(f){
    if(f.is(':checked')){
        $('.field-product-price_discount').show();
    }else{
        $('.field-product-price_discount').hide();
    }
}

__init_discount_field($('#product-discount_flag'));

");

