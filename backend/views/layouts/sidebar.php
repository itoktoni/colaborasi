<?php

use backend\components\CMS;
use yii\helpers\Url;

?>

<div class="sidebar" data-active-color="purple" data-background-color="black" data-image="<?php echo Url::to('@web/img/sidebar-1.jpg') ?>">
    <div class="logo">
        <a href="<?php echo Url::to('/dashboard/'); ?>" class="simple-text">
            ONESTOPCLICK
        </a>
    </div>
    <div class="logo logo-mini">
        <a href="<?php echo Url::to('/dashboard/'); ?>" class="simple-text">
            OSC
        </a>
    </div>

    <div class="sidebar-wrapper">
        <div class="user">
            <div class="photo">
                <img src="<?php echo Url::to('@web/img/faces/user.png'); ?>" />
            </div>
            <div class="info">
                <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                <?php if (!Yii::$app->user->isGuest): ?>
                    <?php echo Yii::$app->user->identity->name; ?>
                <?php endif;?>
                    <b class="caret"></b>
                </a>
                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li>
                            <a href="#">My Profile</a>
                        </li>
                        <li>
                            <a href="#">Edit Profile</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav">
            <li <?php echo CMS::activeMenu($this->params['menu'], 'dashboard'); ?> >
                <a href="<?php echo Url::to('/dashboard/'); ?>">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard</p>
                </a>
            </li>
            <?php
$menus = CMS::getMenu();

if ($menus):
    foreach ($menus['group'] as $key => $item):
    ?>
		                        <li <?php echo CMS::activeMenu($this->params['menu'], $key); ?> <?php echo CMS::activeMenu($this->params['menu'], strtolower($key), 'aria-expanded="true"', 'aria-expanded="false"'); ?> >
		                            <a data-toggle="collapse" href="#<?php echo $key; ?>">
		                                <i class="material-icons"><?php echo $item['icon']; ?></i>
		                                <p><?php echo ucwords($item['name']); ?>
		                                    <b class="caret"></b>
		                                </p>
		                            </a>
		                            <div class="<?php echo CMS::activeMenu($this->params['menu'], strtolower($key), 'collapsed collapse in', 'collapsed collapse'); ?>" id="<?php echo $key; ?>"  aria-expanded="true">
		                                <ul class="nav">
		                                    <?php
    foreach ($menus['menu'][$key] as $key => $menu):
        if ($menu['access'] == '0'):
            continue;
        endif;
        ?>
				                                                <li <?php echo CMS::activeMenu($this->params['submenu'], strtolower($menu['slug'])); ?> >
				                                                    <a href="<?php echo Url::to('/' . $menu['slug']); ?>"><?php echo ucwords($menu['name']); ?></a>
				                                                </li>
				                                            <?php
    endforeach;
    ?>
		                                </ul>
		                            </div>
		                        </li>
		                        <?php
endforeach;
endif;
?>
            <li class="">
                <a href="<?php echo Url::to('/site/logout/'); ?>">
                    <i class="material-icons">person</i>
                    <p>Logout</p>
                </a>
            </li>
        </ul>
    </div>
</div>