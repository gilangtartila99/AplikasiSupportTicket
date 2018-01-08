<?php

namespace app\controllers;

use Yii;
use app\models\Chat;
use app\models\Ticket;
use app\models\TicketSearch;
use app\models\TicketSupportSearch;
use app\models\TicketUserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use yii\helpers\Url;
use kartik\mpdf\Pdf;
use mPDF;

/**
 * TicketController implements the CRUD actions for Ticket model.
 */
class TicketController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'ruleConfig' => [
                    'class' => \app\models\AccessRules::className(),
                ],
                'only' => ['logout','login','index','view','tranfer','downloadfile','closenow'],
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout','login','index','view','tranfer','downloadfile','closenow'],
                        'allow' => true,
                        'roles' => ['1'],
                    ],
                    [
                        'actions' => ['logout','login','index','view','downloadfile','closenow'],
                        'allow' => true,
                        'roles' => ['2'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => [''],
                        'allow' => true,
                        'roles' => ['?','3'],
                    ],      // everything else is denied
                ],
                'denyCallback' => function () {
                    Yii::$app->session->setFlash('danger', 'Maaf anda tidak memiliki akses!');
                    return $this->redirect(['site/logoutsession']);
                },
            ],
        ];
    }

    public function actionCetaklaporan() 
    {
        $searchModel = new TicketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $filename = date('dmYhis').'.pdf';

        $ticket = Ticket::find()->select('MONTHNAME(date) as bulan, date, SUM(jumlah) as jumlah')->groupBy(['bulan'])->orderBy(['bulan' => SORT_DESC])->limit(30);
        $dataProvider2 = new ActiveDataProvider([
            'query' => $ticket,
            'pagination' => false,
        ]);

        $mpdf = new mPDF('utf-8', 'A4');
        $mpdf->SetTitle(date('dmYhis'));
        $mpdf->WriteHTML(
            $this->render('cobachart', [
                'searchModel' => $searchModel, 
                'dataProvider' => $dataProvider, 
                'dataProvider2' => $dataProvider2,
            ]));
        $mpdf->Output($filename, 'I');
    }

    /**
     * Updates an existing Ticket model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionTransfer($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('updatesupport', [
                'model' => $model,
            ]);
        }
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

    /**
     * Lists all Ticket models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->identity->role == 1) {
            $searchModel = new TicketSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } elseif (Yii::$app->user->identity->role == 2) {
            $searchModel = new TicketSupportSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } elseif (Yii::$app->user->identity->role == 3) {
            $searchModel = new TicketUserSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->redirect(['site/logout']);
        }
    }

    /**
     * Displays a single Ticket model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if($model->state = 'Open')  {
            $holdon = $this->findModel($id);
            $holdon->state = 'Hold On';
            $holdon->load(Yii::$app->request->post());
            $holdon->save(false);
        }   

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
            return $this->redirect(['view',
                'id' => $model->id_ticket,
                'model' => $model,
                'models' => $models,
            ]);
        } else {
            return $this->render('view', [
                'id' => $model->id_ticket,
                'chat' => $chat,
                'dataProvider' => $dataProvider,
                'model' => $model,
                'models' => $models,
            ]);
        }
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
}
