<?php

namespace backend\controllers;

use Yii;
use backend\models\Pquote;
use common\models\User;
use backend\models\Role;
use backend\models\PquoteSearch;
use backend\models\Req;
use backend\models\Profile;
use backend\models\Company;
use backend\models\Squote;
use backend\models\Squoteprivate;
use backend\models\Poc;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

/**
 * PquoteController implements the CRUD actions for Pquote model.
 */
class PquoteController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
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
     * Lists all Pquote models.
     *
     * @return string
     */
    public function actionIndex($idreq = null)
    {
        $searchModel = new PquoteSearch();
#        $dataProvider = $searchModel->search($this->request->queryParams);
        
        if ($idreq !== null) {
            // Filtrar los datos basados en `idreq`
            $dataProvider = new ActiveDataProvider([
                'query' => $searchModel->find()->where(['idreq' => $idreq]),
            ]);

        } else {
            // Mostrar todos los datos si no hay filtro
            $dataProvider = $searchModel->search($this->request->queryParams);
        }


        return $this->render('index', [
	        'idreq' => $idreq,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pquote model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
	    $model = $this->findModel($id);
	    $tecnicos = User::find()
        ->joinWith(['profile.role']) // Relación con profile y role
        ->where(['role.id' => 5]) // Filtrar por ID del rol "técnico"
        ->all(); 

	    $req = Req::findOne($model->idreq);
        return $this->render('view', [
	        'tec' => $tecnicos,
	        'req' => $req,
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Pquote model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Pquote();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Pquote model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
	    Yii::$app->session->removeAllFlashes();
        $model = $this->findModel($id);
		$model->selected = 1;
		
        if ($this->request->isPost && $model->load($this->request->post())) {
	        $transaction = Yii::$app->db->beginTransaction(); // Inicia transacción
	        try {
	            if (!$model->save(false)) {
	                throw new \Exception('Error al guardar el modelo.');
	            }
	
	            $squote = new Squote();
	            $squote->idreq = $model->idreq;
	            $squote->idpquote = $id;
	
	            if (!$squote->save(false)) {
	                throw new \Exception('Error al guardar Squote: ' . json_encode($squote->errors));
	            }
	
	            $squotePrivate = new Squoteprivate();
	            $squotePrivate->idsquote = $squote->id;
	
	            if (!$squotePrivate->save(false)) {
	                throw new \Exception('Error al guardar Squoteprivate: ' . json_encode($squotePrivate->errors));
	            }
	
	            $transaction->commit(); // Confirma la transacción si todo fue bien
	
	            return $this->redirect(['view', 'id' => $model->id]);
	        } catch (\Exception $e) {
	            $transaction->rollBack(); // Revierte los cambios en caso de error
	            Yii::error($e->getMessage(), __METHOD__); // Loguea el error
	            Yii::$app->session->setFlash('error', 'Hubo un error al actualizar la solicitud.');
	        }
	    }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Pquote model.
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







	/* Action GENERAR PPRESUPUESTO
		*/
		
	public function actionGen($idreq = null)
    {
        if ($idreq === null || $idreq == false) {
            return $this->redirect(['pquote/index']);
        }
#		$idreq = Yii::$app->security->decryptByKey(base64_decode($idreq), Yii::$app->params['encryptionKey']);

		$model = Req::find()->where(['id' => $idreq])->one();
		
        $pquotes = Pquote::find()->where(['idreq' => $idreq])->all();

		$idCompany = $model->idcompany;
		$mc = Company::find()->select("mc")->where(["id" => $model->idcompany])->One();
        return $this->render('gen', [
	        'mc' => $mc,
            'idreq' => $idreq,
            'pquotes' => $pquotes,
            'model' => $model,
        ]);
    }

/*
    public function actionGenerateBudget()
    {
        $data = Yii::$app->request->post();

        if (!isset($data['Squote']) || empty($data['Squote']['items'])) {
            throw new NotFoundHttpException('No se recibieron datos válidos para generar el presupuesto.');
        }

        $squote = Squote::findOne($data['Squote']['id']);
        if (!$squote) {
            throw new NotFoundHttpException('No se encontró el modelo Squote.');
        }

        $squote->items = json_encode($data['Squote']['items']);
        $squote->save();

        return $this->redirect(['view', 'id' => $squote->id]);
    }
*/
    
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


	public function actionExport($id)
    {
        $model = $this->findModel($id); // Busca el modelo por ID
		$profile = Profile::find()->where(['iduser' => $model->req->idkam])->One();
		$role = Role::find()->where(['id' => $profile->idrole])->One();
		$user = User::find()->where(['id' => $profile->iduser])->One();

		# Guardar modelo ocomp
		$poc = Poc::find()->where(['idreq' => $model->req->id])->one();
		if(!$poc){
			$poc = new Poc();
		}
		
		$poc->idtop = 1;
		$poc->idvop = 1;
		$poc->idreq = $model->req->id;
		$poc->iduser = $user->id;
		$poc->idprovider = $model->idprovider;
		
		do {
			$noc = mt_rand(10000, 99999);
		} while (Poc::findOne(['noc' => $noc]));
		$poc->noc = $noc;
		
		$poc->descrip = $model->description;
		$poc->subtotal = $model->cost;
		$poc->neto = $model->cost;
		$poc->iva = ($model->cost * 0.19);
		$poc->total = ($poc->neto + $poc->iva);
        
        if($poc->save(false)){ 
			
			// Ruta del template
			$templatePath = Yii::getAlias('@backend/templates/template-oc.xlsx');

			// Verifica si existe el archivo del template
			if (!file_exists($templatePath)) {
				throw new NotFoundHttpException('El template no fue encontrado.');
			}
			
			// Cargar el template
			$spreadsheet = IOFactory::load($templatePath);
			
			// Obtener la hoja activa
			$sheet = $spreadsheet->getActiveSheet();
			
			$sheet->mergeCells('D15:G15');
			$sheet->setCellValue('D15', ucfirst($profile->name." ".$profile->lastname));
			$sheet->mergeCells('D16:G16');
			$sheet->setCellValue('D16', ucfirst($role->name));
			$sheet->mergeCells('D17:G17');
			$sheet->setCellValue('D17', ucfirst($profile->phone));
			$sheet->mergeCells('D18:G18');
			$sheet->setCellValue('D18', $user->email);
			$sheet->mergeCells('D19:G19');
			$sheet->setCellValue('D19', $role->area);
			$sheet->mergeCells('D21:G21');
			$sheet->setCellValue('D21', $model->req->id);
			$sheet->mergeCells('L15:O15');
			$sheet->setCellValue('L15', ucfirst($model->provider->name));
			$sheet->mergeCells('L16:O16');
			$sheet->setCellValue('L16', ucfirst($model->provider->rut));
			$sheet->mergeCells('L17:O17');
			$sheet->setCellValue('L17', ucfirst($model->provider->address));
			$sheet->mergeCells('L18:O18');
			$sheet->setCellValue('L18', ucfirst($model->provider->giro));
			$sheet->mergeCells('L19:O19');
			$sheet->setCellValue('L19', ucfirst($model->provider->contact));
			$sheet->mergeCells('L20:O20');
			$sheet->setCellValue('L20', ucfirst($model->provider->phone));
			$sheet->mergeCells('L21:O21');
			$sheet->setCellValue('L21', ucfirst($model->provider->email));
			$sheet->setCellValue('N48', $model->cost);
			$sheet->setCellValue('N49', ($model->cost * 0.19));
			
			# Descripción
			$sheet->setCellValue('B25', 1);
			$sheet->mergeCells('C25:J25');
			if($model->description != ""){
				$desc = ucfirst($model->description);
			}else{
				$desc = "No Disponible";
			}
			$sheet->setCellValue('C25', $desc);
			$sheet->setCellValue('K25', 1);
			$sheet->mergeCells('L25:M25');
			$sheet->setCellValue('L25', $model->cost);
			$sheet->mergeCells('N25:O25');
			$sheet->setCellValue('N25', $model->cost);
	
	
			
	
			
	#		$sheet->setCellValue('M36',$model->subtotal);
			
			// Guardar el archivo generado temporalmente
			$tempFile = tempnam(sys_get_temp_dir(), 'oc-') . $model->id . '.xlsx';
			$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
			$writer->save($tempFile);
			
			// Enviar el archivo al navegador para descarga
			return Yii::$app->response->sendFile($tempFile, 'orden-compra-' . $model->id . '.xlsx', ['inline' => false])
				->on(\yii\web\Response::EVENT_AFTER_SEND, function () use ($tempFile) {
					unlink($tempFile); // Eliminar el archivo temporal después de enviarlo
				});
			}
    }
    /**
     * Finds the Pquote model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Pquote the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pquote::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
