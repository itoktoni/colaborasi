<?php

namespace backend\controllers;

use backend\components\AuthController;
use common\models\base\Productcategory;
use common\models\search\ProductcategorySearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ProductCategoryController implements the CRUD actions for Productcategory model.
 */
class ProductCategoryController extends AuthController
{

    public function init()
    {
        $this->view->params['menu'] = 'productcategorycontroller';
        $this->view->params['submenu'] = 'productcategorycontroller';
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
     * Lists all Productcategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchmodel = new \common\models\search\ProductcategorySearch;
        $query = $searchmodel->search(Yii::$app->request->get());
        $data['pages'] = $query->getPagination();
        $data['dataProvider'] = $query->getModels();

        return $this->render('index', $data);
    }

    /**
     * Creates a new Productcategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Productcategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Productcategory Created');
            return $this->redirect(['/productcategory/']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

/**
 * Updates an existing Productcategory model.
 * If update is successful, the browser will be redirected to the 'view' page.
 * @param integer $id
 * @return mixed
 * @throws NotFoundHttpException if the model cannot be found
 */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Productcategory Updated');
            return $this->redirect('/productcategory/');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

/**
 * Deletes an existing Productcategory model.
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
        Yii::$app->session->setFlash('success', 'Productcategory Deleted');
        return $this->redirect('/productcategory');
    }

/**
 * Finds the Productcategory model based on its primary key value.
 * If the model is not found, a 404 HTTP exception will be thrown.
 * @param integer $id
 * @return Productcategory the loaded model
 * @throws NotFoundHttpException if the model cannot be found
 */
    protected function findModel($id)
    {
        if (($model = Productcategory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
