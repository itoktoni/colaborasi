<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Voucher */
/* @var $form yii\widgets\ActiveForm */

if ( empty( $dataProvider ) ) :
    $start_date = '';
    $end_date = '';
else :
    foreach ($dataProvider as $item) :
        $start_date = date('Y-m-d', strtotime($item->start_date));
        $end_date = date('Y-m-d', strtotime($item->end_date));
    endforeach;
endif;

?>

<div class="card-content">

    <div class="col-md-4">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'discount_prosentase')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'discount_price')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <label class="control-label" for="voucher-start_date">Start Date</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right datepicker-date" name="Voucher[start_date]" value="<?php echo $start_date; ?>">
            </div>
            <div class="help-block"></div>
        </div>
        <div class="form-group">
            <label class="control-label" for="voucher-end_date">End Date</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right datepicker-date" name="Voucher[end_date]" value="<?php echo $end_date; ?>">
            </div>
            <div class="help-block"></div>
        </div>

        <?= $form->field($model, 'status')->dropdownList(Yii::$app->cms->status(), ['class' => 'selectpicker', 'data-style' => 'select-with-transition', 'title' => 'Choose Status']) ?>

        <div class="form-group">
            <?= Html::a('Back',Url::to('/voucher/'), ['class' => 'btn btn-fill btn-primary']);?>
            <?= Html::submitButton('Save', ['class' => 'btn btn-fill btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

