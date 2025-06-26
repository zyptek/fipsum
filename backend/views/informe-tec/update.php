<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Inftec $model */

$this->title = 'Actualizar Informe: ' . $model->idreq;
$this->params['breadcrumbs'][] = ['label' => 'Informes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="inftec-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
