<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
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
        'datecontrol' =>  [
            'class' => '\kartik\datecontrol\Module',
            'displaySettings' => [
                \kartik\datecontrol\Module::FORMAT_DATE => 'd-MM-y EE, dd.MM.yyyy',
            ],
            'saveSettings' => [
                \kartik\datecontrol\Module::FORMAT_DATE => 'yyyy-MM-dd',
            ],
            'autoWidgetSettings' => [
                \kartik\datecontrol\Module::FORMAT_DATE => ['type'=>2, 'pluginOptions'=>['autoclose'=>true, 'language' => 'de-DE']],
            ],
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
            'locale' => 'de-DE',
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
