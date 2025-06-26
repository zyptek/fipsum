<?php

namespace backend\controllers;

use Yii;
use backend\models\Squote;
use backend\models\SquoteDetail;
use backend\models\Pquote;
use backend\models\SquoteSearch;
use backend\models\Constants;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

/**
 * SquoteController implements the CRUD actions for Squote model.
 */
class SquoteController extends Controller
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
     * Lists all Squote models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SquoteSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

		if ($this->request->isPost) {
			#Tomamos datos desde POST
			$data = $this->request->post();
			#Creamos nuevo presupuesto
			$model = new Squote();
			# Asignamos datos al modelo Squote
	    	$model->idreq = $data['idreq'];
	    	$model->idpquote = $data['idpquote'];
			
			if (isset($data['item'], $data['detalle'], $data['unidad'], $data['precio_unitario'], $data['cantidad'], $data['total'], $data['idreq'], $data['idpquote'])) {
            	$idreq = $data['idreq'];
				$idpquote = $data['idpquote'];
				
				# Agregamos datos al modelo:
				$model->subtotal = $data['subtotal'] ?? null;
				$model->gg = $data['gg'] ?? null;
				$model->neto = $data['neto'] ?? null;
				$model->iva = $data['iva'] ?? null;
				$model->total = $data['grand-total'] ?? null;


				if($model->save(false)){
					

				
					// Recorremos los arrays
		            foreach ($data['item'] as $index => $item) {
		
		                // Crear y guardar el modelo
		                $squoteDetail = new SquoteDetail();
		                $squoteDetail->idsquote = $model->id;
		                $squoteDetail->idreq = $idreq;
		                $squoteDetail->item = $data['item'][$index] ?? null;
		                $squoteDetail->descrip = $data['detalle'][$index] ?? null;
		                $squoteDetail->unit = $data['unidad'][$index] ?? null;
		                $squoteDetail->cost = $data['precio_unitario'][$index] ?? null;
		                $squoteDetail->quant = $data['cantidad'][$index] ?? null;
		                $squoteDetail->total = $data['total'][$index] ?? null;
				
						if (!$squoteDetail->save()) {
		                    // Manejo de errores si no se puede guardar
		                    Yii::$app->session->setFlash('error', 'Error al guardar el detalle en la fila: ' . $index);
		                    return $this->redirect(['squote/new']);
		                }
					}
					
					Yii::$app->session->setFlash('success', 'Todos los detalles se han guardado correctamente.');
			            return $this->render('index', [
					    	'data' => $data,
				            'searchModel' => $searchModel,
				            'dataProvider' => $dataProvider,
				        ]);
				}else{
					Yii::$app->session->setFlash('error', 'No se pudo crear la cotización.');
				}
	        } else {
	            Yii::$app->session->setFlash('error', 'Faltan datos necesarios en la solicitud.');
	        }
				
	    

	    }else{
	    
	        return $this->render('index', [
	            'searchModel' => $searchModel,
	            'dataProvider' => $dataProvider,
	        ]);
        }
        
    }

    /**
     * Displays a single Squote model.
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
     * Creates a new Squote model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Squote();

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
     * Updates an existing Squote model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        
        $model = $this->findModel($id);
        $idreq = $model->idreq;
		$const = Constants::find(1)->one();
		
		
        if ($this->request->isPost){
            #Tomamos datos desde POST
			$data = $this->request->post();
			# Asignamos datos al modelo Squote

            if (isset($data['item'], $data['detalle'], $data['unidad'], $data['precio_unitario'], $data['cantidad'], $data['total'])){
                
				# Agregamos datos al modelo:
				$model->subtotal = $data['subtotal'] ?? null;
				$model->gg = $data['gg'] ?? null;
				$model->neto = $data['neto'] ?? null;
				$model->iva = $data['iva'] ?? null;
				$model->total = $data['grand-total'] ?? null;

                if($model->save(false)){
                    foreach ($data['item'] as $index => $item) {
		
		                // Crear y guardar el modelo
		                $squoteDetail = new SquoteDetail();
		                $squoteDetail->idsquote = $model->id;
		                $squoteDetail->idreq = $idreq;
		                $squoteDetail->item = $data['item'][$index] ?? null;
		                $squoteDetail->descrip = $data['detalle'][$index] ?? null;
		                $squoteDetail->unit = $data['unidad'][$index] ?? null;
		                $squoteDetail->cost = $data['precio_unitario'][$index] ?? null;
		                $squoteDetail->quant = $data['cantidad'][$index] ?? null;
		                $squoteDetail->total = $data['total'][$index] ?? null;
				
						if (!$squoteDetail->save()) {
		                    // Manejo de errores si no se puede guardar
		                    Yii::$app->session->setFlash('error', 'Error al guardar el detalle en la fila: ' . $index);
		                    return $this->render('update', [
			                    'const' => $const,
                                'model' => $model,
                            ]);
		                }
                    }

                    Yii::$app->session->setFlash('success', 'Todos los detalles se han guardado correctamente.');
                    return $this->redirect(['view', 'id' => $model->id]);
				}else{
					Yii::$app->session->setFlash('error', 'No se pudo crear la cotización.');
                    return $this->render('update', [
	                    'const' => $const,
                        'model' => $model,
                    ]);
				}
            }
            
        }

        return $this->render('update', [
	        'const' => $const,
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Squote model.
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
	
	public function actionGen($idreq = null)
    {
        if ($idreq === null) {
            return $this->redirect(['pquote/index']);
        }

        $squote = new Squote();
        $squote->idreq = $idreq;
        $squote->save(false); // Crea una entrada vacía en Squote sin validaciones
		
        $pquotes = Pquote::find()->where(['idreq' => $idreq])->all();

        return $this->render('gen', [
            'idreq' => $idreq,
            'pquotes' => $pquotes,
            'squote' => $squote,
        ]);
    }

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
    
    public function actionNew()
    {
            
	    $idreq = Yii::$app->request->get('idreq');
	    
	    $pquote = Pquote::find()->where(['idreq' => $idreq])->one();
		$model = Squote::find()->where(['idreq'=> $idreq])->one();
		
        return $this->render('new', [
	        'model' => $model,
	        'idpquote' => $pquote->id,
            'idreq' => $pquote->idreq,
        ]);
    }
    
    public function actionExport($id)
    {
        $model = $this->findModel($id); // Busca el modelo por ID

        // Ruta del template
        $templatePath = Yii::getAlias('@backend/templates/template-ppto.xlsx');

        // Verifica si existe el archivo del template
        if (!file_exists($templatePath)) {
            throw new NotFoundHttpException('El template no fue encontrado.');
        }

        // Cargar el template
        $spreadsheet = IOFactory::load($templatePath);

        // Obtener la hoja activa
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('E8', ucfirst($model->cliente->alias));
        $sheet->setCellValue('E9', ucfirst($model->solicitor->name));
        $sheet->setCellValue('E10',ucfirst($model->branch->address));
        $sheet->setCellValue('E11', ucfirst($model->branch->name));
        $sheet->setCellValue('L8', ucfirst($model->req->id));
        $sheet->setCellValue('L9', date('d-m-Y'));
        $sheet->setCellValue('L10', ucfirst($model->status->name));
        $sheet->setCellValue('L11', "Fernanda Rozas"); # NUTZ ARREGLAR
		
		$detail = [];
		$palabras = explode(' ', $model->req->inidetail);
		$lineaActual = '';
		foreach ($palabras as $palabra) {
	        // Si agregar la palabra excede la longitud máxima, guardar la línea actual
	        if (strlen($lineaActual . ' ' . $palabra) > 145) {
	            $detail[] = trim($lineaActual);
	            $lineaActual = $palabra; // Iniciar una nueva línea
	        } else {
	            // Agregar la palabra a la línea actual
	            $lineaActual .= ' ' . $palabra;
	        }
	    }
	    if (!empty($lineaActual)) {
	        $detail[] = trim($lineaActual);
	    }
		
		# Descripción del trabajo máx 150 chars por linea:
		$startRow = 15;
		foreach($detail as $i => $linea){
			$currentRow = $startRow + $i;
			if($i == 0){
				$linea = ucfirst($linea);
			}
			$sheet->setCellValue('A'.$currentRow, $linea); # NUTZ ARREGLAR
		}

		# Detalle Cotización
		$startRow = 20;
		$detail = SquoteDetail::find()->where(['idsquote' => $model->id])->asArray()->All();
		foreach($detail as $i => $linea){
			$currentRow = $startRow + ($i*2);
			$sheet->insertNewRowBefore($currentRow);
			$sheet->setCellValue('A'.$currentRow, $i + 1);
			$sheet->mergeCells('B' . $currentRow . ':I' . $currentRow);
			$sheet->setCellValue('B'.$currentRow, $linea['descrip']);
			$sheet->getStyle('B' . $currentRow . ':I' . $currentRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('J'.$currentRow, $linea['unit']);
			$sheet->setCellValue('K'.$currentRow, $linea['quant']);
			$sheet->setCellValue('L'.$currentRow, $linea['cost']);
			$sheet->mergeCells('M' . $currentRow . ':N' . $currentRow);
			$sheet->setCellValue('M'.$currentRow, $linea['total']);
			
			
		}
		
#		$sheet->setCellValue('M36',$model->subtotal);
		
        // Guardar el archivo generado temporalmente
        $tempFile = tempnam(sys_get_temp_dir(), 'ppto-') . $model->id . '.xlsx';
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($tempFile);

        // Enviar el archivo al navegador para descarga
        return Yii::$app->response->sendFile($tempFile, 'presupuesto-' . $model->id . '.xlsx', ['inline' => false])
            ->on(\yii\web\Response::EVENT_AFTER_SEND, function () use ($tempFile) {
                unlink($tempFile); // Eliminar el archivo temporal después de enviarlo
            });
    }
    
    
    /**
     * Finds the Squote model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Squote the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Squote::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
