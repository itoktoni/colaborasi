<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\base\FeatureGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card-content">

	<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropdownList(Yii::$app->cms->status(), ['class' => 'selectpicker', 'data-style' => 'select-with-transition', 'title' => 'Choose Status']) ?>

	<div class="form-group">
		<?= Html::a('Back',Url::to('/feature-group/'), ['class' => 'btn btn-fill btn-primary']);?>		
		<?= Html::submitButton('Save', ['class' => 'btn btn-fill btn-success']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
 