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
    'field' =>
    [
        [
            'name' => ['type' => 'text', 'option' => ['maxlength' => true]],
            'category' => [
                'type' => 'dropdown_model',
                'item' => Category::find()->where(['status' => '1'])->all(),
                'id' => 'id',
                'name' => 'name',
            ],
            'slug' => ['type' => 'text', 'option' => ['maxlength' => true]],
            'synopsis' => ['type' => 'text', 'option' => ['maxlength' => true]],
            'description' => ['type' => 'tinymce', 'option' => ['rows' => 6]],
            'price' => ['type' => 'text','option' => ['type' => 'number']],
            'price_discount' => ['type' => 'text', 'option' => ['type' => 'number']], 
        ],
        [
            'brand' => [
                'type' => 'dropdown_model',
                'item' => Brand::find()->where(['status' => '1'])->all(),
                'id' => 'id',
                'name' => 'name',
            ],
            'image' => ['type' => 'uploadimage'],
            'headline' => ['type' => 'checkbox','option' => ['label' => 'Headline']],
            'meta_description' => ['type' => 'text'],
            'meta_keyword' => ['type' => 'tags'],
            'product_download_url' => ['type' => 'file','option' => ['label' => 'File Product']],
            'status' => ['type' => 'status'],

        ],
        [
            'subcategory' => ['type' => 'dropdown_model','item' => Subcategory::find()->where(['status' => '1'])->all(),'option' => ['multiple' => true]]
        ]
    ],
]); ?>
<<<<<<< HEAD
=======
</div>
>>>>>>> e4cad6a589f356b322497d78166ccb145cd15181
