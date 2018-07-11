<?php

use backend\components\CustomformWidget;
use common\models\base\Brand;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\base\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<<<<<<< HEAD
<div class="card-content">

	<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']]); ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'synopsis')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price_discount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'brand')->dropdownList(ArrayHelper::map(Brand::find()->where(['status' => 1])->all(),'id','name'), ['class' => 'selectpicker', 'data-style' => 'select-with-transition', 'title' => 'Choose Brand']); ?> 

    <?= $form->field($model, 'image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'headline')->textInput() ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_keyword')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_download_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropdownList(Yii::$app->cms->status(), ['class' => 'selectpicker', 'data-style' => 'select-with-transition', 'title' => 'Choose Status']) ?>    

	<div class="form-group">
		<?= Html::a('Back',Url::to('/product/'), ['class' => 'btn btn-fill btn-primary']);?>		
        <?= Html::submitButton('Save', ['class' => 'btn btn-fill btn-success']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
=======
<?php echo CustomformWidget::widget([
    'back_url' => Url::to('/product/'),
    'back_text' => 'Back',
    'model' => $model,
    'page' => 2,
    'field' =>
    [
        [
            'name' => ['type' => 'text', 'option' => ['maxlength' => true]],
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
    ],
]); ?>
>>>>>>> 9930552fe26b04bb8ad4afd8b65926ff3d315156
