<?php
ini_set('display_errors', '1'); // Mostrar errores en pantalla
ini_set('display_startup_errors', '1'); // Mostrar errores de inicio de PHP
error_reporting(E_ALL); // Reportar todos los tipos de errores

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../../common/config/bootstrap.php';
require __DIR__ . '/../config/bootstrap.php';

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../common/config/main.php',
    require __DIR__ . '/../../common/config/main-local.php',
    require __DIR__ . '/../config/main.php',
    require __DIR__ . '/../config/main-local.php'
);


$ip = $_SERVER['REMOTE_ADDR'];
if($ip != '190.45.243.248'){
	$hora = date('Y-m-d H:i:s');
	$datos = "$hora - $ip\n";
	$ruta_archivo = 'log.txt';
	$archivo = fopen($ruta_archivo, 'a');
	fwrite($archivo, $datos);
	fclose($archivo);
}	

(new yii\web\Application($config))->run();
