<?php

namespace backend\controllers;

use Yii;
use common\models\base\Voucher;
use common\models\search\VoucherSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

/**
 * VoucherController implements the CRUD actions for Voucher model.
 */
class VoucherController extends Controller
{
    public function init()
    {
        $this->view->params['menu'] = 'product';
        $this->view->params['submenu'] = 'voucher';
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
     * Lists all Voucher models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchmodel = new \common\models\search\VoucherSearch;
        $query = $searchmodel->search(Yii::$app->request->get());
        $data['pages'] = $query->getPagination();
        $data['dataProvider'] = $query->getModels();

        return $this->render('index', $data);
    }

    /**
     * Displays a single Voucher model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Voucher model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Voucher();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Voucher Created');
            return $this->redirect(['/voucher/']);
        }

        return $this->render('create', [
            'model' => $model,
            'dataProvider' => array(),
        ]);
    }

    /**
     * Updates an existing Voucher model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $query      = Voucher::find()->where(['status' => 1, 'id' => $id]);
        $countQuery = clone $query;
        $pages      = new Pagination(['totalCount' => $countQuery->count()]);
        $models     = $query->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ( empty( $model->discount_prosentase )  ) {
                $model->discount_prosentase = 0;
            }
            if ( empty( $model->discount_price )  ) {
                $model->discount_price = 0;
            }
            $model->save(false);

            Yii::$app->session->setFlash('success', 'Voucher Updated');
            return $this->redirect('/voucher/');
        }

        return $this->render('update', [
            'model' => $model,
            'pages' => $pages,
            'dataProvider' => $models,
        ]);
    }

    /**
     * Deletes an existing Voucher model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = -9;
        $model->save(false);
        Yii::$app->session->setFlash('success', 'Voucher Deleted');
        return $this->redirect('/voucher');
    }

    /**
     * Finds the Voucher model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Voucher the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Voucher::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
