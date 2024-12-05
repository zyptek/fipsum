<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Reqhist $model */

$this->title = 'Update Reqhist: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Reqhists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="reqhist-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
