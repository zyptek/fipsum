<?php

namespace backend\controllers;

use Yii;
use common\models\LoginForm;
use common\models\User;
use backend\models\ChangePasswordForm;
use frontend\models\SignupForm;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['activate', 'change-password'],
                        'allow' => true,
                        'roles' => ['?'],
                        'denyCallback' => function ($rule, $action) {
                            return Yii::$app->response->redirect(['site/index']);
                        },
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
	        
	        # Cargamos la lista de vistas disponibles para el usuario
	        $session = Yii::$app->session;
	        $userModules = \backend\models\Module::find()
                ->select(['name', 'descrip']) // Solo selecciona las columnas necesarias.
                ->innerJoin('user_module', 'module.id = user_module.idmodule') // Une con la tabla intermedia.
                ->where(['user_module.iduser' => Yii::$app->user->id]) // Filtra por el ID del usuario.
                ->asArray() // Retorna los resultados como un array.
                ->all();
                
		    $session->set('userModules',$userModules);
	        $profile = \backend\models\Profile::find()->where(['iduser' => Yii::$app->user->id ])->one();
	        $session->set('userRole',$profile->idrole);
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
    
    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

	public function actionActivate($token, $temp)
	{
		$this->layout = 'blank';
	    $token = urldecode($token); // Decodificar token
	    $temp = urldecode($temp); // Decodificar contraseña temporal cifrada
		
#		$bla = User::find()->where(['password_reset_token' => $token])->one();
#		Yii::info(print_r($bla, true), 'debug');
		
#		Yii::info('Token recibido desde URL: ' . $token, __METHOD__);
#		Yii::info('Contraseña temporal cifrada recibida: ' . $temp, __METHOD__);
	    
	    $user = User::findByTempPasswordResetToken($token);
	
	    if (!$user) {
#	        Yii::error('Token inválido o usuario no encontrado.', __METHOD__);
            Yii::$app->session->setFlash('danger', 'Token inválido.');
#	        throw new \yii\web\NotFoundHttpException('Token inválido.');
            return $this->redirect(['site/login']);
	    }
	
#		Yii::info('Usuario encontrado: ID ' . $user->id, __METHOD__);
		
	    $tempPassword = Yii::$app->security->decryptByKey($temp, Yii::$app->params['encryptionKey']);
 #       Yii::info('Contraseña temporal cifrada recibida2: ' . $tempPassword, __METHOD__);
	    if (!$tempPassword) {
	        Yii::error('Error al desencriptar la contraseña temporal.', __METHOD__);
	        throw new \yii\web\ForbiddenHttpException('Enlace de activación inválido.');
	    }
	
#	    $user->status = User::STATUS_ACTIVE;
#	    $user->removePasswordResetToken(); // Limpiar token
	    if (!$user->save(false)) {
	        Yii::error('Error al activar el usuario.', __METHOD__);
	        throw new \yii\web\ServerErrorHttpException('Error al activar la cuenta.');
	    }
	
	    // Autenticar al usuario y redirigir al cambio de contraseña
#	    Yii::$app->user->login($user);
	    Yii::$app->session->setFlash('info', 'Por favor, cambia tu contraseña temporal.');
	    Yii::debug('Accediendo a common\\models\\User::identity en ' . __FILE__ . ' en la línea ' . __LINE__);
#	    $model = new ChangePasswordForm();
/* 	    return $this->redirect('change-password', [
		    'model' => $model,
	    	'id' => $user->id
	    	]); */
        return $this->runAction('change-password', ['id' => $user->id]);

	}

	
	public function actionChangePassword($id)
	{
		$this->layout = 'blank';
	    $model = new ChangePasswordForm();
#        $userModel = new User();
        $user = User::find()->where(['id' => $id])->one();
        
	    if ($model->load(Yii::$app->request->post()) && $model->validate(false)) {
            if($user->status === User::STATUS_ACTIVE){
                throw new \Exception('El usuario ya ha sido validado!' . json_encode($user->errors));
                return $this->redirect(['site/index']);
            }
#	        $user->id = Yii::$app->request->post('id');

	        $user->setPassword($model->newPassword);
            $user->status = User::STATUS_ACTIVE;
            $user->removePasswordResetToken(); // Limpiar token
	        $user->save(false);
	
	        Yii::$app->session->setFlash('success', 'Su contraseña ha sido creada.');
	        return $this->redirect(['site/index']);
	    }
	
	    return $this->render('change-password', ['model' => $model]);
	}


    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
