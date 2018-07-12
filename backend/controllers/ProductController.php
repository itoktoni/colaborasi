<?php

namespace backend\controllers;

use Yii;
use common\models\base\Product;
use yii\data\Pagination;

    use common\models\search\ProductSearch;
        use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;

    /**
    * ProductController implements the CRUD actions for Product model.
    */
    class ProductController extends Controller
    {

        public function init(){
        $this->view->params['menu'] = 'product';
        $this->view->params['submenu'] = 'product';
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
    * Lists all Product models.
    * @return mixed
    */
    public function actionIndex()
    {
        $searchmodel = new \common\models\search\ProductSearch;
        $query = $searchmodel->search(Yii::$app->request->get());
        $data['pages'] = $query->getPagination();
        $data['dataProvider'] = $query->getModels();

        return $this->render('index',$data);
    }

    /**
    * Creates a new Product model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    * @return mixed
    */
    public function actionCreate()
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Product Created');
            return $this->redirect(['/product/']);
    }

    return $this->render('create', [
    'model' => $model,
    ]);
}


/**
* Updates an existing Product model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $id
* @return mixed
* @throws NotFoundHttpException if the model cannot be found
*/
public function actionUpdate($id)
{
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        Yii::$app->session->setFlash('success', 'Product Updated');
    return $this->redirect('/product/');
}

return $this->render('update', [
'model' => $model,
]);
}

/**
* Deletes an existing Product model.
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
 Yii::$app->session->setFlash('success', 'Product Deleted');
 return $this->redirect('/product');
}

/**
* Finds the Product model based on its primary key value.
* If the model is not found, a 404 HTTP exception will be thrown.
* @param integer $id
* @return Product the loaded model
* @throws NotFoundHttpException if the model cannot be found
*/
protected function findModel($id)
{
        if (($model = Product::findOne($id)) !== null) {
    return $model;
}

throw new NotFoundHttpException('The requested page does not exist.');
}
}
