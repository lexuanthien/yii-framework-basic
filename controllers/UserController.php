<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UserCustomer;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex() {
        if (!Yii::$app->user->isGuest) {
            return $this->goBack();
        } else {
            return $this->redirect(Yii::$app->homeUrl . 'user/login');
        }
    }

    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goBack();
        } else {
            $this->layout = 'login';

            $model = new UserCustomer();
            $model->scenario = UserCustomer::SCENARIO_LOGIN;
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $this->goBack();
            }

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionRegister() {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(Yii::$app->homeUrl);
        } else {
            $this->layout = 'login';

            $model = new UserCustomer();
            $model->scenario = UserCustomer::SCENARIO_REGISTER;
            
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                // $model->addError('username', 'Test lỗi thôi mà');
                // $model->addError('username', 'Test lỗi thôi mà 2');
                // $model->addError('email', 'Test lỗi email');
                print_r($model->safeAttributes());
                die;
                
                $request = Yii::$app->request;
                $user = $request->post('UserCustomer');
                $model->username = $user['username'];
                $model->email = $user['email'];
                $model->password = Yii::$app->getSecurity()->generatePasswordHash($user['password']);
                $model->save();

                $session = Yii::$app->session;
                $session->setFlash('alerts', 'Register Account Succsessfully !');

                return $this->redirect(Yii::$app->homeUrl . 'user/login');
            }
            return $this->render('register', [
                'model' => $model,
            ]);
        }
    }
}
