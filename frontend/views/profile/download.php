<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use frontend\components\CMS;

$this->title = 'Downloads';

?>

<!-- Content page -->
<section class="bgwhite p-t-55 p-b-65">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-md-4 col-lg-3 p-b-50">
				<div class="leftbar p-r-20 p-r-0-sm">
					<h4 class="m-text14 p-b-7">
						Details
					</h4>
					<ul class="p-b-54">
						<li class="p-t-4">
							<a href="<?php echo Url::to('/profile');?>" class="s-text13 <?php echo CMS::activeSidebar($this->params['menu'], 'profile'); ?>">
								Profile
							</a>
						</li>

						<li class="p-t-4">
							<a href="<?php echo Url::to('/purchase');?>" class="s-text13 <?php echo CMS::activeSidebar($this->params['menu'], 'purchase'); ?>">
								Purchase History
							</a>
						</li>

						<li class="p-t-4">
							<a href="<?php echo Url::to('/download');?>" class="s-text13 <?php echo CMS::activeSidebar($this->params['menu'], 'download'); ?>">
								Downloads
							</a>
						</li>

						<li class="p-t-4">
							<?= Html::beginForm(['/site/logout'], 'post') ?>
                                <?= Html::submitButton(
                                    'Logout',
                                    ['class' => 's-text13']
                                ) ?>
                            <?= Html::endForm() ?>
						</li>
					</ul>
				</div>
			</div>

			<div class="col-sm-6 col-md-8 col-lg-9 p-b-50">
				<div class="row">

					<h4 class="m-text14 p-b-36">
						Downloads
					</h4>

					<div class="container-table-cart pos-relative">
						<div class="wrap-table-purchase-history bgwhite">
							<table class="table-purchase-history">
							
								<tr class="table-head">
									<th class="w10 t-center">#</th>
									<th class="w45">Product</th>
									<th class="w10">Expired At</th>
									<th class="w10">Status</th>
									<th class="w15 t-center">See Detail</th>
								</tr>
								<?php $i=1;foreach($downloads as $item):?>
								<tr class="table-row">
									<td class="w10 t-center"><?=$i;?></td>
									<td class="w45"><?=$item->product_name;?></td>
									<td class="w20"><?=($item->updated_at==$item->create_at)?'Undefined':\backend\components\CMS::format_date($item->expiration_date, 'd-m-Y H:i:s');?></td>
									<td class="w10 c-blue"><?php echo ($item->status)?'Available':'Expired';?></td>
									<td class="w15 t-center">
										<a class="link-download" href="<?php echo Url::to(['/downloads']).'?key='.$item->key;?>"><img class="download" src="<?php echo Url::to('@web/images/icons/download.svg');?>"></a>
									</td>
								</tr>
								<?php $i++; endforeach;?>
							</table>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>