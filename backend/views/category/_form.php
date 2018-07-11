<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\base\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card-content">

	<div class="col-md-4">

		<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']]); ?>

		<?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'status')->dropdownList(Yii::$app->cms->status(), ['class' => 'selectpicker', 'data-style' => 'select-with-transition', 'title' => 'Choose Status']) ?>

		<div class="form-group">
			<?= Html::a('Back',Url::to('/category/'), ['class' => 'btn btn-fill btn-primary']);?>		
			<?= Html::submitButton('Save', ['class' => 'btn btn-fill btn-success']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>

</div>
