<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Country $model */

$this->title = 'Cear País';
$this->params['breadcrumbs'][] = ['label' => 'Countries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
