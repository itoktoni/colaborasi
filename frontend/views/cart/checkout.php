<?php

use yii\helpers\Url;

$this->title = 'Checkout';

$this->registerJsFile(
    '@web/js/ongkir.js',
    ['depends' => [frontend\assets\AppAsset::className()]]);

if (YII::$app->session->get('voucher')):
    $voucher = YII::$app->session->get('voucher');
    $code = $voucher['code'];
    $voucher_type = $voucher['voucher_type'];
    $discount_type = $voucher['discount_type'];
    $discount_counter = $voucher['discount_counter'];
    $discount_prosentase = $voucher['discount_prosentase'];
    $discount_price = $voucher['discount_price'];
    $start_date = strtotime($voucher['start_date']);
    $end_date = strtotime($voucher['end_date']);
endif;

?>

 <script src="https://js.stripe.com/v2/"></script>
 <script type="text/javascript">
     Stripe.setPublishableKey("<?php echo Yii::$app->params['stripe_publish']; ?>");
 </script>

<!-- Title Page -->
<h2 class="l-text2 t-center p-t-40" style="color: #555;font-size: 40px;">
	Checkout
</h2>

<?php
$subtotal = $discount = $grandtotal = 0;
if ($cart):
    foreach ($cart as $key => $item):
        $subtotal += $item['price'] * $item['qty'];
    endforeach;
endif;
?>

<!-- Cart -->
<section class="cart bgwhite p-t-70 p-b-100">
	<div class="container">
		<form action="<?php echo Url::to('/continuepayment'); ?>" method="post" id="form-payment">
		<!-- Total -->
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-5" style="width: 442px;float: left;">
					<div class="row">
						<div class="col-md-12 bo9 mb-3 p-l-40 p-r-40 p-t-30 p-b-38">
							<h5 class="m-text20 p-b-24">
								Cart Totals
							</h5>

							<!--  -->
							<div class="flex-w flex-sb-m p-b-12">
								<span class="s-text18 w-size19 w-full-sm">
									Subtotal:
								</span>

								<span class="m-text21 w-size20 w-full-sm">
									IDR <?php echo number_format($subtotal, 0, '', '.'); ?>
								</span>
							</div>

							<?php if (!YII::$app->session->get('voucher')): ?>

							<!--  -->
							<div class="flex-w flex-sb-m p-b-12 bo10 p-t-12">
								<span class="s-text18 w-size19 w-full-sm">
									Discount:
								</span>

								<span class="m-text21 w-size20 w-full-sm">
									IDR <?php echo number_format($discount, 0, '', '.'); ?>
								</span>
							</div>

							<?php else: ?>

							<?php
                            //print_r($voucher);
                            if (!empty($voucher['discount_prosentase'])):
                                $discount = ($voucher['discount_prosentase'] / 100) * $subtotal;
                            elseif (!empty($voucher['discount_price'])):
                                $discount = $voucher['discount_price'];
                            else:
                                $discount = 0;
                            endif;
                            ?>

							<!--  -->
							<div class="flex-w flex-sb-m p-b-12 bo10 p-t-12">
								<span class="s-text18 w-size19 w-full-sm">
									Discount:
								</span>

								<span class="m-text21 w-size20 w-full-sm">
									IDR <?php echo number_format($discount, 0, '', '.'); ?>
								</span>
							</div>

							<?php endif; ?>

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
									IDR <span id="total"><?php echo number_format($grandtotal, 0, '', '.'); ?></span>
								</span>
							</div>
						</div>
						<div id="shipping" class="col-md-12 bo9 p-l-40 p-r-40 p-t-30 p-b-38 mb-3">

							<h5 class="m-text20 p-b-24">
								Shipping Option
							</h5>

                            <!-- <input name="shipping_type" value="1" type="checkbox"  class="s-text7"/><label class="m-l-15 s-text7">Ship Physical Item</label> -->
                            <label class="label-shipping-option">Ship Physical Item(s)
                            	<input type="checkbox" name="shipping_type" class="input-shipping-option" checked="checked" value="1">
                            	<span class="checkmark"></span>
                            </label>
						</div>
						<div id="cc" class="col-md-12 bo9 p-l-40 p-r-40 p-t-30 p-b-38">

							<h5 class="m-text20 p-b-24">
								Credit Card
							</h5>

                            <input type="text"  name="cardnumber" data-stripe="number" id="card" placeholder="Input Valid Card Number (4242424242424242)" class="form-control form-control-lg border">

							<div class="mt-3 pb-3" style="width: 100%;">
								<div class="input-group">
								<input name="month" data-stripe="exp_month" size="2" maxlength="2"  type="text" id="month" placeholder="Expired Month" class="form-control form-control-lg border">
								<input name="year"  maxlength="2" type="text" size="2" data-stripe="exp_year" id="year" placeholder="Expired Year" class="form-control form-control-lg border">
								<input name="cvc"  type="text" maxlength="4" id="cvc" size="4" data-stripe="cvc" placeholder="Code CVC" class="form-control form-control-lg border">
								</div>
							</div>
						</div>
					</div>
				</div>

				<div id="payment" class="col-md-7 bo9 m-l-20 p-l-40 p-r-40 p-t-30 p-b-38" style="float: left;width: calc(100% - 422px);">

						<div id="shipping-process" style="">
							<input type="hidden" id="total-ongkir" name="total_ongkir" value="0">
							<input type="hidden" id="ongkos" name="ongkos">
							<input type="hidden" id="jasa" name="jasa">

							<h5 class="m-text20 p-b-24">
								Shipping
							</h5>

							<input type="text" name="shipping_receiver" value="<?php echo Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->name; ?>" placeholder="Full Name" class="sizefull s-text7">
							<hr style="padding:5px;">

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

							<input type="text" name="shipping_address" value="<?php echo Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->address; ?>" placeholder="Address" class="sizefull s-text7">
							<hr style="padding:5px;">

							<input type="text" name="shipping_mobile" value="" placeholder="Phone Number" class="sizefull s-text7">
							<hr style="padding:5px;">

							<input type="text" name="shipping_email" value="<?php echo Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->email; ?>" placeholder="Email" class="sizefull s-text7">
							<hr style="padding:5px;">

							<select id="courier" class="select form-control-lg col-lg-12" name="courier">
								<option value="">Select Courier...</option>
								<option value="jne">JNE</option>
								<option value="tiki">TIKI</option>
								<option value="pos">POS Indonesia</option>
							</select>
							<hr style="padding:5px;">

							<select name="service" class="select form-control-lg col-lg-12" id="service">
							<option value="">Select Service..</option>
							</select>
							<hr style="padding:5px;">
						</div>

						<h5 class="m-text20 p-b-10 p-t-30">
							PAYMENT
						</h5>

						<div class="payment-method">
							<ul>
								<li class="m-b-10">
				                    <label for="payment_method_balance" style="font-size: 16px;padding-left: 45px;" class="label-payment-option">
				                    	Onestopclick User Balance
										<input type="radio" data-order_button_text="Balance" value="balance" name="payment_method" class="input-radio" id="payment_method_balance" checked="">
										<span class="checkmark"></span>
				                    </label>
								</li>
								<li>
									<label for="payment_method_paypal" class="label-payment-option">
										<img class="image-payment" src="<?php echo Url::to('@web/images/icons/paypal2.png'); ?>">
										<input type="radio" data-order_button_text="PayPal" value="paypal" name="payment_method" class="input-radio" id="payment_method_paypal">
										<span class="checkmark"></span>
									</label>
								</li>
								<li>
									<label for="payment_method_cc" class="label-payment-option">
										<img class="image-payment" src="<?php echo Url::to('@web/images/icons/cc.png'); ?>">
										<input type="radio" data-order_button_text="Credit Card" value="cc" name="payment_method" class="input-radio" id="payment_method_cc">
										<span class="checkmark"></span>
									</label>
								</li>
							</ul>
						</div>

						<div class="size12 trans-0-4 m-t-30 m-b-10 m-r-10" style="float: left;">
							<input id="form-token" type="hidden" name="<?=Yii::$app->request->csrfParam; ?>" value="<?=Yii::$app->request->csrfToken; ?>"/>
							<input type="submit" value="Continue" name="continue_payment" class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4 size15">
						</div>

				</div>
			</div>
		</div>

		</form>
	</div>
</section>