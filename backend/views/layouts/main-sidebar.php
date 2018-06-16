<?php
/**
 * @author  Agiel K. Saputra <13nightevil@gmail.com>
 */

use codezeen\yii2\adminlte\widgets\Menu;

$adminSiteMenu[0] = [
    'label' => 'Dashboard',
    'icon'  => 'fa fa-dashboard',
    'url'   => ['/site/index']
];
$adminSiteMenu[1] = [
    'label' => 'Confessions',
    'icon'  => 'fa fa-user-secret',
    'url'   => ['/post/index']
];

$adminSiteMenu[2] = [
    'label' => 'Confession comments',
    'icon'  => 'fa fa-comment',
    'url'   => ['/post-comment/index']
];

$adminSiteMenu[3] = [
    'label' => 'Users IP',
    'icon'  => 'fa fa-pied-piper-alt',
    'url'   => ['/user-ip/index']
];
?>
<aside class="main-sidebar">
    <section class="sidebar">

        <?= Menu::widget([
            'items' => $adminSiteMenu,
        ])
        ?>

    </section>
</aside>
