<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Branch $model */

$this->title = 'Ingresar Sucursal';
$this->params['breadcrumbs'][] = ['label' => 'Sucursales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="branch-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
