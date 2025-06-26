<?php

return [
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'mysql:host=localhost;dbname=scfipsum492db_173799873315747',
            'username' => 'fipsum_user4657',
            'password' => 'cu34NVYVVDeLcPQvqCAndXR',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
				'scheme' => 'smtp',
				'host' => 'mail.shipshape.cl',
				'username' => 'no-reply@shipshape.cl',
				'password' => 'WYKDANQWYKDANQxkCDcJSpxkCD',
				'port' => 587,
			],
        ],    ],
];
