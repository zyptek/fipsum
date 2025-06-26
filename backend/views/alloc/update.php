<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Alloc $model */

$this->title = 'Actualizar Asignación: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Asignaciones', 'url' =>  isset($idreq) ? ['index', 'idreq' => $idreq] : ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="alloc-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
