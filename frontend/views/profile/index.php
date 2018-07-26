<?php 

use yii\widgets\ActiveForm;

$this->title = 'Profile';
?>

<!-- Content page -->
<section class="bgwhite p-t-55 p-b-65">
	<div class="container">
		<div class="row">
			<?php echo Yii::$app->controller->renderPartial('sidebar'); ?>

			<div class="col-sm-6 col-md-8 col-lg-9 p-b-50">
				<div class="row">

					<?php $form = ActiveForm::begin(['action' => '/profile', 'options' => ['class' => 'form-profile']]); ?>
						<h4 class="m-text14 p-b-36">
							Account Detail
						</h4>

						<div class="bo4 size25 m-b-20 m-r-30 float-l">
							<?= $form->field($updateprofile, 'name')->textInput(['value' => $fixed->name, 'class' => 'sizefull s-text7 p-l-22 p-r-22', 'placeholder' => 'Name']); ?>
						</div>

						<div class="bo4 size25 m-b-20 float-l">
							<?= $form->field($updateprofile, 'email')->textInput(['value' => $fixed->email, 'class' => 'sizefull s-text7 p-l-22 p-r-22 readonly', 'placeholder' => 'Email', 'readonly' => '']); ?>
						</div>

						<div class="bo4 size25 m-b-20 m-r-30 float-l">
							<?= $form->field($updateprofile, 'phone_number')->textInput(['value' => $fixed->phone_number, 'class' => 'sizefull s-text7 p-l-22 p-r-22', 'placeholder' => 'Phone Number']); ?>
						</div>

						<div class="bo4 size25 m-b-20 float-l">
							<?= $form->field($updateprofile, 'address')->textInput(['value' => $fixed->address, 'class' => 'sizefull s-text7 p-l-22 p-r-22', 'placeholder' => 'Address']); ?>
						</div>
						<div class="clearfix">&nbsp;</div>

						<div class="w-size25">
							<button class="flex-c-m size2 bg1 bo-rad-23 hov1 m-text3 trans-0-4" type="submit">
								Update
							</button>
						</div>
					<?php Activeform::end(); ?>

					<?php $form = ActiveForm::begin(['action' => '/profile/changepassword', 'options' => ['class' => 'form-profile m-t-50', 'style' => 'width: 100%;']]); ?>
						<h4 class="m-text14 p-b-36">
							Change Password
						</h4>

						<div class="bo4 of-hidden size15 m-b-20">
							<!-- <input class="sizefull s-text7 p-l-22 p-r-22" type="password" name="current_password" placeholder="Current Password"> -->
							<?= $form->field($updatepassword, 'current_password')->passwordInput(['value' => '', 'class' => 'sizefull s-text7 p-l-22 p-r-22', 'placeholder' => 'Current Password']); ?>
						</div>

						<div class="bo4 of-hidden size25 m-b-20 float-l m-r-30">
							<!-- <input class="sizefull s-text7 p-l-22 p-r-22" type="password" name="password" placeholder="New Password"> -->
							<?= $form->field($updatepassword, 'password')->passwordInput(['value' => '', 'class' => 'sizefull s-text7 p-l-22 p-r-22', 'placeholder' => 'New Password']); ?>
						</div>

						<div class="bo4 of-hidden size25 m-b-20 float-l">
							<!-- <input class="sizefull s-text7 p-l-22 p-r-22" type="password" name="confirm_password" placeholder="Confirm Password"> -->
							<?= $form->field($updatepassword, 'confirm_password')->passwordInput(['value' => '', 'class' => 'sizefull s-text7 p-l-22 p-r-22', 'placeholder' => 'Confirm Password']); ?>
						</div>

						<div class="w-size4">
							<!-- Button -->
							<button class="flex-c-m size2 bg1 bo-rad-23 hov1 m-text3 trans-0-4" type="submit">
								Change Password
							</button>
						</div>
					<?php Activeform::end(); ?>

				</div>
			</div>
		</div>
	</div>
</section>