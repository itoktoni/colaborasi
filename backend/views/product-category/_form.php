<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\base\Productcategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-4 productcategory-form">

	<?php $form = ActiveForm::begin(); ?>

	    <?= $form->field($model, 'product')->textInput() ?>

    <?= $form->field($model, 'sub_category')->textInput() ?>

	<div class="form-group">
		<?= Html::a('Back',Url::to('/productcategory/'), ['class' => 'btn btn-primary']);?>		<?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
