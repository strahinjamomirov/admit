<?php
return [
    'name'       => 'Confessr',
    'aliases'    => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    'modules'    => [
        'user'     => [
            'class'              => 'dektrium\user\Module',
            'enableConfirmation' => false,
            'enableRegistration' => false,
        ],
        'rbac'     => 'dektrium\rbac\RbacWebModule',
        'gridview' => ['class' => 'kartik\grid\Module'],
        'social' => [
            // the module class
            'class' => 'kartik\social\Module',

            // the global settings for the google-analytics widget
            'google-analytics' => [
                'id' => '',
                'domain' => ''
            ],
            // the global settings for the facebook widget
            'facebook' => [
                'appId' => 'FACEBOOK_APP_ID',
            ],
        ]
    ]
];
