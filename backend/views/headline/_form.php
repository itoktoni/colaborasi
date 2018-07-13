<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\base\Headline */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card-content">

<div class="col-md-4">

	<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal','enctype' => 'multipart/form-data']]); ?>

	    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subtitle')->textInput(['maxlength' => true]) ?>

    <?=Html::img($model->image, ['id' => 'headline-image-preview']);?>
        <label class="control-label">Image</label>
            <div class="clearfix"></div>
                    <span class="btn btn-raised btn-round btn-primary btn-file">
                        <span class="fileinput-new">Select image</span>
                        <?=Html::activeFileInput($model, 'image')?>
                    </span>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

	<div class="form-group">
		<?= Html::a('Back',Url::to('/headline/'), ['class' => 'btn btn-primary']);?>		<?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>

</div>
<?php $this->registerJs("registerImagepreview('#headline-image','#headline-image-preview');");
