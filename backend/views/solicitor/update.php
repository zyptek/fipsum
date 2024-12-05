<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Solicitor $model */

$this->title = 'Actualizar Solicitante: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Solicitante', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="solicitor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
