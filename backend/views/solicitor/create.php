<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Solicitor $model */

$this->title = 'Crear Solicitante';
$this->params['breadcrumbs'][] = ['label' => 'Solicitante', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicitor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
