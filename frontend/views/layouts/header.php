<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use frontend\components\CMS;

$cart = $_SESSION['cart'];

?>

<!-- Header -->
<header class="header1">
	<!-- Header desktop -->
	<div class="container-menu-header">
		<div class="wrap_header">
			<!-- Logo -->
			<a href="<?php echo Url::to('/site/'); ?>" class="logo">
				<p style="font-size: 30px;font-weight: bold;letter-spacing: 2px;">LOGO</p>
			</a>

			<!-- Menu -->
			<div class="wrap_menu">
				<nav class="menu">
					<ul class="main_menu">
						<li <?php echo CMS::activeMenu($this->params['menu'], 'home'); ?>>
							<a href="<?php echo Url::to('/site/'); ?>">Home</a>
						</li>

						<li <?php echo CMS::activeMenu($this->params['menu'], 'shop'); ?>>
							<a href="<?php echo Url::to('/category/'); ?>">Shop</a>
						</li>

						<li <?php echo CMS::activeMenu($this->params['menu'], 'about'); ?>>
							<a href="<?php echo Url::to('/site/about/'); ?>">About</a>
						</li>

						<li <?php echo CMS::activeMenu($this->params['menu'], 'contact'); ?>>
							<a href="<?php echo Url::to('/site/contact/'); ?>">Contact</a>
						</li>
					</ul>
				</nav>
			</div>

			<!-- Header Icon -->
			<div class="header-icons">
				<div class="header-wrapicon1 dis-block">
					<img src="<?php echo Url::to("@web/images/icons/icon-header-01.png"); ?>" class="header-icon1 js-show-login-popup" alt="ICON">

					<!-- Login Popup -->
					<div class="login-popup login-dropdown">
						<ul>
							<?php if ( Yii::$app->user->isGuest ) : ?>
							<li>
								<a href="<?php echo Url::to('/site/login/'); ?>">Login</a>
							</li>
							<?php else : ?>
							<li style="border-bottom: 0;text-transform: uppercase;">
								<p>Welcome <?php echo Yii::$app->user->identity->name; ?></p>
							</li>
							<li>
								<a href="<?php echo Url::to('/site/profile/'); ?>">Profile</a>
							</li>
							<li>
								<a href="<?php echo Url::to('/site/downloads/'); ?>">Downloads</a>
							</li>
							<li>
								<a href="<?php echo Url::to('/site/purchase-history/'); ?>">Purchase History</a>
							</li>
							<li>
								<?= Html::beginForm(['/site/logout'], 'post') ?>
                                    <?= Html::submitButton(
                                        'Logout',
                                        ['class' => 'link-logout']
                                    ) ?>
                                <?= Html::endForm() ?> 
							</li>
							<?php endif; ?> 
						</ul>
					</div>
				</div>

				<span class="linedivide1"></span>

				<div class="header-wrapicon2">
					<img src="<?php echo Url::to("@web/images/icons/icon-header-02.png"); ?>" class="header-icon1 js-show-header-dropdown" alt="ICON">
					<span class="header-icons-noti"><?php echo CMS::getCountCart();?></span>

					<!-- Header cart noti -->
					<div class="header-cart header-dropdown">

						<?php 
							$subtotal = 0; 
							if ( $cart ) :
						?>
						<ul class="header-cart-wrapitem">
							<?php foreach ($cart as $key => $item) : ?>
								<li class="header-cart-item" style="position: relative;">
									<div class="header-cart-item-img">
										<img src="<?php echo $item['image'];?>" alt="IMG">
									</div>

									<div class="header-cart-item-txt">
										<a href="<?php echo Url::to('/product/'.$item['slug']);?>" class="header-cart-item-name">
											<?php echo $item['name'];?>
										</a>

										<span class="header-cart-item-info">
											<?php echo $item['qty'];?> x IDR <?php echo number_format($item['price'],0,'','.');?>
										</span>
									</div>

									<a class="header-cart-item-close" href="<?php echo Url::to('/cart/delete/'.$key);?>">
										<i class="up-mark fs-12 color1 fa fa-close" aria-hidden="true"></i>
									</a>
								</li>
							<?php
								$subtotal += $item['price'] * $item['qty'];
								endforeach;
							?>
						</ul>

						<div class="header-cart-total" style="text-align: center;">
							Total: IDR <?php echo number_format($subtotal,0,'','.');?>
						</div>

						<?php endif;?>

						<div class="header-cart-buttons">
							<div class="header-cart-wrapbtn" style="margin: 0 auto;">
								<a href="<?php echo Url::to('/cart/'); ?>" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
									View Cart
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Header Mobile -->
	<div class="wrap_header_mobile">
		<!-- Logo moblie -->
		<a href="<?php echo Url::to('/site/'); ?>" class="logo-mobile">
			<p style="font-size: 30px;font-weight: bold;letter-spacing: 2px;">LOGO</p>
		</a>

		<!-- Button show menu -->
		<div class="btn-show-menu">
			<!-- Header Icon mobile -->
			<div class="header-icons-mobile" style="position: relative;">
				<img src="<?php echo Url::to("@web/images/icons/icon-header-01.png"); ?>" class="header-icon1 js-show-login-popup" alt="ICON">

				<!-- Login Popup -->
				<div class="login-popup login-dropdown">
					<ul>
						<?php if ( Yii::$app->user->isGuest ) : ?>
						<li>
							<a href="<?php echo Url::to('/site/login/'); ?>">Login</a>
						</li>
						<?php else : ?>
						<li style="border-bottom: 0;text-transform: uppercase;">
							<p>Welcome <?php echo Yii::$app->user->identity->name; ?></p>
						</li>
						<li>
							<a href="<?php echo Url::to('/site/profile/'); ?>">Profile</a>
						</li>
						<li>
							<a href="<?php echo Url::to('/site/downloads/'); ?>">Downloads</a>
						</li>
						<li>
							<a href="<?php echo Url::to('/site/purchase-history/'); ?>">Purchase History</a>
						</li>
						<li>
							<?= Html::beginForm(['/site/logout'], 'post') ?>
                                <?= Html::submitButton(
                                    'Logout',
                                    ['class' => 'link-logout']
                                ) ?>
                            <?= Html::endForm() ?> 
						</li>
						<?php endif; ?> 
					</ul>
				</div>

				<span class="linedivide2"></span>

				<div class="header-wrapicon2">
					<img src="<?php echo Url::to("@web/images/icons/icon-header-02.png"); ?>" class="header-icon1 js-show-header-dropdown" alt="ICON">
					<span class="header-icons-noti"><?php echo CMS::getCountCart();?></span>

					<!-- Header cart noti -->
					<div class="header-cart header-dropdown">

						<?php 
							$subtotal = 0; 
							if ( $cart ) :
						?>
						<ul class="header-cart-wrapitem">
							<?php foreach ($cart as $key => $item) : ?>
								<li class="header-cart-item" style="position: relative;">
									<div class="header-cart-item-img">
										<img src="<?php echo $item['image'];?>" alt="IMG">
									</div>

									<div class="header-cart-item-txt">
										<a href="#" class="header-cart-item-name">
											<?php echo $item['name'];?>
										</a>

										<span class="header-cart-item-info">
											<?php echo $item['qty'];?> x IDR <?php echo number_format($item['price'],0,'','.');?>
										</span>
									</div>

									<a class="header-cart-item-close" href="<?php echo Url::to('/cart/delete/'.$key);?>">
										<i class="up-mark fs-12 color1 fa fa-close" aria-hidden="true"></i>
									</a>
								</li>
							<?php
								$subtotal += $item['price'] * $item['qty'];
								endforeach;
							?>
						</ul>

						<div class="header-cart-total" style="text-align: center;">
							Total: IDR <?php echo number_format($subtotal,0,'','.');?>
						</div>

						<?php endif;?>

						<div class="header-cart-buttons">
							<div class="header-cart-wrapbtn" style="margin: 0 auto;">
								<a href="<?php echo Url::to('/cart/'); ?>" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
									View Cart
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</div>
		</div>
	</div>

	<!-- Menu Mobile -->
	<div class="wrap-side-menu" >
		<nav class="side-menu">
			<ul class="main-menu">
				<li class="item-menu-mobile">
					<a href="<?php echo Url::to('/site/'); ?>">Home</a>
				</li>

				<li class="item-menu-mobile">
					<a href="<?php echo Url::to('/category/'); ?>">Shop</a>
				</li>

				<li class="item-menu-mobile">
					<a href="<?php echo Url::to('/site/about/'); ?>">About</a>
				</li>

				<li class="item-menu-mobile">
					<a href="<?php echo Url::to('/site/contact/'); ?>">Contact</a>
				</li>
			</ul>
		</nav>
	</div>
</header>