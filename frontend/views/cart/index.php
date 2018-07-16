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
						<th class="column-4 p-l-70">Quantity</th>
						<th class="column-5">Total</th>
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
									<td class="column-4">
										<div class="flex-w bo5 of-hidden w-size17">
											<button class="btn-num-product-down color1 flex-c-m size7 bg8 eff2" style="visibility: hidden;">
												<i class="fs-12 fa fa-minus" aria-hidden="true"></i>
											</button>

											<input class="size8 m-text18 t-center num-product" type="number" name="num-product1" value="1" readonly="">
										</div>
									</td>
									<td class="column-5">IDR <?php echo number_format($item['price'],0,'','.');?></td>
								</tr>

					<?php 
								$subtotal += $item['price'] * $item['qty'];
							endforeach;
						endif;
					?>

				</table>
			</div>
		</div>

		<div class="flex-w flex-sb-m p-t-25 p-b-25 bo8 p-l-35 p-r-60 p-lr-15-sm">
			<div class="flex-w flex-m w-full-sm">
				<div class="size11 bo4 m-r-10">
					<input class="sizefull s-text7 p-l-22 p-r-22" type="text" name="coupon-code" placeholder="Coupon Code">
				</div>

				<div class="size12 trans-0-4 m-t-10 m-b-10 m-r-10">
					<!-- Button -->
					<button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">
						Apply coupon
					</button>
				</div>
			</div>
		</div>

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

			<!--  -->
			<div class="flex-w flex-sb-m p-b-12 bo10 p-t-12">
				<span class="s-text18 w-size19 w-full-sm">
					Discount:
				</span>

				<span class="m-text21 w-size20 w-full-sm">
					IDR <?php echo number_format($discount,0,'','.');?>
				</span>
			</div>

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
				<button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">
					Proceed to Checkout
				</button>
			</div>
		</div>
	</div>
</section>