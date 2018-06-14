<?php
/**
 * @author  Agiel K. Saputra <13nightevil@gmail.com>
 */

use cebe\gravatar\Gravatar;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<header class="main-header">
    <div class="login-logo"><span
                class="logo-sm"><?= Html::img(Yii::getAlias('@web/logo.png')) ?></span></div>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <?php if ( ! Yii::$app->user->isGuest): ?>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?= Gravatar::widget([
                                'email'   => Yii::$app->user->identity->email,
                                'options' => [
                                    'alt'   => Yii::$app->user->identity->username,
                                    'class' => 'user-image',
                                ],
                                'size'    => 25,
                            ]) ?>

                            <span class="hidden-xs"><?= Yii::$app->user->identity->username; ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <?= Gravatar::widget([
                                    'email'   => Yii::$app->user->identity->email,
                                    'options' => [
                                        'alt'   => Yii::$app->user->identity->username,
                                        'class' => 'img-circle',
                                    ],
                                    'size'    => 84,
                                ]) ?>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <?= Html::a(
                                        Yii::t('app', 'Profile'),
                                        ['/user/settings/account'],
                                        ['class' => 'btn btn-default btn-flat'])
                                    ?>

                                </div>
                                <div class="pull-right">
                                    <?= Html::a(
                                        Yii::t('app', 'Sign Out'),
                                        ['/user/security/logout'],
                                        ['class' => 'btn btn-default btn-flat', 'data-method' => 'post']
                                    ) ?>

                                </div>
                            </li>
                        </ul>
                    </li>
                <?php endif ?>

            </ul>
        </div>
    </nav>
</header>

<style>
    @media (max-width: 767px){

        .skin-blue .main-header .navbar .dropdown-menu li a {
            color: #666!important;
        }
    }
</style>