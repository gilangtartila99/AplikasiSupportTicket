<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Users;
use app\models\Chat;
use app\models\Ticket;
use app\models\TicketSearch;
use app\models\TicketSupportSearch;
use app\models\TicketUserSearch;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use yii\helpers\Url;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'ruleConfig' => [
                    'class' => \app\models\AccessRules::className(),
                ],
                'only' => ['logout','logoutsession','login','index','viewuser','createuser','updateuser','viewticket','ticket','downloadfile','closenow', 'createticket','home'],
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout','logoutsession','login','index','viewuser','createuser','updateuser','viewticket','ticket','downloadfile','closenow', 'createticket','home'],
                        'allow' => true,
                        'roles' => ['1'],
                    ],
                    [
                        'actions' => ['logout','logoutsession','login','index','viewuser','updateuser','viewticket','downloadfile','closenow','home'],
                        'allow' => true,
                        'roles' => ['2'],
                    ],
                    [
                        'actions' => ['logout','logoutsession','login','index','viewuser','updateuser','viewticket','downloadfile','ticket','home','createticket'],
                        'allow' => true,
                        'roles' => ['3'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['home','login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],      // everything else is denied
                ],
                'denyCallback' => function () {
                    Yii::$app->session->setFlash('danger', 'Maaf anda tidak memiliki akses!');
                    return $this->redirect(['site/logoutsession']);
                },
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
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
     * Logout action.
     *
     * @return string
     */
    public function actionLogoutsession()
    {
        Yii::$app->user->logout();
        Yii::$app->session->setFlash('danger', 'Maaf anda tidak memiliki akses!');
        return $this->render('home');
    }

    public function actionHome() {
        return $this->render('home');
    }

    /**
     * Creates a new Ticket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateticket()
    {
        $model = new Ticket();
        $model->date = date('Y-m-d');
        $model->jumlah = 1;
        $model->id_ticket = date('dmYhis');
        $model->user_id = Yii::$app->user->identity->id;
        $model->state = 'Open';

        $tmpattachment = $model->attachment;

        if ($model->load(Yii::$app->request->post())) {

            $model->attachment = UploadedFile::getInstance($model, 'attachment');
            
            if(!$model->attachment==NULL){
                //save file
                $unik = $model->id_ticket;
                $namafile = $model->attachment->baseName.$unik;
                $extensi = $model->attachment->extension;
            
                $model->attachment->saveAs(Url::to('attachment/') .$namafile.'.'.$extensi);
                $model->attachment = $namafile.'.'.$extensi;
            } else {
                Yii::$app->session->setFlash('danger', 'Masih ada kesalahan!');
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
            
            if($model->save()) {
                return $this->redirect(['viewticket', 'id' => $model->id_ticket]);
            } else {
                Yii::$app->session->setFlash('danger', 'Masih ada kesalahan!');
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
            //return $this->redirect(['viewuser', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Ticket model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionClosenow($id)
    {
        $model = $this->findModel($id);
        $model->state = 'Close';

        $model->load(Yii::$app->request->post());
        $model->save();
        
        return $this->redirect(['index']);
    }

    public function actionDownloadfile($id) 
    { 
        $download = Ticket::findOne($id); 
        $path = 'attachment/'.$download->attachment;

        if (file_exists($path)) {
            return Yii::$app->response->sendFile($path);
        } else {
            return 'File tidak ditemukan!';
        }
    }

    public function actionTicket() {
        $searchModel = new TicketUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('ticket', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ticket model.
     * @param string $id
     * @return mixed
     */
    public function actionViewticket($id)
    {
        $model = $this->findModel($id);

        $models = new Chat();
        $models->id_chat = date('dmYhisY');
        $models->waktu = date('d-m-Y h:i');
        $models->ticket_id = $model->id_ticket;
        $models->nama = Yii::$app->user->identity->nama_partner;

        $chat = Chat::find()->where(['ticket_id' => $model->id_ticket])->orderBy(['waktu' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $chat,
        ]);

        if ($models->load(Yii::$app->request->post()) && $models->save(false)) {
            return $this->redirect(['viewticket',
                'id' => $model->id_ticket,
                'model' => $model,
                'models' => $models,
            ]);
        } else {
            return $this->render('viewticket', [
                'chat' => $chat,
                'dataProvider' => $dataProvider,
                'model' => $model,
                'models' => $models,
            ]);
        }
    }

    /**
     * Displays a single Users model.
     * @param string $id
     * @return mixed
     */
    public function actionViewuser($id)
    {
        return $this->render('viewuser', [
            'model' => $this->findModeluser($id),
        ]);
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdateuser($id)
    {
        $model = $this->findModeluser($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['viewuser', 'id' => $model->id]);
        } else {
            return $this->render('updateuser', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateuser()
    {
        $model = new Users();
        $model->id = date('Ymdhis');
        $model->authKey = Yii::$app->security->generateRandomString();
        $model->accessToken = Yii::$app->security->generateRandomString();
        $model->role = 3;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['viewuser', 'id' => $model->id]);
        } else {
            return $this->render('createuser', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if(Yii::$app->user->identity->role == 1) {
            $ticket = Ticket::find()->select('MONTHNAME(date) as bulan, date, SUM(jumlah) as jumlah')->groupBy(['bulan'])->orderBy(['bulan' => SORT_DESC])->limit(30);
            $dataProvider = new ActiveDataProvider([
                'query' => $ticket,
                'pagination' => false,
            ]);

            return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);
        } elseif(Yii::$app->user->identity->role == 2) {
            $ticket = Ticket::find()->select('MONTHNAME(date) as bulan, date, SUM(jumlah) as jumlah')->where(['support_id' => Yii::$app->user->identity->id])->groupBy(['DATE_FORMAT(date, "%m-%Y")'])->groupBy(['bulan'])->orderBy(['bulan' => SORT_DESC])->limit(30);
            $dataProvider = new ActiveDataProvider([
                'query' => $ticket,
                'pagination' => false,
            ]);

            return $this->render('indexsupport', [
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->render('indexuser');
        }

        //return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //return $this->goBack();
            return $this->redirect(['index']);
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Finds the Ticket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Ticket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ticket::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the Ticket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Ticket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModeluser($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
