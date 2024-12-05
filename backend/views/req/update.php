<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Req $model */

$this->title = 'Actualizar Requerimiento: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Requerimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="req-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    
    <?= $this->render('//image/create', [
    'model' => new \backend\models\Image(),
    'relatedId' => $model->id, // ID del modelo Actual
    'relatedModel' => 'Req', // Nombre del modelo
])
?>

</div>
