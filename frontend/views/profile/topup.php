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
							Top up
						</h4>

						<div class="bo4 of-hidden size25 m-b-20 m-r-30 float-l">
							<?= $form->field($topup, 'amount')->textInput(['class' => 'sizefull s-text7 p-l-22 p-r-22', 'placeholder' => 'Topup amount']); ?>
						</div>

						<div class="w-size25">
							<button class="flex-c-m size2 bg1 bo-rad-23 hov1 m-text3 trans-0-4" type="submit">
								Request
							</button>
						</div>
					<?php Activeform::end(); ?>

                    

					<div class="container-table-cart pos-relative">
						<div class="wrap-table-purchase-history bgwhite">
							<table class="table-purchase-history">
								<tr class="table-head">
									<th class="w5 t-center">#</th>
									<th class="w30">Transaction</th>
									<th class="w15">Date</th>
									<th class="w15">Amount</th>
									<th class="w20">Status</th>
								</tr>
							</table>
						</div>
					</div>
					

				</div>
			</div>
		</div>
	</div>
</section>