<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\base\Category;

/* @var $this yii\web\View */
/* @var $model common\models\base\Subcategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-4 subcategory-form">

	<?php $form = ActiveForm::begin();?>

	    <?= $form->field($model, 'category')->dropdownList(ArrayHelper::map(Category::find()->where(['status' => 1])->all(),'id','name')); ?> 

    <?=$form->field($model, 'slug')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'name')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'description')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'status')->dropdownList(Yii::$app->cms->status())?>

	<div class="form-group">
		<?=Html::a('Back', Url::to('/subcategory/'), ['class' => 'btn btn-primary']);?>		<?=Html::submitButton('Save', ['class' => 'btn btn-primary'])?>
	</div>

	<?php ActiveForm::end();?>

</div>
