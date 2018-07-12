<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\base\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card-content">

	<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']]); ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'autofocus' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropdownList(Yii::$app->cms->status(), ['class' => 'selectpicker', 'data-style' => 'select-with-transition', 'title' => 'Choose Status']) ?>

	<div class="form-group">
		<?= Html::a('Back',Url::to('/category/'), ['class' => 'btn btn-fill btn-primary']);?>		
		<?= Html::submitButton('Save', ['class' => 'btn btn-fill btn-success']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
