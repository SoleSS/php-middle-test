<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'jwt' => [
            'class' => 'sizeg\jwt\Jwt',
            'key'   => 'sdmjgfye73.sdl05sb73b5980sjasuydgf023jfhywmnx',
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            // you will configure your module inside this file
            // or if need different configuration for frontend and backend you may
            // configure in needed configs
            'admins' => ['admin', ],
            'adminPermission' => ['Administrator', ],
            'modelMap' => [
                'User' => 'common\models\User',
            ],
        ],
        'rbac' => 'dektrium\rbac\RbacWebModule',
    ],

];
