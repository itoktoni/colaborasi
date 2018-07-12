<?php

namespace backend\controllers;

use Yii;
use common\models\base\Category;
use yii\data\Pagination;
use common\models\search\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\components\AuthController;

    /**
    * CategoryController implements the CRUD actions for Category model.
    */
    class CategoryController extends AuthController 
    {

        public function init(){
        $this->view->params['menu'] = 'product';
        $this->view->params['submenu'] = 'category';
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
    * Lists all Category models.
    * @return mixed
    */
    public function actionIndex()
    {
        $searchmodel = new \common\models\search\CategorySearch;
        $query = $searchmodel->search(Yii::$app->request->get());
        $data['pages'] = $query->getPagination();
        $data['dataProvider'] = $query->getModels();

        return $this->render('index',$data);
    }

    /**
    * Creates a new Category model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    * @return mixed
    */
    public function actionCreate()
    {
        $model = new Category();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Category Created');
            return $this->redirect(['/category/']);
    }

    return $this->render('create', [
    'model' => $model,
    ]);
}

/**
* Updates an existing Category model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $id
* @return mixed
* @throws NotFoundHttpException if the model cannot be found
*/
public function actionUpdate($id)
{
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        Yii::$app->session->setFlash('success', 'Category Updated');
    return $this->redirect('/category/');
}

return $this->render('update', [
'model' => $model,
]);
}

/**
* Deletes an existing Category model.
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
 Yii::$app->session->setFlash('success', 'Category Deleted');
 return $this->redirect('/category');
}

/**
* Finds the Category model based on its primary key value.
* If the model is not found, a 404 HTTP exception will be thrown.
* @param integer $id
* @return Category the loaded model
* @throws NotFoundHttpException if the model cannot be found
*/
protected function findModel($id)
{
        if (($model = Category::findOne($id)) !== null) {
    return $model;
}

throw new NotFoundHttpException('The requested page does not exist.');
}
}
