<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = $product->name;

?>

<!-- breadcrumb -->
<div class="bread-crumb bgwhite flex-w p-l-52 p-r-15 p-t-30 p-l-15-sm">
	<a href="<?php echo Url::to('/site/'); ?>" class="s-text16">
		Home
		<i class="fa fa-angle-right m-l-8 m-r-9" aria-hidden="true"></i>
	</a>

	<a href="<?php echo Url::to('/category/' . $category->slug); ?>" class="s-text16">
		<?php echo $category->name; ?>
		<i class="fa fa-angle-right m-l-8 m-r-9" aria-hidden="true"></i>
	</a>

	<span class="s-text17">
		<?php echo $product->name; ?>
	</span>
</div>

<!-- Product Detail -->
<div class="container bgwhite p-t-35 p-b-80">
	<div class="flex-w flex-sb">
		<div class="w-size13 p-t-30 respon5">
			<div class="wrap-slick3 flex-sb flex-w">
				<!-- <div class="wrap-slick3-dots"></div> -->

				<div class="slick3">
					<div class="item-slick3" data-thumb="<?php echo $product->image; ?>">
						<div class="wrap-pic-w">
							<img src="<?php echo $product->image; ?>" alt="IMG-PRODUCT">
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="w-size14 p-t-30 respon5">
			<h4 class="product-detail-name m-text16 p-b-13">
				<?php echo $product->name; ?>
			</h4>

			<span class="m-text17">
				IDR <?php echo number_format($product->price, 0, '', '.'); ?>
			</span>

			<p class="s-text8 p-t-10">
				<?php echo $product->synopsis; ?>
			</p>

			<!--  -->
			<div class="p-t-33 p-b-60">
				<div class="flex-r-m flex-w p-t-10">
					<div class="w-size16 flex-m flex-w">
						<p class="p-r-10">Qty : </p>
						<div class="flex-w bo5 of-hidden m-r-22 m-t-10 m-b-10">
							<input class="size8 m-text18 t-center num-product" type="number" name="num-product" value="1" readonly="">
						</div>

						<div class="btn-addcart-product-detail size9 trans-0-4 m-t-10 m-b-10">
							<a class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4 link-add-to-cart" href="<?php echo Url::to('/cart/add/' . $product->id); ?>">
                                Add to Cart
                            </a>
						</div>
					</div>
				</div>
			</div>

			<div class="p-b-45">
				<span class="s-text8 m-r-35">Brands: <?php echo $brand; ?></span>
				<span class="s-text8">Categories:
					<?php foreach ($subcategory as $key => $sub): ?>
						<a href="<?php echo Url::to('/category/' . $category->slug . '/' . $sub['slug']); ?>"><?php echo $sub['name']; ?></a>
					<?php endforeach;?>
				</span>
			</div>

			<!--  -->
			<?php if (!isset($product->description)): ?>
			<div class="wrap-dropdown-content bo6 p-t-15 p-b-14 active-dropdown-content">
				<h5 class="js-toggle-dropdown-content flex-sb-m cs-pointer m-text19 color0-hov trans-0-4">
					Description
					<i class="down-mark fs-12 color1 fa fa-minus dis-none" aria-hidden="true"></i>
					<i class="up-mark fs-12 color1 fa fa-plus" aria-hidden="true"></i>
				</h5>

				<div class="dropdown-content dis-none p-t-15 p-b-23">
					<p class="s-text8">
						<?php echo $product->description; ?>
					</p>
				</div>
			</div>
				<?php endif;?>

<div class="wrap-dropdown-content bo7 p-t-15 p-b-14">
<h3>Share This Product</h3>
                    <a href="#" class="social-button bg1 bo-rad-23" id="fb-share"><i class="fa fa-facebook"></i></a>
                    <a href="#" class="social-button bg1 bo-rad-23" id="tw-share"><i class="fa fa-twitter"></i></a>
                    <a href="#" class="social-button bg1 bo-rad-23" id="gplus-share"><i class="fa fa-google"></i></a>
</div>

			<div class="wrap-dropdown-content bo7 p-t-15 p-b-14">
				<h5 class="js-toggle-dropdown-content flex-sb-m cs-pointer m-text19 color0-hov trans-0-4">
					Additional information
					<i class="down-mark fs-12 color1 fa fa-minus dis-none" aria-hidden="true"></i>
					<i class="up-mark fs-12 color1 fa fa-plus" aria-hidden="true"></i>
				</h5>

				<div class="dropdown-content dis-none p-t-15 p-b-23">
					<p class="s-text8">
						Fusce ornare mi vel risus porttitor dignissim. Nunc eget risus at ipsum blandit ornare vel sed velit. Proin gravida arcu nisl, a dignissim mauris placerat
					</p>
				</div>
			</div>


			<div class="wrap-dropdown-content bo7 p-t-15 p-b-14">
				<h5 class="js-toggle-dropdown-content flex-sb-m cs-pointer m-text19 color0-hov trans-0-4">
					Reviews (0)
					<i class="down-mark fs-12 color1 fa fa-minus dis-none" aria-hidden="true"></i>
					<i class="up-mark fs-12 color1 fa fa-plus" aria-hidden="true"></i>
				</h5>


				<div class="dropdown-content dis-none p-t-15 p-b-23">
					<p class="s-text8">
						Fusce ornare mi vel risus porttitor dignissim. Nunc eget risus at ipsum blandit ornare vel sed velit. Proin gravida arcu nisl, a dignissim mauris placerat
					</p>
				</div>
			</div>


		</div>
	</div>
</div>

<!-- Relate Product -->
<section class="relateproduct bgwhite p-t-45 p-b-138">
	<div class="container">
		<div class="sec-title p-b-60">
			<h3 class="m-text5 t-center">
				Related Products
			</h3>
		</div>

		<?php if (!empty($related)): ?>

		<!-- Slide2 -->
		<div class="wrap-slick2">
			<div class="slick2">

				<?php foreach ($related as $key => $related_product): ?>
				<div class="item-slick2 p-l-15 p-r-15">
					<!-- Block2 -->
					<div class="block2">
						<div class="block2-img wrap-pic-w of-hidden pos-relative">
							<img src="<?php echo $related_product->image; ?>" alt="IMG-PRODUCT" class="image-product-homepage">

							<div class="block2-overlay trans-0-4">
								<a href="#" class="block2-btn-addwishlist hov-pointer trans-0-4">
									<i class="icon-wishlist icon_heart_alt" aria-hidden="true"></i>
									<i class="icon-wishlist icon_heart dis-none" aria-hidden="true"></i>
								</a>

								<div class="block2-btn-addcart w-size1 trans-0-4">
									<a class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4 link-add-to-cart" href="<?php echo Url::to('/cart/add/' . $related_product->id); ?>">
		                                Add to Cart
		                            </a>
								</div>
							</div>
						</div>

						<div class="block2-txt p-t-20">
							<a href="<?php echo Url::to('/product/' . $related_product->slug); ?>" class="block2-name dis-block s-text3 p-b-5">
								<?php echo $related_product->name; ?>
							</a>

							<span class="block2-price m-text6 p-r-5">
								IDR <?php echo number_format($related_product->price, 0, '', '.'); ?>
							</span>
						</div>
					</div>
				</div>
				<?php endforeach;?>

			</div>
		</div>

		<?php endif;?>

	</div>
</section>

<?php
$url = Yii::$app->request->hostInfo . Yii::$app->request->url;
$this->registerJs("url = '" . $url . "';$('#fb-share').fbSharePopup({ width: '450', height: '300', url: url});
                $('#tw-share').twitterSharePopup({ width: '450', height: '300', url: url});
                $('#gplus-share').gplusSharePopup({ width: '450', height: '300', url: url});");