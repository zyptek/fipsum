<?php

use backend\models\Ocomp;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\OcompSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Mantenedor';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mant-index">

    <h1><?= Html::encode($this->title) ?></h1>

	<pre>
	<?php
		
/*
		foreach($cities as $key => $city){
			echo $city->name . '<br>';
			if($key > 10) break;
		}
*/
		
	?>
	</pre>
	
	<?= DetailView::widget([
		'model' => $cities,
        'attributes' => [
	        
			[
				'label' => 'Proveedores',
				'format' => 'raw',
				'value' => Html::a('Proveedores',['provider/index']),
			],
			[
				'label' => 'Proveedores',
				'format' => 'raw',
				'value' => Html::a('Proveedores',['provider/index']),
			]
        ],
    ]) ?>
</div>
