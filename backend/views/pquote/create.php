<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Pquote $model */

$this->title = 'Ingresar Cotización';
$this->params['breadcrumbs'][] = ['label' => 'Cotizaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pquote-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
