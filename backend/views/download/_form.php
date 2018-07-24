<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\base\MemberDownload */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="member-download-form card-content">

	<div class="col-md-4">

		<?php $form = ActiveForm::begin(); ?>
	
		    <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product')->textInput() ?>

    <?= $form->field($model, 'member')->textInput() ?>

    <?= $form->field($model, 'expiration_date')->textInput() ?>

    <?= $form->field($model, 'create_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>


	    <div class="form-group">
			<?= Html::a('Back',Url::to('/member-download/'), ['class' => 'btn btn-fill btn-primary']);?>			<?= Html::submitButton('Save', ['class' => 'btn btn-fill btn-success']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>

</div>

