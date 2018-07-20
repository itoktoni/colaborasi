<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use frontend\components\CMS;

$this->title = 'Purchase History';

?>

<!-- Content page -->
<section class="bgwhite p-t-55 p-b-65">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-md-4 col-lg-3 p-b-50">
				<div class="leftbar p-r-20 p-r-0-sm">
					<h4 class="m-text14 p-b-7">
						Details
					</h4>
					<ul class="p-b-54">
						<li class="p-t-4">
							<a href="<?php echo Url::to('/profile');?>" class="s-text13 <?php echo CMS::activeSidebar($this->params['menu'], 'profile'); ?>">
								Profile
							</a>
						</li>

						<li class="p-t-4">
							<a href="<?php echo Url::to('/purchase');?>" class="s-text13 <?php echo CMS::activeSidebar($this->params['menu'], 'purchase'); ?>">
								Purchase History
							</a>
						</li>

						<li class="p-t-4">
							<a href="<?php echo Url::to('/download');?>" class="s-text13 <?php echo CMS::activeSidebar($this->params['menu'], 'download'); ?>">
								Downloads
							</a>
						</li>

						<li class="p-t-4">
							<?= Html::beginForm(['/site/logout'], 'post') ?>
                                <?= Html::submitButton(
                                    'Logout',
                                    ['class' => 's-text13']
                                ) ?>
                            <?= Html::endForm() ?>
						</li>
					</ul>
				</div>
			</div>

			<div class="col-sm-6 col-md-8 col-lg-9 p-b-50">
				<div class="row">

					<h4 class="m-text14 p-b-36">
						Purchase History
					</h4>

					<div class="container-table-cart pos-relative">
						<div class="wrap-table-purchase-history bgwhite">
							<table class="table-purchase-history">
								<tr class="table-head">
									<th class="w5 t-center">#</th>
									<th class="w30">Invoice</th>
									<th class="w15">Date</th>
									<th class="w15">Total Price</th>
									<th class="w20">Status</th>
									<th class="w15">See Detail</th>
								</tr>

								<?php foreach ($purchase as $key => $item) : ?>
								<tr class="table-row">
									<td class="w5 t-center"><?php echo ($key+1);?></td>
									<td class="w30"><?php echo $item['invoice']; ?></td>
									<td class="w15"><?php echo date('d M Y', strtotime($item['created_at']));?></td>
									<td class="w15">IDR <?php echo number_format($item['total_net_rupiah'],0,'','.') ;?></td>
									<td class="w20 c-blue">
										<?php
											if ($item['payment_status'] == 0) :
												echo "Waiting Verification";
											else :
												echo "Confirmed";
											endif;
										?>
									</td>
									<td class="w15 action_detail" rel="<?php echo $item['id']; ?>">Details</td>
								</tr>
								<!-- <tr class="table-row">
									<td colspan="6">
										<div class="col-md-12 purchase-detail">
											<p class="title"># ORDER LIST</p>
											<div class="bo13 p-l-29 m-l-9 p-b-10">
												Subtotal
											</div>
										</div>
									</td>
								</tr> -->
								<?php endforeach;?>

							</table>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>