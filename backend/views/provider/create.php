<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Provider $model */

$this->title = 'Ingresar Proveedor';
$this->params['breadcrumbs'][] = ['label' => 'Proveedores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="provider-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'selectedList' => $selectedList,
        'regionList' => $regionList,
    ]) ?>

</div>
