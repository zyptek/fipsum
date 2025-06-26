<?php

namespace backend\controllers;

use Yii;
use backend\models\Docrend;
use backend\models\DocrendSearch;
use backend\models\Drdetail;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

/**
 * DocrendController implements the CRUD actions for Docrend model.
 */
class DocrendController extends Controller
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
     * Lists all Docrend models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DocrendSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Docrend model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
	    if ($this->request->isPost) {
			$data = $this->request->post();
			# Buscamos Docrend asociado
			$model = $this->findModel($id);
			$model->detail_count = count($data['valor']);
			$model->expended_amount = $data['grand-total'];
			$model->difference = $data['resultado'];
			$model->total = $data['grand-total'];
			$model->idsolicitor = Yii::$app->user->id;
			$model->qty_boletas = $data['cant-boletas'];
			$model->qty_peajes = $data['cant-peajes'];
			$model->qty_facturas = $data['cant-facturas'];
			$model->qty_nc = $data['cant-nc'];
			$model->tot_boletas = $data['total-boletas'];
			$model->tot_facturas = $data['total-facturas'];
			$model->tot_nc = $data['total-nc'];
			$model->tot_peajes = $data['total-peajes'];

			$model->save(false);
			Drdetail::deleteAll(['iddocrend' => $model->id]);
			foreach ($data['valor'] as $index => $item) {
				$detail = new Drdetail();
				$detail->iddocrend = $model->id;
				$detail->idtoe = $data['toe'][$index] ?? null;
				$detail->date = $data['fecha'][$index] ?? null;
				$detail->name = $data['detalle'][$index] ?? null;
				$detail->company = $data['proveedor'][$index] ?? null;
				$detail->amount = $data['valor'][$index] ?? null;
				$detail->doc_no = $data['no_doc'][$index] ?? null;
				
				$count = Drdetail::find()->where(['iddocrend' => $model->id])->count();
				
				if ($count < $model->detail_count && !$detail->save(false)) {
		                    // Manejo de errores si no se puede guardar
		                    Yii::$app->session->setFlash('error', 'Error al guardar el detalle en la fila: ' . $index);
		                    return $this->redirect(['docrend/new']);
		        }
			}
			Yii::$app->session->setFlash('success', 'Todos los ítems se han guardado correctamente.');			
		}
		
		$details = Drdetail::find()->where(['iddocrend' => $id])->all();
        return $this->render('view', [
	        'details' => $details,
            'model' => $this->findModel($id),
        ]);
    }

    public function actionExportDr($id)
    {
        $model = $this->findModel($id); // Busca el modelo por ID
		$details = Drdetail::find()->where(['iddocrend' => $id])->all();
		
        // Ruta del template
        $templatePath = Yii::getAlias('@backend/templates/template-dr.xlsx');

        // Verifica si existe el archivo del template
        if (!file_exists($templatePath)) {
            throw new NotFoundHttpException('El template no fue encontrado.');
        }

        // Cargar el template
        $spreadsheet = IOFactory::load($templatePath);

        // Obtener la hoja activa
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('I2', $model->idreq);
        $sheet->setCellValue('G5', $model->assigned_amount);
        $sheet->setCellValue('G6', $model->expended_amount);
        $sheet->setCellValue('D6', $model->solicitorProfile->name . " " . $model->solicitorProfile->lastname); 

		$startRow = 9;
		foreach($details as $i => $item){
			$currentRow = $startRow + $i;
			$sheet->setCellValue('B'.$currentRow, $i+1);
			$sheet->setCellValue('C'.$currentRow, $item->date);
			$sheet->setCellValue('D'.$currentRow, $item->name);
			$sheet->setCellValue('E'.$currentRow, $item->company);
			switch ($item->idtoe) {
			    case 1: # Boleta
			        $column = "F";
			        break;
			    case 2: # Peaje
			        $column = "G";
			        break;
			    case 3: # Factura
			        $column = "H";
			        break;
			    case 4: # NC
			        $column = "I";
			        break;
			}
			$sheet->setCellValue($column.$currentRow, $item->doc_no);
			$sheet->setCellValue('J'.$currentRow, $item->amount);
		}
	

		
#		$sheet->setCellValue('M36',$model->subtotal);
		
        // Guardar el archivo generado temporalmente
        $tempFile = tempnam(sys_get_temp_dir(), 'dr-') . $model->id . '.xlsx';
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($tempFile);

        // Enviar el archivo al navegador para descarga
        return Yii::$app->response->sendFile($tempFile, 'DR-' . $model->idreq . '-' . $model->solicitorProfile->alias.'.xlsx', ['inline' => false])
            ->on(\yii\web\Response::EVENT_AFTER_SEND, function () use ($tempFile) {
                unlink($tempFile); // Eliminar el archivo temporal después de enviarlo
            });
    }
    /**
     * Creates a new Docrend model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Docrend();

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
     * Updates an existing Docrend model.
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
     * Deletes an existing Docrend model.
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

	public function actionNew($idreq = null)
    {

	    $model = Docrend::find()->where(['idreq' => $idreq ])->one();
	    if(!$model) $model = new Docrend();
	    
#	    $drDetail = new Drdetail();
	    $toe = \backend\models\Toe::find()->all();

#	    $bla = $this->findModel($reqid);
	    
        return $this->render('new', [
	        'toe' => $toe,
            'model' => $model,
        ]);
    }
    /**
     * Finds the Docrend model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Docrend the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Docrend::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
