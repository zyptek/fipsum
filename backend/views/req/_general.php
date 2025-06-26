<?php
	
use yii\widgets\Pjax;
#use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

use yii\db\Query;
use yii\web\NotFoundHttpException;
use backend\models\Req;
use kartik\grid\GridView;
use kartik\editable\Editable;
use kartik\bs4dropdown\ButtonDropdown;


$session = Yii::$app->session;
$role = $session->get('userRole');
$estdays = Req::find()->select('estdays')->distinct()->orderBy(['estdays' => SORT_ASC])->asArray()->column();
$subquery = (new Query())
    ->select(['COUNT(*) AS total'])
    ->from('pquote')
    ->groupBy('idreq')
    ->orderBy(['total' => SORT_ASC])
    ->all();
$countOptions = ArrayHelper::map($subquery, 'total', 'total');



Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'bordered' => true,
		'condensed' => true,
		'hover' => true,
		'resizableColumns' => true,
#		'showPageSummary' => true,
		'pjax' => true,

		'panel' => [
        'heading' => '<i class="fas fa-book"></i> '.$this->title,
        'type' => 'secondary',
        'before' => '<div style="padding-top: 7px;"><em>* Resize</em></div>',
		],
		'toolbar' =>  [
        [
            'content' =>
                Html::button('<i class="fas fa-plus"></i>', [
                    'class' => 'btn btn-success',
                    'title' => 'Agregar Ítem',
                    'onclick' => 'alert("This should launch the book creation form.\n\nDisabled for this demo!");'
                ]) . ' '.
                Html::a('<i class="fas fa-redo"></i>', ['grid-demo'], [
                    'class' => 'btn btn-outline-secondary',
                    'title'=>'Restaurar Tabla',
                    'data-pjax' => 0, 
                ]), 
	            'options' => ['class' => 'btn-group mr-2 me-2']
	        ],
	        '{toggleData}',
	    ],

        'columns' => [
#            ['class' => '\kartik\grid\CheckboxColumn'],
            [
	            'class' => 'kartik\grid\DataColumn',
	            'attribute' => 'companyBranch',
	            'label' => 'Cliente',
	            'enableSorting' => true,
#	            'pageSummary' => 'Page Total',
#	            'headerOptions'=>['class'=>'kv-sticky-column'],
#				'contentOptions'=>['class'=>'kv-sticky-column'],
#				'editableOptions'=>['header'=>'Cliente', 'size'=>'md'],
	            'value' => function ($model) {
			        return $model->company->alias . '/' . $model->branch->name;
			    },            	'visible' => ($role != 5),
				'filter' => Html::activeTextInput($searchModel, 'companyBranch', [
			        'class' => 'form-control',
			    ]),
			    'visible' => ($role != 5)
            ],
            [
	            'attribute' => 'statusCol',
	            'value' => 'status.name',
            	'filter' => Html::activeTextInput($searchModel, 'status', ['class' => 'form-control']),
            ],
            'id',
            [
	            'attribute' => 'kamCol',
	            'value' => function ($model) {
                	return $model->profile->name ? $model->profile->name. " " .$model->profile->lastname : '(No definido)';
            	},
            ],			
            [
	            'attribute' => 'tosCol',
	            'value' => function ($model) {
                	return $model->tos ? $model->tos->name : '(No definido)';
            	},
            ],
            'inidetail',
            [
				'attribute' => 'branch.address'
            ],
/*
            [
	            'attribute' => 'activityCol',
	            'value' => function ($model) {
                	return $model->activity ? $model->activity->name : '(No definido)';
            	},
            ],
*/
            [
	            'attribute' => 'solicitorCol',
	            'value' => function ($model) {
					return $model->solicitor ? $model->solicitor->name : '(No definido)';
            	},
            ],	
/*
			[	'attribute' => 'estdays',
				'label' => 'Tiempo Estimado',
				'filter' => $estdays,
				'filterInputOptions' => ['prompt' => 'Todos', 'class' => 'form-control'],

			],
*/
            [
            	'attribute' => 'created_at',
            	'value' => 'created_at',
            	'format' => ['date', 'php:Y-m-d'], // o simplemente 'text'
			    'filter' => Html::beginTag('div', ['style' => 'display:flex; gap:4px; flex-direction:column']) .
			        Html::activeInput('date', $searchModel, 'created_from', ['class' => 'form-control', 'placeholder' => 'Desde']) .
			        Html::activeInput('date', $searchModel, 'created_to', ['class' => 'form-control', 'placeholder' => 'Hasta']) .
			        Html::endTag('div'),
            ],
/*
            [
	            'attribute' => 'created_at',
	            'label' => 'Tiempo',
            	'value' => function($model){
	            	$fechaOriginal = new DateTime($model->created_at);
	            	$fechaActual = new DateTime();
	            	$dif = $fechaActual->diff($fechaOriginal);
	            	$dias = $dif->days;
					$horas = $dif->h;
					if($dias > 0){
						return "$dias día(s) y $horas hora(s)";
					}else{
						return "$horas hora(s)";
					}
	            	
            	}
            ],
*/
            [
				'attribute' => 'pquoteCount',
            	'label' => 'Cotiz.',
				'value' => function($model){
					return $model->getPquotes()->count();
				},
				'filter' => Html::activeDropDownList(
			        $searchModel,
			        'pquoteCount',
			        $countOptions,
			        ['class' => 'form-control', 'prompt' => 'Todas']
			    ),
			],
#            'nst',
#            'inidetail:ntext',
#            'description:ntext',
#            'idkam',
#            'created_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Req $model, $key, $index, $column) {
#	                $id = base64_encode(Yii::$app->security->encryptByKey($model->id,Yii::$app->params['encryptionKey']));
	                $id = $model->id;
                    return Url::toRoute([$action, 'id' => $id]);
                },
                'visibleButtons' => [
			        'delete' => ($role == 9), // Oculta el botón "eliminar" si $role es 9
			    ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>