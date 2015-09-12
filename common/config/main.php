<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'sourceLanguage' => 'en-US',
    'language' => 'en-US',
    //'language' => 'de-DE',
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => false,
			'enableRegistration' => false,
			'enableConfirmation' => false,
            'enableFlashMessages' => false,   // for advanced template, it already shows flash messages
            'confirmWithin' => 6 * 3600,
            'admins' => ['admin'],
            
            // http://site.local/user/admin
            // all users from 'admins' section have access here
        ],
        'rbac_admin' => [
            'class' => 'mdm\admin\Module',
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'formatter' => [
            'dateFormat' => 'E, dd.MM.yyyy',
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'user/*',
            '*',
        ],
    ],
];
