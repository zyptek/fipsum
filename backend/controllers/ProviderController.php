<?php

namespace backend\controllers;

use Yii;
use backend\models\Provider;
use backend\models\ProviderSearch;
use backend\models\ProviderRegion;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ProviderController implements the CRUD actions for Provider model.
 */
class ProviderController extends Controller
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
     * Lists all Provider models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProviderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Provider model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $selectedList = \backend\models\ProviderRegion::find()->select('idregion')->where(['idprovider' => $id])->asArray()->all(); 
        return $this->render('view', [
            'selectedList' => $selectedList,
            'regionList' => \backend\models\Region::find()->where(['idcountry' => 40])->all(),
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Provider model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Provider();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save(false)) {
                $regions = Yii::$app->request->post('regions', []);
                foreach ($regions as $regionId) {
                    $providerRegion = new ProviderRegion(); // Modelo de la tabla unión
                    $providerRegion->idprovider = $model->id; // ID del proveedor recién guardado
                    $providerRegion->idregion = $regionId; // ID de la región seleccionada
                    if (!$providerRegion->save(false)) {
                        // Maneja errores si es necesario
                        Yii::$app->session->setFlash('error', 'Error al guardar una región.');
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

#        $regionList = \backend\models\Region::find()->where(['idcountry' => 40])->all();
        return $this->render('create', [
            'selectedList' => [],
            'regionList' => \backend\models\Region::find()->where(['idcountry' => 40])->all(),
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Provider model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save(false)) {
            $regions = Yii::$app->request->post('regions', []);
            foreach ($regions as $regionId) {
                $providerRegion = new ProviderRegion(); // Modelo de la tabla unión
                $providerRegion->idprovider = $model->id; // ID del proveedor recién guardado
                $providerRegion->idregion = $regionId; // ID de la región seleccionada
                if (!$providerRegion->save(false)) {
                    // Maneja errores si es necesario
                    Yii::$app->session->setFlash('error', 'Error al guardar una región.');
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $selectedList = \backend\models\ProviderRegion::find()->select('idregion')->where(['idprovider' => $id])->asArray()->all();
        return $this->render('update', [
            'selectedList' => $selectedList,
            'regionList' => \backend\models\Region::find()->where(['idcountry' => 40])->all(),
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Provider model.
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
     * Finds the Provider model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Provider the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Provider::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
