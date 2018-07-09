<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\base\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-4 product-form">

	<?php $form = ActiveForm::begin(); ?>

	    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'synopsis')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price_discount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'brand')->textInput() ?>

    <?= $form->field($model, 'image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image_thumbnail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image_portrait')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'headline')->textInput() ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_keyword')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_download_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_download_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_view')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

	<div class="form-group">
		<?= Html::a('Back',Url::to('/product/'), ['class' => 'btn btn-primary']);?>		<?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
