<?php

namespace backend\controllers;

use Yii;
use common\models\base\Voucher;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\components\AuthController;

/**
     * VoucherController implements the CRUD actions for Voucher model.
     */
    class VoucherController extends AuthController
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
         *
         * @return mixed
         */
        public function actionIndex()
        {
            $searchmodel = new \common\models\search\VoucherSearch();
            $query = $searchmodel->search(Yii::$app->request->get());
            $data['pages'] = $query->getPagination();
            $data['dataProvider'] = $query->getModels();

            return $this->render('index', $data);
        }

        /**
         * Creates a new Voucher model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         *
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
    ]);
        }

        /**
         * Updates an existing Voucher model.
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
                Yii::$app->session->setFlash('success', 'Voucher Updated');

                return $this->redirect('/voucher/');
            }

            return $this->render('update', [
'model' => $model,
]);
        }

        /**
         * Deletes an existing Voucher model.
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
            Yii::$app->session->setFlash('success', 'Voucher Deleted');

            return $this->redirect('/voucher');
        }

        /**
         * Finds the Voucher model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         *
         * @param int $id
         *
         * @return Voucher the loaded model
         *
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
