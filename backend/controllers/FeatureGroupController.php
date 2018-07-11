<?php

namespace backend\controllers;

use Yii;
use backend\models\base\FeatureGroup;
use yii\data\Pagination;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\components\AuthController;

    /**
    * FeatureGroupController implements the CRUD actions for FeatureGroup model.
    */
    class FeatureGroupController extends AuthController 
    {

        public function init(){
            $this->view->params['menu']     = 'setting';
            $this->view->params['submenu']  = 'feature-group';
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
    * Lists all FeatureGroup models.
    * @return mixed
    */
    public function actionIndex()
    {
        $searchmodel = new \backend\models\search\FeatureGroupSearch;
        $query = $searchmodel->search(Yii::$app->request->get());
        $data['pages'] = $query->getPagination();
        $data['dataProvider'] = $query->getModels();

        return $this->render('index',$data);
    }

    /**
    * Creates a new FeatureGroup model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    * @return mixed
    */
    public function actionCreate()
    {
        $model = new FeatureGroup();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'FeatureGroup Created');
            return $this->redirect(['/feature-group/']);
    }

    return $this->render('create', [
    'model' => $model,
    ]);
}

/**
* Updates an existing FeatureGroup model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $id
* @return mixed
* @throws NotFoundHttpException if the model cannot be found
*/
public function actionUpdate($id)
{
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        Yii::$app->session->setFlash('success', 'FeatureGroup Updated');
    return $this->redirect('/feature-group/');
}

return $this->render('update', [
'model' => $model,
]);
}

/**
* Deletes an existing FeatureGroup model.
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
 Yii::$app->session->setFlash('success', 'FeatureGroup Deleted');
 return $this->redirect('/feature-group/');
}

/**
* Finds the FeatureGroup model based on its primary key value.
* If the model is not found, a 404 HTTP exception will be thrown.
* @param integer $id
* @return FeatureGroup the loaded model
* @throws NotFoundHttpException if the model cannot be found
*/
protected function findModel($id)
{
        if (($model = FeatureGroup::findOne($id)) !== null) {
    return $model;
}

throw new NotFoundHttpException('The requested page does not exist.');
}
}
