<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Req $model */

$this->title = 'Ingresar Requerimiento';
$this->params['breadcrumbs'][] = ['label' => 'Requerimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="req-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
