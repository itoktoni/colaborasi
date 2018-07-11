<?php

namespace backend\controllers;

use Yii;
use common\models\base\Productcontent;
use yii\data\Pagination;

    use common\models\search\ProductcontentSearch;
        use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;
    use backend\components\AuthController;

    /**
    * ProductContentController implements the CRUD actions for Productcontent model.
    */
    class ProductContentController extends AuthController 
    {

        public function init(){
        $this->view->params['menu'] = 'productcontentcontroller';
        $this->view->params['submenu'] = 'productcontentcontroller';
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
    * Lists all Productcontent models.
    * @return mixed
    */
    public function actionIndex()
    {
        $searchmodel = new \common\models\search\ProductcontentSearch;
        $query = $searchmodel->search(Yii::$app->request->get());
        $data['pages'] = $query->getPagination();
        $data['dataProvider'] = $query->getModels();

        return $this->render('index',$data);
    }

    /**
    * Creates a new Productcontent model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    * @return mixed
    */
    public function actionCreate()
    {
        $model = new Productcontent();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Productcontent Created');
            return $this->redirect(['/productcontent/']);
    }

    return $this->render('create', [
    'model' => $model,
    ]);
}

/**
* Updates an existing Productcontent model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $id
* @return mixed
* @throws NotFoundHttpException if the model cannot be found
*/
public function actionUpdate($id)
{
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        Yii::$app->session->setFlash('success', 'Productcontent Updated');
    return $this->redirect('/productcontent/');
}

return $this->render('update', [
'model' => $model,
]);
}

/**
* Deletes an existing Productcontent model.
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
 Yii::$app->session->setFlash('success', 'Productcontent Deleted');
 return $this->redirect('/productcontent');
}

/**
* Finds the Productcontent model based on its primary key value.
* If the model is not found, a 404 HTTP exception will be thrown.
* @param integer $id
* @return Productcontent the loaded model
* @throws NotFoundHttpException if the model cannot be found
*/
protected function findModel($id)
{
        if (($model = Productcontent::findOne($id)) !== null) {
    return $model;
}

throw new NotFoundHttpException('The requested page does not exist.');
}
}
