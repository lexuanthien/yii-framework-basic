<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EntryForm;
use app\models\Country;
use app\models\Task;
use app\models\Member;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
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
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
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
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = 'login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
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

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSay($message = 'Hello')
    {
        return $this->render('say', ['message' => $message]);
    }
    public function actionEntry()
    {
        $model = new EntryForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // $request = Yii::$app->request;
            // $name = $request->post('EntryForm')['name'];
            // print_r($name);
            // die;

            // print_r(Yii::$app->request->post()['EntryForm']['name']);
            // $data = \Yii::$app->request->post('EntryForm', []);
            // print_r($data['name']);
            // die;
            // do something meaningful here about $model ...
            return $this->render('entry-confirm', ['model' => $model]);
        } else {
            // Chi lay duoc gia tri query
            // $request = Yii::$app->request;
            // $get = $request->get('id');
            // print_r($get);
            // die;

            // SESSION
            // $session = Yii::$app->session;
            // $session['language'] = 'en-US'; TẠO
            // unset($session['language']); XÓA
            // if ($session->has('language')) { KIỂM TRA 
                // print_r($session['language']); LẤY RA SESSION
            // } else {
            //     print_r('ok');
            // }
            
            // Query
            // Insert
            // Yii::$app->db->createCommand()->insert('country', [
            //     'code' => 'OK',
            //     'name' => 'OK La La',
            //     'population' => 1998
            // ])->execute();

            // Update 
            // C1
            // $a = Yii::$app->db->createCommand('UPDATE country SET name="Xin Chào Việt Nam" WHERE code="VI"')->execute();
            // C2
            // Yii::$app->db->createCommand()->update('country', [
            //     'name' => 'Succsess',
            //     'population' => 1999
            // ], 'code = "OK"')->execute();

            // DELETE
            // Yii::$app->db->createCommand()->delete('country', 'code = "HI"')->execute();

            // TAO HOẶC CẬP NHẬT
            // Yii::$app->db->createCommand()->upsert('country', [
            //     'name' => 'Cam Pu Chia',
            //     'population' => '202020202',
            //     'code' => 'CC',
            // ], [
            //     'population' => '112',
            // ])->execute();

            // Lay all ban ghi
            // $country = Yii::$app->db->createCommand('SELECT * FROM country')->queryAll();

            // Lay ban ghi co code=AU
            // $countryAU = Yii::$app->db->createCommand('SELECT * FROM country WHERE code = "AU"')->queryOne();
            
            // Lay du lieu cot name
            // $titles = Yii::$app->db->createCommand('SELECT name FROM country')->queryColumn();

            // So ban ghi trong bang
            // $count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM country')->queryScalar();
            
            // Gan dieu kien
            // $post = Yii::$app->db->createCommand('SELECT * FROM country WHERE code=:code AND population=:population')
            // ->bindValue(':code', $_GET['code'] ?? 'VI')
            // ->bindValue(':population', 84)
            // ->queryOne();
            
            // $country = (new \yii\db\Query())
            // ->select(['code', 'name'])
            // ->from('country')
            // ->all();

            // $task = Task::findOne(1);
            // $member = Member::findOne(1);
            // // $task = Task::find()->one();
            
            // $taskOfMember = $member->getTasks()
            // ->where(['id' => 2])
            // ->all();

            // $users = Member::find()
            // ->leftJoin('tasks', '`tasks`.`user_id` = `members`.`id`')
            // ->with('tasks')
            // ->asArray()
            // ->all();

            // $users = Member::find()->joinWith('tasks')->all();

            // $users = Member::find()->joinWith([
            //     'tasks' => function ($query) {
            //         $query->andWhere(['=', 'tasks.id', 1]);
            //     },
            // ])->all();

            // print_r(Yii::$app->homeUrl);
            // die;
            return $this->render('entry', ['model' => $model]);
        }
    }
}
