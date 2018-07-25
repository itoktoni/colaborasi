<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use frontend\components\CMS;

use common\models\base\PaymentDetail;
use common\models\base\Product;
use common\models\base\Voucher;

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
								<?php if ($purchase) : ?>
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
										<td class="w15 action_detail" rel="<?php echo $item['invoice']; ?>">Details</td>
									</tr>

									<!-- Start Detail Order -->
									<tr class="table-row detail-item <?php echo $item['invoice']; ?>">
										<td colspan="6" class="p-l-20 p-r-20">
											<p class="m-b-20 color3"># ORDER LIST</p>
											<div class="order-list float-l w-full">

												<!-- Get List Product -->
												<?php
													$paymentdetail = PaymentDetail::find()->where(['payment' => $item['id']])->all();
													foreach ($paymentdetail as $product) :
														$getproduct = Product::find()->where(['id' => $product->product])->one();
														if ( $getproduct->image_thumbnail == '') :
															$image = Url::to('@web/images/item-cart-01.jpg');
														else :
															$image = $getproduct->image_thumbnail;
														endif;
												?>

													<!-- Start List Product -->
													<div class="list float-l w-size29 m-b-30">
														<div class="w-size30 m-r-20 float-l"><img class="sizefull" src="<?php echo $image;?>"></div>
														<div class="w-size31 float-l">
															<p class="textbold"><?php echo $product->product_name;?></p>
															<p>Qty : <?php echo $product->qty;?></p>
															<p>Unit Price : IDR <?php echo number_format($product->product_sell_price,0,'','.') ;?></p>
														</div>
													</div>
													<!-- End List Product -->

												<?php endforeach;?>

											</div>

											<div style="clear: both;" class="float-l bo10 sizefull"></div>

											<!-- Start Shipping Detail -->
											<div class="order-list float-l w-full m-t-30">
												<div class="float-l w-size29 m-r-30">
													<p class="float-l w-full color3"># SHIPPING DETAIL </p>

													<!-- If there is shipping -->
													<?php if ($item['shipping_type'] == CMS::SHIPPING_ON) : ?>
													<p class="float-l w-full m-t-20">
														<span class="float-l w-size32">Receiver</span>
														<span class="float-l w-size33">:</span>
														<span class="float-l w-size34"><?php $name = ($item['shipping_receiver'] != '') ? $item['shipping_receiver'] : '-'; echo $name;?></span>
													</p>
													<p class="float-l w-full">
														<span class="float-l w-size32">Address</span>
														<span class="float-l w-size33">:</span>
														<span class="float-l w-size34"><?php $address = ($item['shipping_address'] != '') ? $item['shipping_address'] : '-'; echo $address;?></span>
													</p>
													<p class="float-l w-full">
														<span class="float-l w-size32">Email</span>
														<span class="float-l w-size33">:</span>
														<span class="float-l w-size34"><?php $email = ($item['shipping_email'] != '') ? $item['shipping_email'] : '-'; echo $email;?></span>
													</p>
													<p class="float-l w-full">
														<span class="float-l w-size32">Phone Number</span>
														<span class="float-l w-size33">:</span>
														<span class="float-l w-size34"><?php $phone = ($item['shipping_phone_number'] != '') ? $item['shipping_phone_number'] : '-'; echo $phone;?></span>
													</p>
													<p class="float-l w-full">
														<span class="float-l w-size32">Courier</span>
														<span class="float-l w-size33">:</span>
														<span class="float-l w-size34"><?php $courier = ($item['shipping_courier'] != '') ? $item['shipping_courier'] : '-'; echo strtoupper($courier);?></span>
													</p>
													<p class="float-l w-full">
														<span class="float-l w-size32">Service</span>
														<span class="float-l w-size33">:</span>
														<span class="float-l w-size34"><?php $service = ($item['shipping_courier_service'] != '') ? $item['shipping_courier_service'] : '-'; echo $service;?></span>
													</p>

													<!-- If there isn't shipping -->
													<?php else : ?>
														<p class="float-l w-full m-t-20">There is no shipping detail</p>
													<?php endif;?>
												</div>
												<!-- End Shipping Detail -->

												<!-- Start Total Purchase -->
												<div class="float-l w-size29">
													<p class="float-l w-full color3"># TOTAL PURCHASE </p>
													<p class="float-l w-full m-t-20">
														<span class="float-l w-size32">Subtotal</span>
														<span class="float-l w-size33">:</span>
														<span class="float-l w-size34">IDR <?php echo number_format($item['total_bruto'],0,'','.') ;?></span>
													</p>

													<!-- Get Voucher Code -->
													<?php
														$voucher = Voucher::find()->where(['id' => $item['voucher']])->one(); 
														if ($voucher) :
															$code = $voucher->code;
														else :
															$code = '-';
														endif;
													?>

													<p class="float-l w-full">
														<span class="float-l w-size32">Voucher Code</span>
														<span class="float-l w-size33">:</span>
														<span class="float-l w-size34"><?php echo $code;?></span>
													</p>
													<p class="float-l w-full">
														<span class="float-l w-size32">Discount</span>
														<span class="float-l w-size33">:</span>
														<span class="float-l w-size34">IDR <?php echo number_format($item['total_discount_rupiah'],0,'','.') ;?></span>
													</p>
													<p class="float-l w-full">
														<span class="float-l w-size32">Courier</span>
														<span class="float-l w-size33">:</span>
														<span class="float-l w-size34">IDR <?php echo number_format($item['total_shipping_rupiah'],0,'','.') ;?></span>
													</p>
													<p class="float-l w-full">
														<span class="float-l w-size32">Total</span>
														<span class="float-l w-size33">:</span>
														<span class="float-l w-size34">IDR <?php echo number_format($item['total_net_rupiah'],0,'','.') ;?></span>
													</p>
												</div>
												<!-- End Total Purchase -->

											</div>
										</td>
									</tr>
									<!-- End Detail Order -->

									<?php endforeach; else :?>
									<tr class="table-row">
										<td colspan="6">
											<p class="p-l-20">No data available</p>
										</td>
									</tr>
								<?php endif;?>

							</table>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>