<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\base\Voucher */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="voucher-form card-content">

	<div class="col-md-4">

		<?php $form = ActiveForm::begin();?>

		    <?=$form->field($model, 'name')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'code')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'description')->textarea(['rows' => 6])?>

    <?=$form->field($model, 'voucher_type')->dropdownList(Yii::$app->cms->voucher_type(), ['class' => 'selectpicker', 'data-style' => 'select-with-transition', 'title' => 'Choose Voucher Type']);?>

    <?=$form->field($model, 'discount_type')->dropdownList(Yii::$app->cms->discount_type(), ['class' => 'selectpicker', 'data-style' => 'select-with-transition', 'title' => 'Choose Discount Type']);?>

    <?=$form->field($model, 'discount_counter', ['options' => ['style' => 'display:none;']])->textInput(['type' => 'number'])?>

    <?=$form->field($model, 'discount_prosentase', ['options' => ['style' => 'display:none;']])->textInput(['maxlength' => true, 'type' => 'number', 'min' => 0, 'max' => 100])->label('Discount Percentage')?>

    <?=$form->field($model, 'discount_price', ['options' => ['style' => 'display:none;']])->textInput(['maxlength' => true, 'type' => 'number'])->label('Discount Amount')?>

            <div class="form-group field-voucher-start_date" style="display:none;">
            <label class="control-label" for="voucher-start_date">Start Date</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <?=$form->field($model, 'start_date')->textInput(['class' => 'form-control pull-right datepicker-date'])->label(false);?>
            </div>
            <div class="help-block"></div>
        </div>
        <div class="form-group field-voucher-end_date" style="display:none;">
            <label class="control-label" for="voucher-end_date">End Date</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <?=$form->field($model, 'end_date')->textInput(['class' => 'form-control pull-right datepicker-date'])->label(false);?>
            </div>
            <div class="help-block"></div>
        </div>

        <?=$form->field($model, 'status')->dropdownList(Yii::$app->cms->status(), ['class' => 'selectpicker', 'data-style' => 'select-with-transition', 'title' => 'Choose Status'])?>


	    <div class="form-group">
            <?=Html::a('Back', Url::to('/voucher/'), ['class' => 'btn btn-fill btn-primary']);?>
            <?=Html::submitButton('Save', ['class' => 'btn btn-fill btn-success'])?>
		</div>

		<?php ActiveForm::end();?>

	</div>

</div>

<?php $this->registerJs("
$('#voucher-voucher_type').on('loaded.bs.select', function (e) {
    toggleHide(this);
  });
$('#voucher-voucher_type').on('hidden.bs.select', function (e) {
    toggleHide(this);
});

$('#voucher-voucher_type').on('loaded.bs.select', function (e) {
    toggleDiscount(this);
  });

$('#voucher-discount_type').on('hidden.bs.select', function (e) {
    toggleDiscount(this);
});


function toggleHide(target){
    if($(target).val() == 2){
        $('.field-voucher-discount_counter').hide();
        $('#voucher-discount_counter').val('0');
        $('.field-voucher-start_date').show();
        $('.field-voucher-end_date').show();
    }else if($(target).val() == 1){
        $('.field-voucher-discount_counter').hide();
        $('#voucher-start_date').val('');
        $('#voucher-end_date').val('');
        $('#voucher-discount_counter').val('0');
        $('.field-voucher-start_date').hide();
        $('.field-voucher-end_date').hide();
    }else if($(target).val() == 3){
        $('#voucher-start_date').val('');
        $('#voucher-end_date').val('');
        $('.field-voucher-discount_counter').show();
        $('.field-voucher-start_date').hide();
        $('.field-voucher-end_date').hide();
    }
}

function toggleDiscount(target){
    if($(target).val() == 1){
        $('.field-voucher-discount_prosentase').show();
        $('.field-voucher-discount_price').hide();
        $('#voucher-discount_price').val('0');
    }else if($(target).val() == 2){
        $('.field-voucher-discount_prosentase').hide();
        $('.field-voucher-discount_price').show();
        
        $('#voucher-discount_prosentase').val('0');
    }
}
");