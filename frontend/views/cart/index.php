<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\LinkPager;
use frontend\components\CMS;

$this->title = 'Cart';

if ( isset($_SESSION['cart']) ) :
	$cart = $_SESSION['cart'];
else :
	$cart = '';
endif;

?>

<!-- Title Page -->
<h2 class="l-text2 t-center p-t-40" style="color: #555;font-size: 40px;">
	Cart
</h2>

<!-- Cart -->
<section class="cart bgwhite p-t-70 p-b-100">
	<div class="container">
		<!-- Cart item -->
		<div class="container-table-cart pos-relative">
			<div class="wrap-table-shopping-cart bgwhite">
				<table class="table-shopping-cart">
					<tr class="table-head">
						<th class="column-1"></th>
						<th class="column-2">Product</th>
						<th class="column-3">Price</th>
						<th class="column-5">Quantity</th>
						<th class="column-5">Total</th>
						<th class="column-5"></th>
					</tr>

					<?php 
						$subtotal = $discount = $grandtotal = 0; 
						if ( $cart ) :
							foreach ($cart as $key => $item) :
					?>

								<tr class="table-row">
									<td class="column-1">
										<div class="cart-img-product b-rad-4 o-f-hidden">
											<img src="<?php echo $item['image'];?>" alt="IMG-PRODUCT">
										</div>
									</td>
									<td class="column-2"><?php echo $item['name'];?></td>
									<td class="column-3">IDR <?php echo number_format($item['price'],0,'','.');?></td>
									<td class="column-5">
										<input class="size8 m-text18 t-center num-product" type="number" name="num-product1" value="1" readonly="">
									</td>
									<td class="column-5">IDR <?php echo number_format($item['price'],0,'','.');?></td>
									<td class="column-5">
										<a href="<?php echo Url::to('/cart/delete/'.$item['id']);?>"><i class="up-mark fs-20 color1 fa fa-close" aria-hidden="true"></i></a>
									</td>
								</tr>

					<?php 
								$subtotal += $item['price'] * $item['qty'];
							endforeach;
						endif;
					?>

				</table>
			</div>
		</div>

		<?php if( !YII::$app->session->get('voucher') ): ?>

		<div class="flex-w flex-sb-m p-t-25 p-b-25 bo8 p-l-35 p-r-60 p-lr-15-sm">
			<form method="post" action="<?php echo Url::to('/cart/voucher');?>">
				<div class="flex-w flex-m w-full-sm">
					<div class="size11 bo4 m-r-10">
						<input type="text" placeholder="Coupon Code" value="" id="coupon_code" class="sizefull s-text7 p-l-22 p-r-22" name="voucher">
						<input id="form-token" type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>"/>
					</div>

					<div class="size12 trans-0-4 m-t-10 m-b-10 m-r-10">
						<input type="submit" value="Apply coupon" name="apply_coupon" class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">
					</div>
				</div>
			</form>
		</div>

		<?php else: ?>

		<?php $voucher = YII::$app->session->get('voucher') ;?>
		<div class="flex-w flex-sb-m p-t-25 p-b-25 bo8 p-l-35 p-r-60 p-lr-15-sm">
			<div class="flex-w flex-m w-full-sm">
				<div class="size11 bo4 m-r-10">
					<input type="text" placeholder="Coupon Code" value="<?php echo $voucher['code'];?>" class="sizefull s-text7 p-l-22 p-r-22">
				</div>

				<div class="size12 trans-0-4 m-t-10 m-b-10 m-r-10">
					<a href="<?php echo Url::to(['/cart/vouchercancel']);?>" class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">REMOVE COUPON</a>
				</div>
			</div>
		</div>

		<?php endif;?>

		<!-- Total -->
		<div class="bo9 w-size18 p-l-40 p-r-40 p-t-30 p-b-38 m-t-30 m-r-0 m-l-auto p-lr-15-sm">
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

			<div class="size15 trans-0-4">
				<!-- Button -->
				<!-- <button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">
					Proceed to Checkout
				</button> -->
				<form action="<?php echo Url::to('/checkout');?>" method="post">
					<input id="form-token" type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>"/>
					<input type="submit" value="Proceed to Checkout" name="checkout" class="flex-c-m sizefull bg1 bo-rad-23 p-t-20 p-b-20 hov1 s-text1 trans-0-4">
				</form>
			</div>
		</div>
	</div>
</section>