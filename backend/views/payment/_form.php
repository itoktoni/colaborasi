<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\base\Payments */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payments-form card-content">

	<div class="col-md-4">

		<?php $form = ActiveForm::begin(); ?>
	
		    <?= $form->field($model, 'invoice')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_type')->textInput() ?>

    <?= $form->field($model, 'shipping_type')->textInput() ?>

    <?= $form->field($model, 'user')->textInput() ?>

    <?= $form->field($model, 'user_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_social_media_type')->textInput() ?>

    <?= $form->field($model, 'user_social_media_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'voucher')->textInput() ?>

    <?= $form->field($model, 'voucher_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'voucher_discount_type')->textInput() ?>

    <?= $form->field($model, 'voucher_discount_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tax_amount')->textInput() ?>

    <?= $form->field($model, 'total_bruto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_bruto_dollar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_discount_rupiah')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_discount_dollar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_tax_rupiah')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_tax_dollar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_shipping_rupiah')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_shipping_dollar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_net_rupiah')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_net_dollar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'paypal_payment_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'paypal_amount_dollar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'paypal_amount_rupiah')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'paypal_payer_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'paypal_payer_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'paypal_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_province')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_courier')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_courier_service')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_receiver')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_phone_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shipping_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cc_transaction_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cc_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cc_month')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cc_year')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'payment_status')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>


	    <div class="form-group">
			<?= Html::a('Back',Url::to('/payments/'), ['class' => 'btn btn-fill btn-primary']);?>			<?= Html::submitButton('Save', ['class' => 'btn btn-fill btn-success']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>

</div>

