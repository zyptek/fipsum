<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Module $model */

$this->title = 'Ingresar Modulo';
$this->params['breadcrumbs'][] = ['label' => 'Modulos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="module-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
