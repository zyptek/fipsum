<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\City $model */

$this->title = 'Crear Ciudad';
$this->params['breadcrumbs'][] = ['label' => 'Ciudades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
