<?php

namespace backend\controllers;

use Yii;
use backend\models\Profile;
use backend\models\ProfileSearch;
use backend\models\NewUserForm;
use backend\models\Module;
use backend\models\UserModule;
use common\models\User;
use yii\widgets\ActiveForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class ProfileController extends Controller
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
     * Lists all Profile models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProfileSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->query
            ->andWhere(['not', ['idrole' => 20]]);# No mostrar admins
/*             ->andWhere(['or',
                ['<', 'my_column', 10],
                ['>', 'my_column', 20]
        ]); */

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Profile model.
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
     * Creates a new Profile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Profile();

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
     * Updates an existing Profile model.
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
     * Deletes an existing Profile model.
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
	 * Permite crear un nuevo usuario enviando un correo
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
	public function actionNew()
    {	
	    Yii::$app->session->removeFlash('error');
	    Yii::$app->session->removeFlash('success');
        $model = new NewUserForm(); // Modelo del formulario para el e-mail
        $profile = new Profile();
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate(false)) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                // Crear el usuario
                $user = new User();
                $user->email = $model->email;
                $user->status = User::STATUS_INACTIVE; // Usuario inactivo hasta validación
                $user->created_at = time();
                $user->updated_at = time();
                // Generar contraseña temporal
		        $tempPassword = "hola1234"; #Yii::$app->security->generateRandomString(12); // Contraseña temporal segura
		        $user->setPassword($tempPassword); // Guardar la contraseña temporal
		        $user->generateAuthKey();
		        $user->generatePasswordResetToken();

                if (!$user->save()) {
                    Yii::$app->session->setFlash('danger', 'Error al crear el usuario.');
                    throw new \Exception('Error al guardar el usuario: ' . json_encode($user->errors));
                }
                
                $profile->iduser = $user->id;
				$profile->idrole = $model->idrole;
				
				if (!$profile->save()) {
                    Yii::$app->session->setFlash('danger', 'Error al crear el perfil.');
                    throw new \Exception('Error al crear el perfil: ' . json_encode($user->errors));
                }

                // Enviar correo para validación con contraseña temporal
		        $activationLink = Yii::$app->urlManager->createAbsoluteUrl([
		            'site/activate',
		            'token' => urlencode($user->password_reset_token), // Codificar el token
		            'temp' => urlencode(Yii::$app->security->encryptByKey($tempPassword, Yii::$app->params['encryptionKey']))
#					'temp' => $tempPassword,
		        ]);
		        
/*
		        $sent = Yii::$app
		            ->mailer
		            ->compose(
		                ['html' => 'userVerification-html', 'text' => 'userVerification-text'],
		                ['user' => $user, 'activationLink' => $activationLink]
		            )
		            ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name])
		            ->setTo($user->email)
		            ->setSubject('Valide su cuenta y active su contraseña.')
		            ->send();
*/
		            
/*
                if (!$sent) {
                    Yii::$app->session->setFlash('danger', 'Error al enviar el e-mail de validación.');
                    throw new \Exception('Error al enviar el correo de validación.');
                }
*/

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Se ha enviado un correo de validación al nuevo usuario.');
                return $this->redirect(['index']);
                
            } catch (\Exception $e) {
#	            Yii::error('Error al enviar correo: ' . $e->getMessage());
#				throw $e;
                $transaction->rollBack();
                Yii::$app->session->setFlash('danger', $e->getMessage());
            }
        }

        return $this->render('new', [
            'model' => $model,
        ]);
    }
    
    public function actionUpdatePermissions($id)
    {
        $user = User::findOne($id);
        if (!$user) {
            throw new \yii\web\NotFoundHttpException('El usuario no existe.');
        }

        if (Yii::$app->request->isPost) {
            $permissions = Yii::$app->request->post('permissions', []);
            UserModule::updateUserPermissions($id, $permissions);

            Yii::$app->session->setFlash('success', 'Permisos actualizados correctamente.');
            return $this->redirect(['profile/view', 'id' => $id]);
        }

        Yii::$app->session->setFlash('error', 'Error al actualizar los permisos.');
        return $this->redirect(['profile/view', 'id' => $id]);
    }
    public function actionAccess($id)
    {
        // Buscar el usuario por su ID
        $user = User::findOne($id);
        if (!$user) {
            throw new \yii\web\NotFoundHttpException('Usuario no encontrado.');
        }
        $profile = Profile::find()->where(['iduser' => $id])->one();
        // Obtener todos los módulos
        $modules = Module::find()->asArray()->all();

        // Obtener permisos actuales del usuario
        $userModules = UserModule::find()
            ->where(['iduser' => $id])
            ->indexBy('idmodule')
            ->asArray()
            ->all();

        // Procesar el formulario si se envió
        if (Yii::$app->request->isPost) {
            $permissions = Yii::$app->request->post('permissions', []);
            UserModule::updateUserPermissions($id, $permissions);

            // Mensaje de éxito
            Yii::$app->session->setFlash('success', 'Permisos actualizados correctamente.');

            // Recargar permisos actualizados
            $userModules = UserModule::find()
                ->where(['iduser' => $id])
                ->indexBy('idmodule')
                ->asArray()
                ->all();
        }

        // Renderizar la vista
        return $this->render('access', [
            'user' => $user,
            'modules' => $modules,
            'userModules' => $userModules,
            'profile' => $profile,
        ]);
    }

    
    /**
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profile::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
