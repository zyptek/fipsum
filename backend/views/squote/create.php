<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Squote $model */

$this->title = 'Ingresar Presupuesto';
$this->params['breadcrumbs'][] = ['label' => 'Presupuestos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="squote-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
