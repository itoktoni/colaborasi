<?php

namespace backend\controllers;

use Yii;
use common\models\base\Brand;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use backend\components\AuthController;

/**
 * BrandController implements the CRUD actions for Brand model.
 */
class BrandController extends AuthController
{
    public function init()
    {
        $this->view->params['menu'] = 'categories';
        $this->view->params['submenu'] = 'brand';
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
     * Lists all Brand models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchmodel = new \common\models\search\BrandSearch();
        $query = $searchmodel->search(Yii::$app->request->get());
        $data['pages'] = $query->getPagination();
        $data['dataProvider'] = $query->getModels();

        return $this->render('index', $data);
    }

    /**
     * Creates a new Brand model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Brand();

        if ($model->load(post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Brand Created');

            return $this->redirect(['/brand/']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Brand model.
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

        if ($model->load(post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Brand Updated');

            return $this->redirect('/brand/');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Brand model.
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
        Yii::$app->session->setFlash('success', 'Brand Deleted');

        return $this->redirect('/brand');
    }

    /**
     * Finds the Brand model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return Brand the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Brand::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
