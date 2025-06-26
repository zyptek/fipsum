<?php

namespace backend\controllers;

use Yii;
use backend\models\Alloc;
use backend\models\Docrend;
use backend\models\AllocSearch;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

/**
 * AllocController implements the CRUD actions for Alloc model.
 */
class AllocController extends Controller
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
					'rules' => [
						[
							'actions' => [],//aplica a todas las acciones
							'allow' => true,
							'roles' => ['@'],
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
     * Lists all Alloc models.
     *
     * @return string
     */
    public function actionIndex($idreq = null)
    {
        $searchModel = new AllocSearch();
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
     * Displays a single Alloc model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $idreq = null)
    {
        return $this->render('view', [
	        'idreq' => $idreq,
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Alloc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Alloc();

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

	public function actionNew($idreq = null){
		
		$model = new Alloc();
		
		if ($this->request->isPost) {
			$model->iduser = Yii::$app->user->id;
			
			
			
			# Si existe una entrada en docrend para este requerimiento y usuario se debe sumar la asignación
			# al campo assigned_amount de la tabla Docrend, de lo contrario se debe crear una nueva 
			# entrada en docrend con la asignacion en assigned_amount
			
			// TODO: MOVER ESTA LÓGICA A ACTIONPAID
            if ($model->load($this->request->post()))
            {			
	            if($model->save()){
	                return $this->redirect(['view', 'id' => $model->id, 'idreq' => $idreq]);
	            }
	        }
        } else if ($idreq === null) {
            return $this->redirect(['alloc/index']);
        }
        
        $model->idreq = $idreq;
        
		return $this->render('new', [
			'model' => $model,
		]);
	}
    /**
     * Updates an existing Alloc model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $idreq = null)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
	        'idreq' => $idreq,
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Alloc model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
	    # status pagado = 2
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Alloc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Alloc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
	public function actionPaid($id)
    {

        $model = $this->findModel($id);

        if ($model) {
	        if($model->idstatus != 3){
		        Yii::$app->session->setFlash('error', 'No se puede asignar estado "Pagado".');
		        return false;
	        }
	        $model->idstatus = 4; // Marcar como pagado
	        $docRend = Docrend::find()
					->where(['idreq' => $model->idreq])
					->andWhere(['idsolicitor' => $model->idsolicitor])
					->one();
			
				if(!$docRend){
					$docRend = new Docrend();
					$docRend->idreq = $model->idreq;
					$docRend->idsolicitor = $model->idsolicitor;
					$docRend->assigned_amount = $model->amount;
				}else{
					$docRend->assigned_amount += $model->amount;
				}

	        	        
	        if ($model->save(false) && $docRend->save(false)) { // Guardar sin validación
#	            Yii::$app->session->setFlash('success', 'El registro ha sido desactivado correctamente.');
	            return $this->redirect(['index']);
	        } else {
#	            Yii::$app->session->setFlash('error', 'No se pudo desactivar el registro.');
	            return false;
	        }
	    }
        return $this->redirect(['index']);
    }
    
    public function actionAprove($id){
	    
	    $model = $this->findModel($id);
	    if ($model) {
		    if($model->idstatus < 2){
		    	$status = $model->amount < 100000 ? $model->idstatus + 2 : $model->idstatus + 1;
		    }
	        $model->idstatus = $status; // Marcar como pagado
	        if ($model->save(false)) { // Guardar sin validación
#	            Yii::$app->session->setFlash('success', 'El registro ha sido desactivado correctamente.');
	            return $this->redirect(['index']);
	        } else {
#	            Yii::$app->session->setFlash('error', 'No se pudo desactivar el registro.');
	            return false;
	        }
	    }
        return $this->redirect(['index']);
    }
    
    protected function findModel($id)
    {
        if (($model = Alloc::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
