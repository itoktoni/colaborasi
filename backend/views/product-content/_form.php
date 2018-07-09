<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\base\Productcontent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-4 productcontent-form">

	<?php $form = ActiveForm::begin(); ?>

	    <?= $form->field($model, 'product')->textInput() ?>

    <?= $form->field($model, 'embed_type')->textInput() ?>

    <?= $form->field($model, 'content_type')->textInput() ?>

    <?= $form->field($model, 'content')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

	<div class="form-group">
		<?= Html::a('Back',Url::to('/productcontent/'), ['class' => 'btn btn-primary']);?>		<?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
