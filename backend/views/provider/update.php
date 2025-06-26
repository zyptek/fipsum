<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Provider $model */

$this->title = 'Actualizar Proveedor: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Proveedores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="provider-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'selectedList' => $selectedList,
        'regionList' => $regionList,
    ]) ?>

</div>
