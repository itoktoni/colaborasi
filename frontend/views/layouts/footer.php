<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use yii\bootstrap\ActiveForm;

?>

<!-- Footer -->
<footer class="bg6 p-t-45 p-b-43 p-l-45 p-r-45">
	<div class="flex-w p-b-90">
		<div class="w-size6 p-t-30 p-l-15 p-r-15 respon3">
			<h4 class="s-text12 p-b-30">
				GET IN TOUCH
			</h4>

			<div>
				<p class="s-text7 w-size27">
					Lorem ipsum dolor sit amet, at eam errem voluptatum definitiones. Te sea aperiri civibus quaestio. His posse disputationi concludaturque ea. Vim lorem periculis disputationi an.
				</p>

				<div class="flex-m p-t-30">
					<a href="#" class="fs-18 color1 p-r-20 fa fa-facebook"></a>
					<a href="#" class="fs-18 color1 p-r-20 fa fa-instagram"></a>
					<a href="#" class="fs-18 color1 p-r-20 fa fa-pinterest-p"></a>
					<a href="#" class="fs-18 color1 p-r-20 fa fa-snapchat-ghost"></a>
					<a href="#" class="fs-18 color1 p-r-20 fa fa-youtube-play"></a>
				</div>
			</div>
		</div>

		<div class="w-size7 p-t-30 p-l-15 p-r-15 respon4">
			<h4 class="s-text12 p-b-30">
				Links
			</h4>

			<ul>
				<li class="p-b-9">
					<a href="<?php echo Url::to('/site/'); ?>" class="s-text7">
						Home
					</a>
				</li>

				<li class="p-b-9">
					<a href="<?php echo Url::to('/category/'); ?>" class="s-text7">
						Shop
					</a>
				</li>

				<li class="p-b-9">
					<a href="<?php echo Url::to('/site/about/'); ?>" class="s-text7">
						About Us
					</a>
				</li>

				<li class="p-b-9">
					<a href="<?php echo Url::to('/site/contact/'); ?>" class="s-text7">
						Contact Us
					</a>
				</li>
			</ul>
		</div>

		<div class="w-size7 p-t-30 p-l-15 p-r-15 respon4"></div>
		<div class="w-size7 p-t-30 p-l-15 p-r-15 respon4"></div>

		<div class="w-size8 p-t-30 p-l-15 p-r-15 respon3">
			<h4 class="s-text12 p-b-30">
				Newsletter
			</h4>

			 <?php $form = ActiveForm::begin(['id' => 'contact-form','action' => Url::to(['site/subscribe']), 'options' => ['class' => 'login-form']]);?>
				<div class="effect1 w-size9">
					<input class="s-text7 bg6 w-full p-b-5" type="text" name="email" placeholder="email@example.com">
					<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
					<span class="effect1-line"></span>
				</div>

				<div class="w-size2 p-t-20">
					<!-- Button -->
					<button type="submit" class="flex-c-m size2 bg4 bo-rad-23 hov1 m-text3 trans-0-4">
						Subscribe
					</button>
				</div>
            <?php ActiveForm::end();?>
		</div>
	</div>

	<div class="t-center p-l-15 p-r-15">
		<a href="#">
			<img class="h-size2" src="<?php echo Url::to("@web/images/icons/paypal.png"); ?>" alt="IMG-PAYPAL">
		</a>

		<a href="#">
			<img class="h-size2" src="<?php echo Url::to("@web/images/icons/visa.png"); ?>" alt="IMG-VISA">
		</a>

		<a href="#">
			<img class="h-size2" src="<?php echo Url::to("@web/images/icons/mastercard.png"); ?>" alt="IMG-MASTERCARD">
		</a>

		<a href="#">
			<img class="h-size2" src="<?php echo Url::to("@web/images/icons/express.png"); ?>" alt="IMG-EXPRESS">
		</a>

		<a href="#">
			<img class="h-size2" src="<?php echo Url::to("@web/images/icons/discover.png"); ?>" alt="IMG-DISCOVER">
		</a>

		<div class="t-center s-text8 p-t-20">
			Copyright © 2018 All rights reserved.
		</div>
	</div>
</footer>

<!-- Back to top -->
<div class="btn-back-to-top bg0-hov" id="myBtn">
	<span class="symbol-btn-back-to-top">
		<i class="fa fa-angle-double-up" aria-hidden="true"></i>
	</span>
</div>