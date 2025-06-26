<?php

use backend\models\Req;
use backend\models\Pquote;
use yii\helpers\Html;

use yii\bootstrap5\Tabs;

use PhpOffice\PhpWord\TemplateProcessor;


/** @var yii\web\View $this */
/** @var backend\models\ReqSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */


$this->title = 'Requerimientos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="req-index">

    <p>
        <?= Html::a('Ingresar Requerimiento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= \yii\bootstrap4\Tabs::widget([
    'items' => [
        [
            'label' => 'General',
            'content' => $this->render('_general', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel
            ]),
            'active' => true,
        ],
        [
            'label' => 'Ejecutados',
            'content' => $this->render('_ejec', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel
            ]),
        ]
    ],
]); ?>
    
    


</div>
<?php
$this->registerJs(<<<JS
$(document).on("ready", function() {
    $('.popover-x:visible').popoverX('hide'); // or use the right CSS selector as per your need
});
JS
);
?>