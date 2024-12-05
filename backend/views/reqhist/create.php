<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Reqhist $model */

$this->title = 'Ingresar Reqhist';
$this->params['breadcrumbs'][] = ['label' => 'Reqhists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reqhist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
