<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\LinkPager;
use frontend\components\CMS;

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
					<!--  -->
					<h4 class="m-text14 p-b-7">
						Categories
					</h4>

					<ul class="p-b-54">
						<?php 
							$sub = CMS::getSubCategory(); 
							foreach ( CMS::getCategory() as $cats ) :
						?>
						<li class="p-t-4 p-b-10">
							<a href="<?php echo Url::to('/category/'.$cats->slug);?>" class="s-text13">
								<?php echo $cats->name;?>
							</a>
							<ul>
								<?php if(isset($sub[$cats->slug])):?>
									<?php foreach($sub[$cats->slug] as $item):?>
										<li class="p-t-4 p-l-20">
											<a href="<?php echo Url::to('/category/'.$cats->slug.'/'.$item->slug);?>" class="s-text13">
												<?php echo $item->name;?>
											</a>
										</li>
									<?php endforeach;?>
								<?php endif;?>

							</ul>
						</li>
						<?php endforeach;?>
					</ul>

					<div class="panel-search search-product pos-relative bo4">
						<input class="s-text7 size6 p-l-23 p-r-50" type="text" id="aa-search-input" name="search" placeholder="Search Products...">

						<button class="flex-c-m size5 ab-r-m color2 color0-hov trans-0-4">
							<i class="fs-12 fa fa-search" aria-hidden="true"></i>
						</button>
					</div>
				</div>
			</div>

			<div class="col-sm-6 col-md-8 col-lg-9 p-b-50">
				<!--  -->
				<div class="flex-sb-m flex-w p-b-35">
					<div class="flex-w">
						<div class="rs2-select2 bo4 of-hidden w-size12 m-t-5 m-b-5 m-r-10">
							<select class="selection-2" name="sorting">
								<option>Default Sorting</option>
								<option>Popularity</option>
								<option>Price: low to high</option>
								<option>Price: high to low</option>
							</select>
						</div>
					</div>

					<span class="s-text8 p-t-5 p-b-5">
						Showing 1–12 of <?php echo count($products);?> results
					</span>
				</div>

				<!-- Product -->
				<div class="row">
					<?php
						if ( $products ) :
							foreach ( $products as $product) :
					?>
					<div class="col-sm-12 col-md-6 col-lg-4 p-b-50">
						<!-- Block2 -->
						<div class="block2">
							<div class="block2-img wrap-pic-w of-hidden pos-relative">
								<img src="<?php echo $product->image;?>" alt="IMG-PRODUCT" class="image-product-homepage">

								<div class="block2-overlay trans-0-4">
									<a href="#" class="block2-btn-addwishlist hov-pointer trans-0-4">
										<i class="icon-wishlist icon_heart_alt" aria-hidden="true"></i>
										<i class="icon-wishlist icon_heart dis-none" aria-hidden="true"></i>
									</a>

									<div class="block2-btn-addcart w-size1 trans-0-4">
										<!-- Button -->
										<a class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4 link-add-to-cart" href="<?php echo Url::to('/cart/add/'.$product->id) ;?>">
                                            Add to Cart
                                        </a>
									</div>
								</div>
							</div>

							<div class="block2-txt p-t-20">
								<a href="<?php echo Url::to('/product/'.$product->slug);?>" class="block2-name dis-block s-text3 p-b-5">
									<?php echo $product->name;?>
								</a>

								<span class="block2-price m-text6 p-r-5">
									IDR <?php echo number_format($product->price,0,'','.');?>
								</span>
							</div>
						</div>
					</div>
				<?php 
						endforeach;
					else :
						?><h1 style="text-align: center;">No Product Found</h1><?php
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
	'linkContainerOptions'	=> 
	[
		'tag' => 'div',
	],
	'linkOptions' => [
		'class' => '',
		'tag' => ''
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

