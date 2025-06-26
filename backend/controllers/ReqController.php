<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use backend\models\Req;
use backend\models\Reqhist;
use backend\models\ReqSearch;
use backend\models\Provider;
use backend\models\Pquote;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

/**
 * ReqController implements the CRUD actions for Req model.
 */
class ReqController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
	            'access' => [
					'class' => AccessControl::className(),
/*                     'denyCallback' => function ($rule, $action) {
                        // Redirigir al usuario si no tiene acceso
                        Yii::$app->session->setFlash('error', 'No tiene permiso para acceder a esta sección.');
                        return Yii::$app->response->redirect(['site/index']);
                    }, */
					'rules' => [
						[
							'actions' => [],//aplica a todas las acciones
							'allow' => true,
							'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
								return true;
							}
						],
						[
							'actions' => [],//aplica a todas las acciones
							'allow' => true,
#							'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
	                            $actionsAsView = ['getBranches', 'getSolicitor', 'quote', 'exportAr', 'exportAst'];
	                            $actionToCheck = in_array($action->id, $actionsAsView) ? 'view' : $action->id;
								return Yii::$app->permissionCheck->checkPermission($this->id, $actionToCheck);
							}

						],
					],
				],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Req models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ReqSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

		$dataProvider->query->andWhere(['!=', 'idstatus', 12]);
		$dataProvider->query->andWhere(['req.active' => 1]);
		
		$dataProvider->sort->defaultOrder = [
		    'id' => SORT_DESC,
		];
		
		$this->createMenu();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Req model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {	
	    $myId = $id;
#	    Yii::info('Id recibido view1: ' . $id, __METHOD__);
#	    $id = Yii::$app->security->decryptByKey($id, Yii::$app->params['encryptionKey']);
#	    Yii::info('Id recibido view2: ' . $idx, __METHOD__);
#	    if ($idx === false) {
#		    Yii::error('Falló el descifrado de $id: ' . $id, __METHOD__);
#		}
		
		$cotis = Pquote::find()->where(['idreq' => $id])->asArray()->all();
		
		$tecnicos = User::find()
        ->joinWith(['profile.role']) // Relación con profile y role
#        ->where(['role.id' => 5]) // Filtrar por ID del rol "técnico"
		->where(['>', 'role.id', 1])
		->andWhere(['<', 'role.id', 11])
        ->all(); 
		
		
		# verificamos condiciones para enviar al menú
		$hasRend = \backend\models\Docrend::find()->where(['idreq' => $id])->andWhere(['idsolicitor' => Yii::$app->user->id ])->one();
		$hasPquote = count($cotis) > 0 ? true : false;
		$this->createMenu($id, $hasRend, $hasPquote);

        return $this->render('view', [
	        'pquotes' => $cotis,
	        'tec' => $tecnicos,
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Req model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Req();
        $reqhistModel = new Reqhist();
		
		
        if ($this->request->isPost) {
	        $model->idkam = Yii::$app->user->id;
            if ($model->load($this->request->post()) && $model->save(false)) {
				$reqhistModel->iduser = Yii::$app->user->id;
				$reqhistModel->idreq = $model->id;
				$reqhistModel->idhisttype = 1;
				$reqhistModel->detail = "Ingreso de RQ";
				if ($reqhistModel->save()) {
					Yii::$app->session->setFlash('success', 'El modelo y el segundo modelo se guardaron correctamente.');
                	return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
	        Yii::$app->session->setFlash('error', 'Request no es Post');
            $model->loadDefaultValues();
        }
		
		$this->createMenu();
		
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Req model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
		
		$this->createMenu($id);

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Req model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
#        $this->findModel($id)->delete();
		
		# TODO Incorporar lógica de anulación
		$model = $this->findModel($id);
    
	    if ($model) {
	        $model->active = 0; // Marcar como inactivo
	        $model->idstatus = 12; // Status "Anulado"
	        if ($model->save(false)) { // Guardar sin validación
	            Yii::$app->session->setFlash('success', 'El registro ha sido desactivado correctamente.');
	            return $this->redirect(['index']);
	        } else {
	            Yii::$app->session->setFlash('error', 'No se pudo desactivar el registro.');
	            return false;
	        }
	    }
        return $this->redirect(['index']);
    }
 
     /**
     * Closes an existing Req model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionClose($id)
    {
#        $this->findModel($id)->delete();
		
		# TODO Incorporar lógica de anulación
		$model = $this->findModel($id);
    
	    if ($model) {
#	        $model->active = 0; // Marcar como inactivo
	        $model->idrev = 1;
	        $model->idstatus = 13; // Status "Anulado"
	        if ($model->save(false)) { // Guardar sin validación
	            Yii::$app->session->setFlash('success', 'El requerimiento ha sido cerrado correctamente.');
	            return $this->redirect(['index']);
	        } else {
	            Yii::$app->session->setFlash('error', 'No se pudo cerrar el requerimiento.');
	            return false;
	        }
	    }
        return $this->redirect(['index']);
    }
   
    /**
     * Displays a single Req model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionQuote($id)
    {
	    $providers = Provider::find()->all();
	    $model = $this->findModel($id);
		
	    if ($this->request->isPost){
			$selectedProviders = Yii::$app->request->post('selectedProviders', []);
			foreach ($selectedProviders as $providerId) {
				# Creamos nuevo modelo
				$quoteModel = new Pquote();
				$quoteModel->idprovider = $providerId;
				$quoteModel->idreq = $id;
			
				if(($this->request->post()) && $quoteModel->save(false)){
					Yii::$app->session->setFlash('success', 'El modelo y el segundo modelo se guardaron correctamente.');
				}
				$providers = Provider::find()->where(['id' => $selectedProviders])->all();
			    foreach ($providers as $provider) {
				    $quote = Pquote::find()->where(['idreq' => $id, 'idprovider' => $provider->id])->one();
			        if (!empty($provider->email) && $quote == null) {
			            Yii::$app->mailer->compose()
			                ->setFrom('no-reply@fipsum.com') // Cambia este correo por el remitente de tu aplicación
			                ->setTo($provider->email)
			                ->setSubject('Nueva Solicitud de cotización')
			                ->setTextBody("Hola {$provider->name},\n\nLe informamos que ha sido seleccionado para una nueva solicitud.\n\nDetalles:\nSolicitud ID: {$model->id}\nDescripción: {$model->description}\n\nSaludos cordiales.")
			                ->setHtmlBody("<p>Hola <strong>{$provider->name}</strong>,</p><p>Le informamos que ha sido seleccionado para una nueva solicitud.</p><p><strong>Detalles:</strong><br>Solicitud ID: {$model->id}<br>Descripción: {$model->description}</p><p>Saludos cordiales.</p>")
			                ->send();
			        }
			    }
		    }
		    return $this->redirect(['pquote/index', 'idreq' => $id]);
	    }else{
	        return $this->render('quote', [
		        'pQuotes' => Pquote::find()->where(['idreq' => $id])->asArray()->all(),
	            'model' => $model,
	            'providers' => $providers,
	        ]);
        }
    }
    /**
     * Finds the Req model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Req the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
#	    Yii::info('Id recibido1: ' . $id, __METHOD__);
#	    $id = base64_decode($id);
#	    $id = Yii::$app->security->decryptByKey($id, Yii::$app->params['encryptionKey']);
#		    Yii::info('Id recibido: ' . $id, __METHOD__);
        if (($model = Req::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionGetBranches($company_id)
	{
	    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
	
	    $branches = \backend\models\Branch::find()
	        ->where(['idcompany' => $company_id])
	        ->select(['id', 'name'])
	        ->asArray()
	        ->all();
		
	    return $branches;
	}
	public function actionGetSolicitor($company_id)
	{
	    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
	
	    $solicitorList = \backend\models\Solicitor::find()
	        ->where(['idcompany' => $company_id])
	        ->select(['id', 'name'])
	        ->asArray()
	        ->all();
		
	    return $solicitorList;
	}
	public function actionExportWord($id)
    {
        $model = $this->findModel($id); // Busca el modelo por ID

        // Ruta del template
        $templatePath = Yii::getAlias('@backend/templates/template-req.docx');

        // Verifica si existe el archivo del template
        if (!file_exists($templatePath)) {
            throw new NotFoundHttpException('El template no fue encontrado.');
        }

        // Cargar el template
        $templateProcessor = new TemplateProcessor($templatePath);

        // Reemplazar las variables del template con datos del modelo
        $templateProcessor->setValue('fecha_impr', date('d-m-y'));
        $templateProcessor->setValue('num_req', $model->id);
        $templateProcessor->setValue('cliente', $model->company->alias);
        $templateProcessor->setValue('solicitor', $model->solicitor->name);
        $templateProcessor->setValue('gestor', "Fernanda Rosas");
        $templateProcessor->setValue('tipo_venta', $model->tos->name);
        $templateProcessor->setValue('activity', $model->activity->name);
        $templateProcessor->setValue('desc', mb_strimwidth($model->inidetail, 0, 25, '...'));
        $templateProcessor->setValue('lugar', $model->branch->name);
        $templateProcessor->setValue('dirección', $model->id);
        $templateProcessor->setValue('ciudad', $model->id);
        $templateProcessor->setValue('zona', $model->id);


        // Guardar el archivo generado temporalmente
        $tempFile = tempnam(sys_get_temp_dir(), 'requerimiento') . '.docx';
        $templateProcessor->saveAs($tempFile);

        // Enviar el archivo al navegador para descarga
        return Yii::$app->response->sendFile($tempFile, 'requerimiento-' . $model->id . '.docx', ['inline' => false])
            ->on(\yii\web\Response::EVENT_AFTER_SEND, function () use ($tempFile) {
                unlink($tempFile); // Eliminar el archivo temporal después de enviarlo
            });
    }
    
    public function actionExportAst($id)
    {
		$model = $this->findModel($id); // Busca el modelo por ID

        // Ruta del template
        $templatePath = Yii::getAlias('@backend/templates/template-ast.docx');

        // Verifica si existe el archivo del template
        if (!file_exists($templatePath)) {
            throw new NotFoundHttpException('El template no fue encontrado.');
        }

        // Cargar el template
        $templateProcessor = new TemplateProcessor($templatePath);

        // Reemplazar las variables del template con datos del modelo
        $templateProcessor->setValue('no_req',$model->id);

        // Guardar el archivo generado temporalmente
        $tempFile = tempnam(sys_get_temp_dir(), 'ast') . '.docx';
        $templateProcessor->saveAs($tempFile);

        // Enviar el archivo al navegador para descarga
        return Yii::$app->response->sendFile($tempFile, 'ast-' . $model->id . '.docx', ['inline' => false])
            ->on(\yii\web\Response::EVENT_AFTER_SEND, function () use ($tempFile) {
                unlink($tempFile); // Eliminar el archivo temporal después de enviarlo
            });
    }
    public function actionExportAr($id)
    {
        $model = $this->findModel($id); // Busca el modelo por ID

        // Ruta del template
        $templatePath = Yii::getAlias('@backend/templates/template-ar.xlsx');

        // Verifica si existe el archivo del template
        if (!file_exists($templatePath)) {
            throw new NotFoundHttpException('El template no fue encontrado.');
        }

        // Cargar el template
        $spreadsheet = IOFactory::load($templatePath);

        // Obtener la hoja activa
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('L3', $model->id);
        $sheet->setCellValue('L4', $model->nst);
        $sheet->setCellValue('L5',date('d-m-Y'));
        $sheet->mergeCells('K7:M7');
        $sheet->setCellValue('K7', ucfirst($model->profile->name . " " . $model->profile->lastname));
        $sheet->mergeCells('K9:M9');
        $sheet->setCellValue('K9', $model->tos->name);
        $sheet->mergeCells('E7:G7');
        $sheet->setCellValue('E7', $model->solicitor->name);
        $sheet->mergeCells('E8:G8');
        $sheet->setCellValue('E8', $model->company	->name);
        $sheet->mergeCells('E9:G9');
        $sheet->setCellValue('E9', $model->branch->name);
        $sheet->mergeCells('E10:G10');
        $sheet->setCellValue('E10', $model->branch->address);


#		$sheet->setCellValue('M36',$model->subtotal);
		
        // Guardar el archivo generado temporalmente
        $tempFile = tempnam(sys_get_temp_dir(), 'ar-') . $model->id . '.xlsx';
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($tempFile);

        // Enviar el archivo al navegador para descarga
        return Yii::$app->response->sendFile($tempFile, 'acta-recepción-' . $model->id . '.xlsx', ['inline' => false])
            ->on(\yii\web\Response::EVENT_AFTER_SEND, function () use ($tempFile) {
                unlink($tempFile); // Eliminar el archivo temporal después de enviarlo
            });
    }
    
    public function actionTec($id){
	    
	    $req = Req::findOne($id);
	
	    if ($req === null) {
	        throw new NotFoundHttpException("La solicitud no existe.");
	    }
	
	    if (Yii::$app->request->isPost) {
	        $tecId = Yii::$app->request->post('tecId');
	        $req->tecasigned = $tecId; // Asignar el técnico al modelo Req
	        if ($req->save(false)) {
	            Yii::$app->session->setFlash('success', 'Técnico asignado correctamente.');
	        } else {
	            Yii::$app->session->setFlash('error', 'No se pudo asignar el técnico.');
	        }
	    }
	    return $this->redirect(['index']);	
    }
    protected function createMenu($id = null, $hasRend = null, $hasPquote = false)
    {
	    $controller = $this->id;
	    $action = $this->action->id;
	    
		switch ($action) {
			case 'index':
				$menuArr = [
				    1 => [ // Controller	
					    'id' => $controller,
				        'label' => "Requerimientos",
#				        'rules' => [ '>' => 5 ],
				        'items' => [
				            1 => [
								'url' => 'index',
				                'label' => 'Ver Todos',
				#                'rules' => ['==' => 1],
				            ],
				            2 => [
				            	'url' => 'create',
				                'label' => 'Nuevo',
				#                'rules' => ['==' => 1],
				            ],
				        ],
				    ],
				];
				break;
			case 'view':
				$menuArr = [
				    1 => [ // Controller
				    	'id' => $controller,
				        'label' => "Requerimientos",
				        'rules' => [
					        
				        ],
				        
				        'items' => [
				            1 => [
					            'url' => 'index',
				                'label' => 'Ver Todos',
				            ],
				            2 => [
					            'url' => 'create',
				                'label' => 'Nuevo',
				            ],
				            3 => 'divider',
				            4 => [
					            'url' => 'update',
					            'label' => 'Actualizar',
					            'params' => ['id' => $id]
				            ],
				            5 => [
				            	'url' => 'delete',
					            'label' => 'Anular',
					            'params' => ['id' => $id],
								'data' => [
									'method' => 'post',
									'confirm' => '¿Está seguro de que desea anular este requerimiento?',
								],
								'rules' => [
									"!=" => 5,
								]
				            ],
				            6 => 'divider',
				            7 => [
				            	'url' => 'close',
					            'label' => 'Cerrar Requerimiento',
					            'params' => ['id' => $id]
				            ],
				        ],
				    ],
				    2 => [
					    'id' => $controller,
					    'label' => 'Cotizaciones',
					    'items' => [
					    	1 => [
					    		'url' => 'quote',
						    	'label' => 'Solicitar',
						    	'params' => ['id' => $id]
					    	],
					    	2 => $hasPquote ? [
					    		'url' => 'https://sc.fipsum.cl/pquote/index?idreq='.$id,
						    	'label' => 'Ver Todas de '.$id,
					    	] : null,
					    	3 => 'divider',
					    	4 => $hasPquote ? [
					    		'url' => 'https://sc.fipsum.cl/squote/new?idreq='.$id,
						    	'label' => 'Presupuesto',
					    	] : null,
					    	
					    ],
				    ],
				    3 => [
					    'id' => 'alloc',
					    'label' => 'Asignaciones',
					    'items' => [
					    	1 => [
					    		'url' => 'index',
						    	'label' => 'Ver Asignaciones',
						    	'params' => ['idreq' => $id],
						    	'rules' => [
							    	'>=' => 7,
							    	'<=' => 9,
							    	'>' => 11,
						    	]
					    	],
					    	2 => $hasRend ? [
					    		'url' => 'https://sc.fipsum.cl/docrend/new?idreq',
						    	'label' => 'Llenar Doc Rend ',
					    	] : null,
					    ],
				    ],
				    4 => [
					    'id' => $controller,
					    'label' => 'Exportar',
					    'rules' => ['>' => 5],
					    'items' => [
					    	1 => [
					            'url' => 'export-word',
						    	'label' => 'Requerimiento',
						    	'params' => ['id' => $id]
					    	],
					    	2 => [
					            'url' => 'export-ast',
						    	'label' => 'AST',
						    	'params' => ['id' => $id]
						    ],
					    	3 => [
					            'url' => 'export-ar',
						    	'label' => 'Acta Recep',
						    	'params' => ['id' => $id]
						    	 # 'id' => base64_encode(Yii::$app->security->encryptByKey($model->id,Yii::$app->params['encryptionKey']))
						    ],
					    	4 => [
					            'url' => 'https://sc.fipsum.cl/inftec/new?idreq='.$id,
						    	'label' => 'Doc IT',
						    ]
					    ],
				    ],		    
				];
				break;
				case 'update':
				$menuArr = [
				    1 => [ // Controller	
					    'id' => $controller,
				        'label' => "Requerimientos",
#				        'rules' => [ '>' => 5 ],
				        'items' => [
				            1 => [
								'url' => 'index',
				                'label' => 'Ver Todos',
				#                'rules' => ['==' => 1],
				            ],
				            2 => [
				            	'url' => 'create',
				                'label' => 'Nuevo',
				#                'rules' => ['==' => 1],
				            ],
				        ],
				    ],
				];
				break;
				case 'create':
				$menuArr = [
				    1 => [ // Controller	
					    'id' => $controller,
				        'label' => "Requerimientos",
#				        'rules' => [ '>' => 5 ],
				        'items' => [
				            1 => [
								'url' => 'index',
				                'label' => 'Ver Todos',
				#                'rules' => ['==' => 1],
				            ],
				            2 => [
				            	'url' => 'create',
				                'label' => 'Nuevo',
				#                'rules' => ['==' => 1],
				            ],
				        ],
				    ],
				];
				break;
		}
		Yii::$app->params['menuArr'] = $menuArr;
    }
}
