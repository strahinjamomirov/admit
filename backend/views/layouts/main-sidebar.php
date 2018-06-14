<?php
/**
 * @author  Agiel K. Saputra <13nightevil@gmail.com>
 */

use codezeen\yii2\adminlte\widgets\Menu;


?>
<aside class="main-sidebar">
    <section class="sidebar">

        <?php
        $adminSiteMenu[0] = [
            'label' => 'Dashboard',
            'icon'  => 'fa fa-dashboard',
            'url'   => ['/site/index'],
        ];

        echo Menu::widget([
            'items' => $adminSiteMenu,
        ])
        ?>

    </section>
</aside>
