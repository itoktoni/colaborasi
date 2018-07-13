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

		<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal','enctype' => 'multipart/form-data']]);?>

		<?=$form->field($model, 'name')->textInput(['maxlength' => true, 'autofocus' => true])?>

		<?=$form->field($model, 'slug')->textInput(['maxlength' => true])?>

		<?=Html::img($model->image, ['id' => 'category-image-preview']);?>
        <label class="control-label">Image</label>
            <div class="clearfix"></div>
                    <span class="btn btn-raised btn-round btn-primary btn-file">
                        <span class="fileinput-new">Select image</span>
                        <?=Html::activeFileInput($model, 'image')?>
                    </span>

		<?=$form->field($model, 'description')->textInput(['maxlength' => true])?>

		<?=$form->field($model, 'status')->dropdownList(Yii::$app->cms->status(), ['class' => 'selectpicker', 'data-style' => 'select-with-transition', 'title' => 'Choose Status'])?>

		<div class="form-group">
			<?=Html::a('Back', Url::to('/category/'), ['class' => 'btn btn-fill btn-primary']);?>
			<?=Html::submitButton('Save', ['class' => 'btn btn-fill btn-success'])?>
		</div>

		<?php ActiveForm::end();?>

	</div>

</div>
<?php $this->registerJs("registerSlugify('#category-name','#category-slug');
registerImagepreview('#category-image','#category-image-preview');
");
