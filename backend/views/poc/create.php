<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Poc $model */

$this->title = 'Create Poc';
$this->params['breadcrumbs'][] = ['label' => 'Pocs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="poc-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
