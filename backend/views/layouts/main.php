<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use backend\assets\AppAsset;
use hail812\adminlte\widgets\LoadingStyle;


\hail812\adminlte3\assets\FontAwesomeAsset::register($this);
\hail812\adminlte3\assets\AdminLteAsset::register($this);
$this->registerCssFile('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback');
$this->registerCssFile('https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css');
$this->registerJsFile('https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js', [
    'depends' => [\yii\web\JqueryAsset::class],
]);
$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');

$publishedRes = Yii::$app->assetManager->publish('@vendor/hail812/yii2-adminlte3/src/web/js');
$this->registerJsFile($publishedRes[1].'/control_sidebar.js', ['depends' => '\hail812\adminlte3\assets\AdminLteAsset']);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <style>
.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(250, 250, 250, 1); /* Fondo semitransparente */
    z-index: 9999; /* Asegúrate de que esté por encima de otros elementos */
    display: flex;
    justify-content: center;
    align-items: center;
}
.overlay i {
    color: #007bff; /* Cambia el color del icono si lo deseas */
}
#preloader i {
    color: #cccccc; /* Cambia a cualquier color que prefieras */
}
#preloader i::before {
    font-family: "Font Awesome 5 Free"; /* Asegúrate de usar la fuente correcta */
    content: "\f110"; /* Código del nuevo ícono (en este caso, 'fa-cog') */
    font-weight: 900; /* Opcional: cambia el grosor del ícono */
}
	    </style>
    <?php $this->head() ?>
	<?php
	#Registro de AppAsset.php
	AppAsset::register($this);
	#$this->registerCssFile('@web/css/custom.css');
	?>
</head>
<body class="hold-transition sidebar-mini">

<?php $this->beginBody() ?>

<div class="wrapper">
	<?= LoadingStyle::widget([
    'iconSize' => 'fa-3x', // Opcional: ajusta el tamaño del icono (fa-1x, fa-2x, etc.)
    'options' => ['id' => 'preloader', 'class' => 'overlay'], // Añade un ID para manipularlo con JavaScript
]);
?>
    <!-- Navbar -->
    <?= $this->render('navbar', ['assetDir' => $assetDir]) ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?= $this->render('sidebar', ['assetDir' => $assetDir]) ?>

    <!-- Content Wrapper. Contains page content -->
    <?= $this->render('content', ['content' => $content, 'assetDir' => $assetDir]) ?>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <?= $this->render('control-sidebar') ?>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?= $this->render('footer') ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
