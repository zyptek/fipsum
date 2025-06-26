<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Docrend $model */

$this->title = 'Actualizar DR: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Documentos Rencidión', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="docrend-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
