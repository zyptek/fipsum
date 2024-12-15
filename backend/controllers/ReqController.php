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
                    'denyCallback' => function ($rule, $action) {
                        // Redirigir al usuario si no tiene acceso
                        Yii::$app->session->setFlash('error', 'No tiene permiso para acceder a esta sección.');
                        return Yii::$app->response->redirect(['site/index']);
                    },
					'rules' => [
						[
#							'actions' => [],//aplica a todas las acciones
							'allow' => true,
#							'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                                return Yii::$app->permissionCheck->checkPermission($this->id, $action->id);
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

		$dataProvider->setSort([
	        'defaultOrder' => [
	            'id' => SORT_DESC, // Orden descendente por 'id'
	        ],
	    ]);
	    
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
        return $this->render('view', [
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
	        $model->idkam = 1;
            if ($model->load($this->request->post()) && $model->save()) {
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
        $this->findModel($id)->delete();

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
			                ->setFrom('no-reply@shipshape.com') // Cambia este correo por el remitente de tu aplicación
			                ->setTo($provider->email)
			                ->setSubject('Nueva solicitud de proveedor')
			                ->setTextBody("Hola {$provider->name},\n\nTe informamos que has sido seleccionado para una nueva solicitud.\n\nDetalles:\nSolicitud ID: {$model->id}\nDescripción: {$model->description}\n\nSaludos cordiales.")
			                ->setHtmlBody("<p>Hola <strong>{$provider->name}</strong>,</p><p>Te informamos que has sido seleccionado para una nueva solicitud.</p><p><strong>Detalles:</strong><br>Solicitud ID: {$model->id}<br>Descripción: {$model->description}</p><p>Saludos cordiales.</p>")
			                ->send();
			        }
			    }
		    }
		    return $this->redirect(['pquote/index', 'idreq' => $id]);
	    }else{
	        return $this->render('quote', [
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
}
