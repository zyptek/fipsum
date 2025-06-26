<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'fipsum-admin',
    'name' => 'FIPSUM Dev',
    'language' => 'es-ES',
    'timeZone' => 'America/Santiago',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
	    'gridview' => ['class' => 'kartik\grid\Module'],
    ],
    'components' => [
		'formatter' => [
	        'class' => 'yii\i18n\Formatter',
	        'locale' => 'es_ES',
	        'defaultTimeZone' => 'America/Santiago',
	        'dateFormat' => 'long',
	        'timeFormat' => 'short',
	        'datetimeFormat' => 'medium',
	    ],
	    'dynNavbar' => [
	        'class' => 'backend\components\DynNavbar',
	    ],
        'permissionCheck' => [
            'class' => 'backend\components\PermissionCheck',
        ],
	    'phpWord' => [
	        'class' => 'sasha6806\phpword\PhpWord', // Ruta de la clase
	    ],
	    'view' => [
        	'theme' => [
            	'pathMap' => [
                	'@app/views' => '@backend/views'
				],
			],
		],
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning', 'info', 'trace'],
                    'logVars' => ['_POST', '_GET', '_SESSION', '_SERVER'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'db' => [
        	'enableProfiling' => true,
        	'enableLogging' => true,
		],
    ],
    'params' => $params,
];
