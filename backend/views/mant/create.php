<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Ocomp $model */

$this->title = 'Ingresar Orden de Compra';
$this->params['breadcrumbs'][] = ['label' => 'Órdenes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ocomp-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
