<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use frontend\components\CMS;

/* @var $this yii\web\View */

$this->title = 'Home';
?>

<!-- Slide1 -->
<section class="slide1">
    <div class="wrap-slick1">
        <div class="slick1">
            <div class="item-slick1 item1-slick1" style="background-image: url(<?php echo Url::to("@web/images/master-slide-02.jpg"); ?>);">
                <div class="wrap-content-slide1 sizefull flex-col-c-m p-l-15 p-r-15 p-t-150 p-b-170">
                    <span class="caption2-slide1 m-text1 t-center animated visible-false m-b-33" data-appear="fadeInDown">
                        New Collection 2018
                    </span>

                    <div class="wrap-btn-slide1 w-size1 animated visible-false" data-appear="zoomIn">
                        <!-- Button -->
                        <a href="product.html" class="flex-c-m size2 bo-rad-23 s-text2 bgwhite hov1 trans-0-4">
                            Shop Now
                        </a>
                    </div>
                </div>
            </div>

            <div class="item-slick1 item2-slick1" style="background-image: url(<?php echo Url::to("@web/images/master-slide-02.jpg"); ?>);">
                <div class="wrap-content-slide1 sizefull flex-col-c-m p-l-15 p-r-15 p-t-150 p-b-170">
                    <span class="caption2-slide1 m-text1 t-center animated visible-false m-b-33" data-appear="lightSpeedIn">
                        New Collection 2018
                    </span>

                    <div class="wrap-btn-slide1 w-size1 animated visible-false" data-appear="slideInUp">
                        <!-- Button -->
                        <a href="product.html" class="flex-c-m size2 bo-rad-23 s-text2 bgwhite hov1 trans-0-4">
                            Shop Now
                        </a>
                    </div>
                </div>
            </div>

            <div class="item-slick1 item3-slick1" style="background-image: url(<?php echo Url::to("@web/images/master-slide-02.jpg"); ?>);">
                <div class="wrap-content-slide1 sizefull flex-col-c-m p-l-15 p-r-15 p-t-150 p-b-170">
                    <span class="caption2-slide1 m-text1 t-center animated visible-false m-b-33" data-appear="rotateInUpRight">
                        New Collection 2018
                    </span>

                    <div class="wrap-btn-slide1 w-size1 animated visible-false" data-appear="rotateIn">
                        <!-- Button -->
                        <a href="product.html" class="flex-c-m size2 bo-rad-23 s-text2 bgwhite hov1 trans-0-4">
                            Shop Now
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Banner -->
<div class="banner bgwhite p-t-40 p-b-40">
    <div class="container">
        <div class="row">

            <?php
                $category_list  = ArrayHelper::map(CMS::getCategory(),'id','name'); 
                $slug_list      = ArrayHelper::map(CMS::getCategory(),'id','slug'); 
                $image_list     = ArrayHelper::map(CMS::getCategory(),'id','image'); 
                foreach ($category_list as $key => $value) :
            ?>
            <div class="col-sm-10 col-md-8 col-lg-4 m-l-r-auto">
                <!-- block1 -->
                <div class="block1 hov-img-zoom pos-relative m-b-30">
                    <img src="<?php echo $image_list[$key]; ?>" alt="IMG-BENNER" class="image-category-homepage">

                    <div class="block1-wrapbtn w-size2">
                        <!-- Button -->
                        <a href="<?php echo Url::to('/category/'.$slug_list[$key]); ?>" class="flex-c-m size2 m-text2 bg3 hov1 trans-0-4">
                            <?php echo $value; ?>
                        </a>
                    </div>
                </div>
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

                            <?php foreach ($headline as $product) : ?>
                            <div class="col-sm-6 col-md-4 col-lg-3 p-b-50">
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
                            <?php endforeach;?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>