<?php

namespace backend\controllers;

use Yii;
use backend\models\Inftec;
use backend\models\InftecImage;
use backend\models\InftecSearch;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Shared\Html;
#use PhpOffice\PhpWord\Shared\HTMLtoOpenXML;
use DOMDocument;

/**
 * InftecController implements the CRUD actions for Inftec model.
 */
class InformeTecController extends Controller
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
	public function actions()
	{
	    return [
	        'images-get' => [
	            'class' => 'vova07\imperavi\actions\GetImagesAction',
	            'url' => 'https://sc.fipsum.cl/uploads/', // Directory URL address, where files are stored.
	            'path' => '@backend/web/uploads/', // Or absolute path to directory where files are stored.
	            'options' => ['only' => ['*.jpg', '*.jpeg', '*.png']], // These options are by default.
	        ],
	    ];
	}
    /**
     * Lists all Inftec models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new InftecSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Inftec model.
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
     * Creates a new Inftec model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Inftec();

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
     * Updates an existing Inftec model.
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
     * Deletes an existing Inftec model.
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
	    if($idreq == null){
			return $this->redirect(['index']);
		}
		
		$model = Inftec::find()->where(['idreq' => $idreq])->one();
		if(!$model && isset($idreq)){
			$model = new Inftec();
			$model->idreq = $idreq;
		}		
		$go = false;
		$bla = isset(Yii::$app->request->post('Inftec')['detalle']) ? Yii::$app->request->post('Inftec')['detalle'] : "bla";

		if ($model->load(Yii::$app->request->post())) {
			
			$model->detalle = HtmlPurifier::process(Yii::$app->request->post('Inftec')['detalle']);
			if ($model->save(false)) {
                
				$go = true;
            }
            $images = Yii::$app->request->post('images', []);
            if (!empty($images)) {

				InftecImage::deleteAll(['idit' => $model->id]);
				
				$rowsInserted = Yii::$app->db->createCommand()->batchInsert(
				    'inftec_image', // tabla
				    ['idit', 'idimage'], // Columnas
				    array_map(fn($idimage) => [$model->id, $idimage], $images) // Valores a insertar
				)->execute();
				
				if($rowsInserted > 0 && $go){
					return $this->redirect(['export', 'id' => $model->id]);					
				}
			}
			return $this->redirect(['export', 'id' => $model->id]);
        }
		$images = InftecImage::find()->select('idimage')->where(['idit' => $model->id])->asArray()->column();
        return $this->render('new', [
	        'images' => $images,
	        'idreq' => $idreq,
            'model' => $model,
        ]);
		
    }

	public function actionExport($id)
	{
	    $model = $this->findModel($id);

	    // Ruta de la plantilla
	    $templatePath = Yii::getAlias('@backend/templates/template-it.docx');
	
	    if (!file_exists($templatePath)) {
	        throw new \yii\web\NotFoundHttpException('El template no fue encontrado.');
	    }
	
#	\PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(false);
		$templateProcessor = new TemplateProcessor($templatePath);

	    // Paso 2: Obtener el contenido HTML de TinyMCE (de tu modelo)
        $model = Inftec::findOne($id);  // Obtén el modelo por su ID
        $htmlContent = $model->detalle; // Asumiendo que 'detalle' contiene el HTML

        // Convertir HTML a OpenXML (formato que puede usar PhpWord)
        $htmlToOpenXml = new HTMLtoOpenXML();
        $xmlContent = $htmlToOpenXml->convert($htmlContent);

        // Paso 3: Insertar el contenido convertido en la plantilla
        $templateProcessor->setValue('contenido', $xmlContent); // Asumiendo que la etiqueta en el template es 'contenido'

        // Crear archivo temporal y guardarlo
        $tempFile = tempnam(sys_get_temp_dir(), 'informe') . '.docx';
        $templateProcessor->saveAs($tempFile);

        // Paso 4: Descargar el archivo generado
        return Yii::$app->response->sendFile($tempFile, 'informe-' . $model->id . '.docx', ['inline' => false])
            ->on(Response::EVENT_AFTER_SEND, function () use ($tempFile) {
                // Eliminar el archivo temporal después de la descarga
                unlink($tempFile);
            });	    
	}
	
    /**
     * Finds the Inftec model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Inftec the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Inftec::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionExportx($id)
	{
$model = $this->findModel($id);

    $postFields = [
        'html' => $model->detalle,
        'fecha' => date('d/m/Y'),
    ];

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'http://localhost:3001/generate-docx',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postFields,
    ]);

    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        throw new \yii\web\ServerErrorHttpException('Error al generar el documento: ' . curl_error($curl));
    }

    curl_close($curl);

    Yii::$app->response->sendContentAsFile($response, 'documento.docx', [
        'mimeType' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'inline' => false
    ]);
	}
}
