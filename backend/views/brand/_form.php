<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\base\Brand */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-4 brand-form">

	<?php $form = ActiveForm::begin();?>

	    <?=$form->field($model, 'slug')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'name')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'description')->textInput(['maxlength' => true])?>

	<?=$form->field($model, 'status')->dropdownList(Yii::$app->cms->status())?>

	<div class="form-group">
		<?=Html::a('Back', Url::to('/brand/'), ['class' => 'btn btn-primary']);?>		<?=Html::submitButton('Save', ['class' => 'btn btn-primary'])?>
	</div>

	<?php ActiveForm::end();?>

</div>
