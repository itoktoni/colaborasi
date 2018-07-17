<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\LinkPager;
use frontend\components\CMS;

$this->title = 'Checkout';

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
				<div class="flex-w flex-sb-m p-t-12 p-b-30">
					<span class="m-text22 w-size19 w-full-sm">
						Total:
					</span>

					<span class="m-text21 w-size20 w-full-sm">
						IDR <?php echo number_format($grandtotal,0,'','.');?>
					</span>
				</div>
			</div>

			<div class="bo9 p-l-40 p-r-40 p-t-30 p-b-38" style="float: left;width: calc(100% - 442px);">
				buat shipping
			</div>
		</div>
	</div>
</section>