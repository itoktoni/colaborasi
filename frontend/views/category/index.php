<?php

use frontend\components\CMS;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Shop';
$this->registerJsFile(
    '@web/js/algolia.js',
    ['depends' => [frontend\assets\AppAsset::className()]]);

?>

	<!-- Content page -->
	<section class="bgwhite p-t-55 p-b-65">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-md-4 col-lg-3 p-b-50">
					<div class="leftbar p-r-20 p-r-0-sm">
						<h4 class="m-text14 p-b-7">
							Search
						</h4>

						<form id="searchbox" method="get" action="">
							<div class="panel-search search-product pos-relative bo4">
								<input class="s-text7 size6 p-l-23 p-r-50" type="text" id="aa-search-input" name="name" placeholder="Search Products..." value="<?php echo YII::$app->request->get('name');?>">

								<button class="flex-c-m size5 ab-r-m color2 color0-hov trans-0-4">
									<i class="fs-12 fa fa-search" aria-hidden="true"></i>
								</button>
							</div>
							<div class="clearfix">&nbsp;</div>

							<div class="rs2-select2 bo4 of-hidden m-t-5 m-b-5">								
								<?php echo Html::dropDownList('sort_order', YII::$app->request->get('sort_order'), ['' => 'Default Sorting','popular' => 'Popularity','price_low' => 'Price: low to high','price_high' => 'Price: high to low'],['class' => 'selection-2']);?>
							</div>
							<div class="clearfix">&nbsp;</div>

							<div class="filter-price p-t-22 p-b-50 bo3">
								<div class="m-text15 p-b-17">
									Price
								</div>

								<div class="wra-filter-bar">
									<div id="filter-bar"></div>
								</div>
								<input type="hidden" id="min" name="min" value="<?php echo YII::$app->request->get('min');?>"/>
								<input type="hidden" id="max" name="max" value="<?php echo YII::$app->request->get('max');?>"/>
								<div class="flex-sb-m flex-w p-t-16">								
									<div class="s-text3 p-t-10 p-b-10">
										Range: <br>IDR <span id="value-lower">0</span> - IDR <span id="value-upper">0</span>
									</div>
								</div>
							</div>

							
                            <button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4 size15">
									Search</button>

							<div class="clearfix">&nbsp;</div>
						</form>

							
							<h4 class="m-text14 p-b-7 m-t-30">
								Categories
							</h4>

							<ul class="p-b-54">
								<?php
									$sub = CMS::getSubCategory();
									foreach (CMS::getCategory() as $cats):
								?>
									<li class="p-t-4 p-b-10">
										<a href="<?php echo Url::to('/category/' . $cats->slug); ?>" class="s-text13">
											<?php echo $cats->name; ?>
										</a>
										<ul>
											<?php if (isset($sub[$cats->slug])): ?>
											<?php foreach ($sub[$cats->slug] as $item): ?>
											<li class="p-t-4 p-l-20">
												<a href="<?php echo Url::to('/category/' . $cats->slug . '/' . $item->slug); ?>" class="s-text13">
													<?php echo $item->name; ?>
												</a>
											</li>
											<?php endforeach;?>
											<?php endif;?>

										</ul>
									</li>
									<?php endforeach;?>
							</ul>
						</div>
					</div>

				<div class="col-sm-6 col-md-8 col-lg-9 p-b-50">
					<!--  -->
					<div class="flex-sb-m flex-w p-b-35">

						<span class="s-text8 p-t-5 p-b-5">
							Showing <?php echo $products->getCount(); ?>–
							<?php echo $products->getCount(); ?> of
							<?php echo $products->getTotalCount(); ?> results
						</span>
					</div>

					<!-- Product -->
					<div class="row">
						<?php
						if ($products):
						    foreach ($products->getModels() as $product):
					    ?>
							<div class="col-sm-12 col-md-6 col-lg-4 p-b-50">
								<!-- Block2 -->
								<div class="block2">
									<div class="block2-img wrap-pic-w of-hidden pos-relative">
										<img src="<?php echo $product->image; ?>" alt="IMG-PRODUCT" class="image-product-homepage">

										<div class="block2-overlay trans-0-4">
											<a href="#" class="block2-btn-addwishlist hov-pointer trans-0-4">
												<i class="icon-wishlist icon_heart_alt" aria-hidden="true"></i>
												<i class="icon-wishlist icon_heart dis-none" aria-hidden="true"></i>
											</a>

											<div class="block2-btn-addcart w-size1 trans-0-4">
												<!-- Button -->
												<a class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4 link-add-to-cart" href="<?php echo Url::to('/cart/add/' . $product->id); ?>">
													Add to Cart
												</a>
											</div>
										</div>
									</div>

									<div class="block2-txt p-t-20">
										<a href="<?php echo Url::to('/product/' . $product->slug); ?>" class="block2-name dis-block s-text3 p-b-5">
											<?php echo $product->name; ?>
										</a>

										<span class="block2-price m-text6 p-r-5">
											IDR
											<?php echo number_format($product->price, 0, '', '.'); ?>
										</span>
									</div>
								</div>
							</div>
						<?php
							endforeach;
						else:
						?>
							<h1 style="text-align: center;">No Product Found</h1>
						<?php
						endif;
						?>
					</div>

					<!-- Pagination -->

					<?php
					echo yii\widgets\LinkPager::widget([
					    'pagination' => $pages,
					    'pageCssClass' => 'item-pagination flex-c-m trans-0-4',
					    'activePageCssClass' => 'active-pagination',
					    'prevPageLabel' => false,
					    'nextPageLabel' => false,
					    'linkContainerOptions' =>
					    [
					        'tag' => 'div',
					    ],
					    'linkOptions' => [
					        'class' => '',
					        'tag' => '',
					    ],
					    'options' => [
					        'tag' => 'div',
					        'class' => 'pagination flex-m flex-w p-t-26',
					    ],
					]);
					?>
				</div>
			</div>
		</div>
	</section>

	<!-- Container Selection -->
	<div id="dropDownSelect1"></div>
	<div id="dropDownSelect2"></div>

	<?php $minz = (YII::$app->request->get('min'))?YII::$app->request->get('min'):0; $maxz = (YII::$app->request->get('max'))?YII::$app->request->get('max'):$max->price;?>
	<?php $this->registerJs("var slider = document.getElementById('filter-bar');
	noUiSlider.create(slider, {
		start: [".$minz.", ".$maxz."],
		connect: true,
		range: {
			'min': ".$min->price.",
			'max': ".$max->price."
		},
		step: 10000
	});

	var skipValues = [
		document.getElementById('value-lower'),
		document.getElementById('value-upper')
		];

		var hiddenValues = [
			document.getElementById('min'),
			document.getElementById('max')
		]



		slider.noUiSlider.on('update', function( values, handle ) {
		hiddenValues[handle].value = Math.round(values[handle]);
		skipValues[handle].innerHTML = Math.round(values[handle]);
	});
	");