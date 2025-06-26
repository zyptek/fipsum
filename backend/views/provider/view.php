<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Provider $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Proveedores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="provider-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Seguro desea eliminar este ítem?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<?php

    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            [
                'label' => 'Regiones',
                'format' => 'raw',
                'value' => function ($model) use ($selectedList, $regionList) {

                    $selectedRegionNames = [];
                    foreach($selectedList as $selected) {
                        // Busca el nombre de la región correspondiente al ID
                        foreach ($regionList as $region) {
                            if ($region['id'] == $selected['idregion']) {
                                $selectedRegionNames[] = $region['name'];
                                break;
                            }
                        }
                    }
                    $html = Html::textarea('selected_regions', implode(", ", $selectedRegionNames), [
                        'rows' => 5,
                        'cols' => 50,
                        'readonly' => true, // Solo lectura
                        'class' => 'form-control',
                    ]);
    
                    return $html;
                },
            ],
#            'idregion',
            'city',
            'address',
            'contact',
            'email:email',
            [
            	'attribute' => 'created_at',
            	'value' => function($model){
	            	return substr($model->created_at, 0, 16);
            	}
            ],
            [
            	'attribute' => 'updated_at',
            	'value' => function($model){
	            	return substr($model->updated_at, 0, 16);
            	}
            ],
        ],
    ]) ?>

</div>
