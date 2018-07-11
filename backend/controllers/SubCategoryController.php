<?php

namespace backend\controllers;

use Yii;
use common\models\base\Subcategory;
use yii\data\Pagination;

    use common\models\search\SubcategorySearch;
        use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;
    use backend\components\AuthController;

    /**
    * SubCategoryController implements the CRUD actions for Subcategory model.
    */
    class SubCategoryController extends AuthController 
    {

        public function init(){
        $this->view->params['menu'] = 'product';
        $this->view->params['submenu'] = 'sub-category';
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
    * Lists all Subcategory models.
    * @return mixed
    */
    public function actionIndex()
    {
        $searchmodel = new \common\models\search\SubcategorySearch;
        $query = $searchmodel->search(Yii::$app->request->get());
        $data['pages'] = $query->getPagination();
        $data['dataProvider'] = $query->getModels();

        return $this->render('index',$data);
    }

    /**
    * Creates a new Subcategory model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    * @return mixed
    */
    public function actionCreate()
    {
        $model = new Subcategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Subcategory Created');
            return $this->redirect(['/sub-category/']);
    }

    return $this->render('create', [
    'model' => $model,
    ]);
}

/**
* Updates an existing Subcategory model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $id
* @return mixed
* @throws NotFoundHttpException if the model cannot be found
*/
public function actionUpdate($id)
{
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        Yii::$app->session->setFlash('success', 'Subcategory Updated');
    return $this->redirect('/sub-category/');
}

return $this->render('update', [
'model' => $model,
]);
}

/**
* Deletes an existing Subcategory model.
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
 Yii::$app->session->setFlash('success', 'Subcategory Deleted');
 return $this->redirect('/subcategory');
}

/**
* Finds the Subcategory model based on its primary key value.
* If the model is not found, a 404 HTTP exception will be thrown.
* @param integer $id
* @return Subcategory the loaded model
* @throws NotFoundHttpException if the model cannot be found
*/
protected function findModel($id)
{
        if (($model = Subcategory::findOne($id)) !== null) {
    return $model;
}

throw new NotFoundHttpException('The requested page does not exist.');
}
}
