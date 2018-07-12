<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- content page -->
<section class="bgwhite p-t-66 p-b-60">
    <div class="container">
        <div class="row">
            <div class="col-md-6 p-b-30">
                <div class="p-r-20 p-r-0-lg">
                    <div class="contact-map size21" id="google_map" data-map-x="-8.7159459" data-map-y="115.2185774" data-pin="<?php echo Url::to("@web/images/icons/placeholder.png"); ?>" data-scrollwhell="0" data-draggable="1"></div>
                </div>
            </div>

            <div class="col-md-6 p-b-30">
                <?php $form = ActiveForm::begin(['id' => 'contact-form', 'options' => ['class' => 'login-form']]); ?>

                    <h4 class="m-text26 p-b-36 p-t-15">
                        Send us your message
                    </h4>

                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'email') ?>

                    <?= $form->field($model, 'subject') ?>

                    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>    

                    <div class="w-size25">
                        <?= Html::submitButton('Submit', ['class' => 'flex-c-m size2 bg1 bo-rad-23 hov1 m-text3 trans-0-4', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>