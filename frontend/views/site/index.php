<?php

use frontend\components\CMS;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Home';
?>

    <!-- Slide1 -->
    <section class="slide1">
        <div class="wrap-slick1">

            <div class="slick1">
                <?php if ($headline): ?>
                <?php $counter = 0;foreach ($headline as $item): $counter++;?>
	                <div class="item-slick<?php $counter;?> item<?php $counter;?>-slick1" style="background-image: url(<?php echo $item->image; ?>);">
	                    <div class="wrap-content-slide1 sizefull flex-col-c-m p-l-15 p-r-15 p-t-150 p-b-170">
	                        <span class="caption<?php $counter;?>-slide1 m-text1 t-center animated visible-false m-b-33" data-appear="fadeInDown">
	                            <?php echo $item->title; ?>
	                        </span>

	                        <div class="wrap-btn-slide1 w-size1 animated visible-false" data-appear="zoomIn">
	                            <!-- Button -->
	                            <a href="<?php echo $item->link; ?>" class="flex-c-m size2 bo-rad-23 s-text2 bgwhite hov1 trans-0-4">
	                                <?php echo $item->title; ?>
	                            </a>
	                        </div>
	                    </div>
	                </div>
	                <?php endforeach;?>

                <?php endif;?>
            </div>
        </div>
    </section>

    <!-- Banner -->
    <div class="banner bgwhite p-t-40 p-b-40">
        <div class="container">
            <div class="row">

                <?php foreach (CMS::getCategory() as $key => $value): ?>
                <div class="col-sm-10 col-md-8 col-lg-4 m-l-r-auto">
                    <!-- block1 -->
                    <a href="<?php echo Url::to('/category/' . $value->slug); ?>">
                        <div class="block1 hov-img-zoom pos-relative m-b-30">
                            <?php if ($value->image): ?>
                            <img src="<?php echo $value->image; ?>" alt="IMG-BENNER" class="image-category-homepage">
                            <?php else: ?>
                            <img src="<?php echo Url::to("@web/images/banner-03.jpg "); ?>" alt="IMG-BENNER" class="image-category-homepage">
                            <?php endif;?>

                            <div class="block1-wrapbtn w-size2">
                                <!-- Button -->
                                <a href="<?php echo Url::to('/category/' . $value->slug); ?>" class="flex-c-m size2 m-text2 bg3 hov1 trans-0-4">
                                    <?php echo $value->name; ?>
                                </a>
                            </div>
                        </div>
                    </a>
                </div>


                <?php endforeach;?>

            </div>
        </div>
    </div>

    <!-- Our product -->
    <section class="bgwhite p-t-45 p-b-58">
        <div class="container">
            <div class="sec-title p-b-22">
                <h3 class="m-text5 t-center">
                    Our Products
                </h3>
            </div>

            <!-- Tab01 -->
            <div class="tab01">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#latest" role="tab">Latest</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#featured" role="tab">Featured</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#promoted" role="tab">Promoted</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#best-seller" role="tab">Best Seller</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-t-35">
                    <!-- - -->
                    <div class="tab-pane fade show active" id="best-seller" role="tabpanel">
                        <div class="row">

                            <?php foreach ($product_headline as $product): ?>
                            <a href="<?php echo Url::to('/product/' . $product->slug); ?>">
                            <div class="col-sm-6 col-md-4 col-lg-3 p-b-50">
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


                                        <span class="block2-price m-text6 p-r-5"><br>
                                            IDR
                                            <?php echo number_format($product->price, 0, '', '.'); ?>
                                        </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            </a>
                            <?php endforeach;?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>