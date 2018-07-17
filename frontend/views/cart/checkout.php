<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\LinkPager;
use frontend\components\CMS;

$this->title = 'Checkout';

$this->registerJsFile(
    '@web/js/ongkir.js',
    ['depends' => [frontend\assets\AppAsset::className()]]);
?>

<!-- Title Page -->
<h2 class="l-text2 t-center p-t-40" style="color: #555;font-size: 40px;">
	Checkout
</h2>

<?php 
	$subtotal = $discount = $grandtotal = 0; 
	if ( $cart ) :
		foreach ($cart as $key => $item) :
			$subtotal += $item['price'] * $item['qty'];
		endforeach;
	endif;
?>

<!-- Cart -->
<section class="cart bgwhite p-t-70 p-b-100">
	<div class="container">

		<!-- Total -->
		<div class="m-r-0 p-lr-15-sm">
			<div class="bo9 p-l-40 p-r-40 p-t-30 p-b-38" style="width: 442px;float: left;">
				<h5 class="m-text20 p-b-24">
					Cart Totals
				</h5>

				<!--  -->
				<div class="flex-w flex-sb-m p-b-12">
					<span class="s-text18 w-size19 w-full-sm">
						Subtotal:
					</span>

					<span class="m-text21 w-size20 w-full-sm">
						IDR <?php echo number_format($subtotal,0,'','.');?>
					</span>
				</div>

				<?php if( !YII::$app->session->get('voucher') ): ?>

				<!--  -->
				<div class="flex-w flex-sb-m p-b-12 bo10 p-t-12">
					<span class="s-text18 w-size19 w-full-sm">
						Discount:
					</span>

					<span class="m-text21 w-size20 w-full-sm">
						IDR <?php echo number_format($discount,0,'','.');?>
					</span>
				</div>

				<?php else: ?>

				<?php
				//print_r($voucher);
				if ( !empty( $voucher['discount_prosentase'] ) ) : 
					$discount = ($voucher['discount_prosentase'] / 100) * $subtotal;
				elseif( !empty( $voucher['discount_price'] ) ) :
					$discount = $voucher['discount_price'];
				else :
					$discount = 0;
				endif;
				?>

				<!--  -->
				<div class="flex-w flex-sb-m p-b-12 bo10 p-t-12">
					<span class="s-text18 w-size19 w-full-sm">
						Discount:
					</span>

					<span class="m-text21 w-size20 w-full-sm">
						IDR <?php echo number_format($discount,0,'','.');?>
					</span>
				</div>

				<?php endif;?>

				<?php $grandtotal = $subtotal - $discount; ?>

				<!--  -->

				<div class="flex-w flex-sb-m p-t-12 p-t-12">
					<span class="s-text18 w-size19 w-full-sm">
						Courier:
					</span>

					<span class="m-text21 w-size20 w-full-sm">
						IDR <span id="ongkir">0</span>
					</span>
				</div>
				<hr>
				<div class="flex-w flex-sb-m p-t-12 p-b-30">
					<span class="m-text22 w-size19 w-full-sm">
						Total:
					</span>

					<span class="m-text21 w-size20 w-full-sm">
						IDR <span id="total"><?php echo number_format($grandtotal,0,'','.');?></span> 
						<input type="hidden" id="ongkos" name="ongkos">
						<input type="hidden" id="jasa" name="jasa">
					</span>
				</div>
			</div>

			<div class="p-l-40 p-r-40 p-t-30 p-b-38" style="float: left;width: calc(100% - 442px);">

				<h5 class="m-text20 p-b-10">
					Shipping
				</h5>

				 <select  id="province" class="select form-control-lg col-lg-12" name="province">
					<option value="">Select Province</option>
					<?php foreach ($province as $p): ?>
						<option value="<?php echo $p->province_id; ?>">
							<?php echo $p->province; ?>
						</option>
					<?php endforeach; ?>
				</select>
				<hr style="padding:5px;">
				
				<select name="city" class="select form-control-lg col-lg-12" id="city">
					<option value="">Select City</option>
				</select>
				<hr style="padding:5px;">

				<select id="courier" class="select form-control-lg col-lg-12" name="courier">
					<option>Select Courier...</option>
					<option value="jne">JNE</option>
					<option value="tiki">TIKI</option>
					<option value="pos">POS Indonesia</option>
				</select>
				<hr style="padding:5px;">
				
				<select name="service" class="select form-control-lg col-lg-12" id="service">
				<option value="">Select Service..</option>
				</select>
				<hr style="padding:5px;">

				<h5 class="m-text20 p-b-10 p-t-30">
					PAYMENT
				</h5>

				<div class="payment-method">
					<ul>
						<li>
							<input type="radio" data-order_button_text="PayPal" value="paypal" name="payment_method" class="input-radio" id="payment_method_paypal" checked="checked">
		                    <label for="payment_method_paypal">
		                    	<img class="image-payment" src="<?php echo Url::to("@web/images/icons/paypal-visa.png"); ?>">
		                    </label>
						</li>
					</ul>
				</div>

				<div class="size12 trans-0-4 m-t-30 m-b-10 m-r-10" style="float: left;">
					<form action="<?php echo Url::to('/paypal');?>" method="post">
						<input id="form-token" type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>"/>
						<input type="submit" value="Continue" name="continue_payment" class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4 size15">
					</form>
				</div>

			</div>
		</div>
	</div>
</section>
