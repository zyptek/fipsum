<?php

namespace backend\controllers;

use backend\models\Image;
use backend\models\ImageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use Yii;


/**
 * ImageController implements the CRUD actions for Image model.
 */
class ImageController extends Controller
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
     * Lists all Image models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ImageSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Image model.
     * @param string $id ID
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
     * Creates a new Image model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
	    #Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        

		if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {	
        	Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        	$model = new Image();
	        $model->load(Yii::$app->request->post());
	        
	        $path = date('dmY');
	        
			$file = UploadedFile::getInstance($model, 'path');
			if ($file) {
            $fileName = uniqid() . '.' . $file->extension;
            $filePath = Yii::getAlias('@backend/web/uploads/'. $path .'/') . $fileName;

				if (!is_dir(Yii::getAlias('@backend/web/uploads/'. $path .'/'))) {
					mkdir(Yii::getAlias('@backend/web/uploads/'. $path .'/', 0777, true));					
				}
	            if ($file->saveAs($filePath)) {
	                $model->path = $path . '/' . $fileName;
	                $model->name = $file->baseName;
	                $model->active = 1;
	                $relatedId = Yii::$app->request->post('relatedId');
	                $relatedModel = Yii::$app->request->post('relatedModel');
	                if(Yii::$app->request->post('idcat') == 9){
						$model->idcat = Yii::$app->request->post('idcat');
						// TODO: Modificar pquote->selected para pasar a la siguiente etapa
						$pquoteModel = \backend\models\Pquote::find()
							->where(['id' => $relatedId ])
							->one();
						$pquoteModel->selected = 1;
						$pquoteModel->save(false);
					}
	                if ($model->save(false)) {
						if ($relatedId && $relatedModel) {
	                        $imageTable = new \backend\models\ImageTable();
	                        $imageTable->idimage = $model->id; // ID de la imagen guardada
	                        $imageTable->tablename = $relatedModel; // Nombre del modelo relacionado
	                        $imageTable->idtable = $relatedId; // ID del modelo relacionado
	                        
	                        if ($imageTable->save(false)) {
								return ['success' => true, 'message' => 'success.'];
                        	}else{
	                        	return ['error' => true, 'message' => 'No se puede guardar ImageTable.'];
                        	}
	                    }

	                }
	            }
        	}
        	return ['success' => false, 'message' => 'No se pudo guardar la imagen.'];
        }


		$model = new Image();
        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing Image model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
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
     * Deletes an existing Image model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
	    
	    if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {	
        	Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        	$id = \Yii::$app->request->post('id');
		    if ($id) {
		        $image = Image::findOne($id);
		        if ($image && $image->delete()) {
		            return ['success' => true];
		        }
		    }
		    return ['success' => false];
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Image model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return Image the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Image::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
