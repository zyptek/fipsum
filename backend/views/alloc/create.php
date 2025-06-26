<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Alloc $model */

$this->title = 'Ingresar Asignación';
$this->params['breadcrumbs'][] = ['label' => 'Asignaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alloc-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
