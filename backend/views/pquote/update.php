<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Pquote $model */

$this->title = 'Update Cotización: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cotizaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="pquote-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]);
    ?>
    <?= $this->render('//image/create', [
    'model' => new \backend\models\Image(),
    'relatedId' => $model->id, // ID del modelo Actual
    'relatedModel' => 'Pquote', // Nombre del modelo
    'idcat' => 9,
	])
	
	?>

</div>
