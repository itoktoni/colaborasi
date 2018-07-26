<?php 

use yii\widgets\ActiveForm;
use frontend\components\CMS;

$this->title = 'Profile';
?>

<!-- Content page -->
<section class="bgwhite p-t-55 p-b-65">
	<div class="container">
		<div class="row">
			<?php echo Yii::$app->controller->renderPartial('sidebar'); ?>

			<div class="col-sm-12 col-md-6 col-lg-6 p-b-50">
				<div class="row">
                    
                    <?php $form = ActiveForm::begin(['action' => '/topup', 'options' => ['class' => 'form-profile']]); ?>
						<h4 class="m-text14 p-b-36">
							Top up Request
						</h4>

						<div class="bo4">
							<?= $form->field($topup, 'amount')->textInput(['class' => 'sizefull s-text7 p-l-22 p-r-22', 'placeholder' => 'Amount'])->label('Lalala'); ?>
						</div>

						<div class="clearfix">&nbsp;</div>
						<div class="w-size25">
							<button class="flex-c-m size2 bg1 bo-rad-23 hov1 m-text3 trans-0-4" type="submit">
								Request
							</button>
						</div>
					<?php Activeform::end(); ?>
				</div>

			
			<div class="clearfix">&nbsp;</div>
					<div class="container-table-cart pos-relative">
						<div class="wrap-table-purchase-history bgwhite">
							<table class="table-purchase-history">
							<tbody>
								<tr class="table-head">
									<th class="w5 t-center">#</th>
									<th class="w15">Date</th>
									<th class="w15">Amount</th>
									<th class="w20">Status</th>
								</tr>
								<?php $i = 1; foreach ($topup_history as $item):?>
								<tr class="table-row">
									<th class="w5 t-center"><?php echo $i; ?></th>
									<th class="w15"><?php echo $item->create_at; ?></th>
									<th class="w15"><?php echo number_format($item->amount); ?></th>
									<th class="w20"><?php echo CMS::getStatusTopUp($item->status); ?></th>
								</tr>
								<?php ++$i; endforeach; ?>
								</div>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>