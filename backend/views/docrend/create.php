<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Docrend $model */

$this->title = 'Ingresar DR';
$this->params['breadcrumbs'][] = ['label' => 'Documentos Rendición', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docrend-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
