<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\base\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-4 user-form">

	<?php $form = ActiveForm::begin(); ?>

	    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true,'value' => '']) ?>

    <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropdownList(Yii::$app->cms->status()) ?>

    <?= $form->field($model, 'roles')->dropdownList(ArrayHelper::map($roles,'id','name')) ?>

	<div class="form-group">
		<?= Html::a('Back',Url::to('/user/'), ['class' => 'btn btn-primary']);?>		<?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
