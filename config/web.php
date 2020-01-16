<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
	'name' => 'SMM',
	'language' => 'ru',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'queue'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'DjnSfEkBsodVYNhxnUrY_8aDFaHf0sPK',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
		'queue' => [
			'class' => \yii\queue\db\Queue::class,
			'as log' => \yii\queue\LogBehavior::class,
			'db' => 'db',
			'tableName' => '{{%queue}}',
			'channel' => 'default',
			'mutex' => \yii\mutex\MysqlMutex::class,
		],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        'authClientCollection' => [
            'class'   => \yii\authclient\Collection::className(),
            'clients' => [
                // here is the list of clients you want to use
                'vkontakte' => [
                    'class'        => 'yii\authclient\clients\VKontakte',
                    'clientId'     => 'vk_client_id',
                    'clientSecret' => 'vk_client_secret',
                ],
                'facebook' => [
                    'class'        => 'yii\authclient\clients\Facebook',
                    'clientId'     => 'facebook_client_id',
                    'clientSecret' => 'facebook_client_secret',
                ],
                'google' => [
                    'class'        => 'yii\authclient\clients\Google',
                    'clientId'     => 'google_client_id',
                    'clientSecret' => 'google_client_secret',
                ],
                'yandex' => [
                    'class'        => 'yii\authclient\clients\Yandex',
                    'clientId'     => 'yandex_client_id',
                    'clientSecret' => 'yandex_client_secret'
                ],
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
		'panels' => [
			'queue' => '\yii\queue\debug\Panel',
		],
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['46.146.96.8', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['46.146.96.8', '::1'],
    ];
}

return $config;
