<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'sourceLanguage' => 'en-US',
    'language' => 'de-DE',
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => false,
			'enableRegistration' => false,
			'enableConfirmation' => false,
            'enableFlashMessages' => true,
            'confirmWithin' => 6 * 3600,
            'admins' => ['admin'],

            // http://site.local/user/admin
            // all users from 'admins' section have access here
        ],
        'rbac' => [
            'class' => 'dektrium\rbac\Module',
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['manager'],
        ],
        'formatter' => [
            'dateFormat' => 'EE, dd.MM.yyyy',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'fileMap' => [
                        'app' => 'app.php'
                    ],
                ],
            ],
        ],
    ],
];
