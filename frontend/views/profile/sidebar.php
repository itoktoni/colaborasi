<?php
use yii\helpers\Url;
use yii\helpers\Html;
use frontend\components\CMS;

?>

<div class="col-sm-6 col-md-4 col-lg-3 p-b-50">
    <div class="leftbar p-r-20 p-r-0-sm">
        <h4 class="m-text14 p-b-7">
            Details
        </h4>
        <ul class="p-b-54">
            <li class="p-t-4">
                <a href="<?php echo Url::to('/profile'); ?>" class="s-text13 <?php echo CMS::activeSidebar($this->params['menu'], 'profile'); ?>">
                    Profile
                </a>
            </li>

            <li class="p-t-4">
                <a href="<?php echo Url::to('/topup'); ?>" class="s-text13 <?php echo CMS::activeSidebar($this->params['menu'], 'topup'); ?>">
                    Topup
                </a>
            </li>

            <li class="p-t-4">
                <a href="<?php echo Url::to('/purchase'); ?>" class="s-text13 <?php echo CMS::activeSidebar($this->params['menu'], 'purchase'); ?>">
                    Purchase History
                </a>
            </li>

            <li class="p-t-4">
                <a href="<?php echo Url::to('/download'); ?>" class="s-text13 <?php echo CMS::activeSidebar($this->params['menu'], 'download'); ?>">
                    Downloads
                </a>
            </li>

            <li class="p-t-4">
                <?= Html::beginForm(['/site/logout'], 'post'); ?>
                    <?= Html::submitButton(
                                    'Logout',
                                    ['class' => 's-text13']
                                ); ?>
                        <?= Html::endForm(); ?>
            </li>
        </ul>
    </div>
</div>