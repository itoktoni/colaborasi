<?php

namespace backend\controllers;

use common\models\base\Payments;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use backend\components\AuthController;

/**
 * PaymentController implements the CRUD actions for Payments model.
 */
class PaymentController extends AuthController
{
    public function init()
    {
        $this->view->params['menu'] = 'report';
        $this->view->params['submenu'] = 'payment';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all Payments models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $data = [];

        $searchmodel = new \common\models\base\PaymentSearch();
        $query = $searchmodel->search(Yii::$app->request->get());
        $data['pages'] = $query->getPagination();
        $data['dataProvider'] = $query;
        $chartdata = new \common\models\base\PaymentSearch();
        $data['chartdata'] = $chartdata->getchart(Yii::$app->request->get());
        $productdata = new \common\models\search\DownloadSearch();
        $data['productchart'] = $productdata->getchart(Yii::$app->request->get());
        // $data['brandchart'] = $chartdata->getchart(Yii::$app->request->get());
        // $data['chartdata'] = \common\models\Payment::find()->select(['COUNT(*) counter'])->where(['created_at' => $date[0]])->groupBy(['date(created_at)'])->all();

        return $this->render('index', $data);
    }

    /**
     * Creates a new Payments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Payments();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Payments Created');

            return $this->redirect(['/payments/']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Payments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Payments Updated');

            return $this->redirect('/payments/');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Payments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = -9;
        $model->save(false);
        Yii::$app->session->setFlash('success', 'Payments Deleted');

        return $this->redirect('/payments');
    }

    /**
     * Finds the Payments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return Payments the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payments::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
