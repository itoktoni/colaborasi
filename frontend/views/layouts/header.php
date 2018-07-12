<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;

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
						<li class="sale-noti">
							<a href="<?php echo Url::to('/site/'); ?>">Home</a>
						</li>

						<li>
							<a href="<?php echo Url::to('/category/'); ?>">Shop</a>
						</li>

						<li>
							<a href="<?php echo Url::to('/site/about/'); ?>">About</a>
						</li>

						<li>
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
					<span class="header-icons-noti">0</span>

					<!-- Header cart noti -->
					<div class="header-cart header-dropdown">
						<ul class="header-cart-wrapitem">
							<li class="header-cart-item">
								<div class="header-cart-item-img">
									<img src="<?php echo Url::to("@web/images/item-cart-01.jpg"); ?>" alt="IMG">
								</div>

								<div class="header-cart-item-txt">
									<a href="#" class="header-cart-item-name">
										White Shirt With Pleat Detail Back
									</a>

									<span class="header-cart-item-info">
										1 x $19.00
									</span>
								</div>
							</li>

							<li class="header-cart-item">
								<div class="header-cart-item-img">
									<img src="<?php echo Url::to("@web/images/item-cart-02.jpg"); ?>" alt="IMG">
								</div>

								<div class="header-cart-item-txt">
									<a href="#" class="header-cart-item-name">
										Converse All Star Hi Black Canvas
									</a>

									<span class="header-cart-item-info">
										1 x $39.00
									</span>
								</div>
							</li>

							<li class="header-cart-item">
								<div class="header-cart-item-img">
									<img src="<?php echo Url::to("@web/images/item-cart-03.jpg"); ?>" alt="IMG">
								</div>

								<div class="header-cart-item-txt">
									<a href="#" class="header-cart-item-name">
										Nixon Porter Leather Watch In Tan
									</a>

									<span class="header-cart-item-info">
										1 x $17.00
									</span>
								</div>
							</li>
						</ul>

						<div class="header-cart-total">
							Total: $75.00
						</div>

						<div class="header-cart-buttons">
							<div class="header-cart-wrapbtn">
								<!-- Button -->
								<a href="cart.html" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
									View Cart
								</a>
							</div>

							<div class="header-cart-wrapbtn">
								<!-- Button -->
								<a href="#" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
									Check Out
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
			<div class="header-icons-mobile">
				<a href="<?php echo Url::to('/site/login/'); ?>" class="header-wrapicon1 dis-block">
					<img src="<?php echo Url::to("@web/images/icons/icon-header-01.png"); ?>" class="header-icon1" alt="ICON">
				</a>

				<span class="linedivide2"></span>

				<div class="header-wrapicon2">
					<img src="<?php echo Url::to("@web/images/icons/icon-header-02.png"); ?>" class="header-icon1 js-show-header-dropdown" alt="ICON">
					<span class="header-icons-noti">0</span>

					<!-- Header cart noti -->
					<div class="header-cart header-dropdown">
						<ul class="header-cart-wrapitem">
							<li class="header-cart-item">
								<div class="header-cart-item-img">
									<img src="<?php echo Url::to("@web/images/item-cart-01.jpg"); ?>" alt="IMG">
								</div>

								<div class="header-cart-item-txt">
									<a href="#" class="header-cart-item-name">
										White Shirt With Pleat Detail Back
									</a>

									<span class="header-cart-item-info">
										1 x $19.00
									</span>
								</div>
							</li>

							<li class="header-cart-item">
								<div class="header-cart-item-img">
									<img src="<?php echo Url::to("@web/images/item-cart-02.jpg"); ?>" alt="IMG">
								</div>

								<div class="header-cart-item-txt">
									<a href="#" class="header-cart-item-name">
										Converse All Star Hi Black Canvas
									</a>

									<span class="header-cart-item-info">
										1 x $39.00
									</span>
								</div>
							</li>

							<li class="header-cart-item">
								<div class="header-cart-item-img">
									<img src="<?php echo Url::to("@web/images/item-cart-03.jpg"); ?>" alt="IMG">
								</div>

								<div class="header-cart-item-txt">
									<a href="#" class="header-cart-item-name">
										Nixon Porter Leather Watch In Tan
									</a>

									<span class="header-cart-item-info">
										1 x $17.00
									</span>
								</div>
							</li>
						</ul>

						<div class="header-cart-total">
							Total: $75.00
						</div>

						<div class="header-cart-buttons">
							<div class="header-cart-wrapbtn">
								<!-- Button -->
								<a href="cart.html" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
									View Cart
								</a>
							</div>

							<div class="header-cart-wrapbtn">
								<!-- Button -->
								<a href="#" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
									Check Out
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