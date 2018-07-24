<?php

namespace backend\controllers;

use Yii;
use common\models\base\MemberDownload;
use yii\data\Pagination;

    use common\models\search\DownloadSearch;
        use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;

    /**
    * DownloadController implements the CRUD actions for MemberDownload model.
    */
    class DownloadController extends Controller
    {

        public function init(){
        $this->view->params['menu'] = 'report';
        $this->view->params['submenu'] = 'download';
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
    * Lists all MemberDownload models.
    * @return mixed
    */
    public function actionIndex()
    {
        $searchmodel = new \common\models\search\DownloadSearch;
        $query = $searchmodel->search(Yii::$app->request->get());
        $data['pages'] = $query->getPagination();
        $data['dataProvider'] = $query;
        $chartdata = new \common\models\search\DownloadSearch;
        $data['chartdata'] = $chartdata->getchart(Yii::$app->request->get());

        return $this->render('index',$data);
    }

    /**
    * Creates a new MemberDownload model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    * @return mixed
    */
    public function actionCreate()
    {
        $model = new MemberDownload();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'MemberDownload Created');
            return $this->redirect(['/memberdownload/']);
    }

    return $this->render('create', [
    'model' => $model,
    ]);
}

/**
* Updates an existing MemberDownload model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $id
* @return mixed
* @throws NotFoundHttpException if the model cannot be found
*/
public function actionUpdate($id)
{
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        Yii::$app->session->setFlash('success', 'MemberDownload Updated');
    return $this->redirect('/memberdownload/');
}

return $this->render('update', [
'model' => $model,
]);
}

/**
* Deletes an existing MemberDownload model.
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
 Yii::$app->session->setFlash('success', 'MemberDownload Deleted');
 return $this->redirect('/memberdownload');
}

/**
* Finds the MemberDownload model based on its primary key value.
* If the model is not found, a 404 HTTP exception will be thrown.
* @param integer $id
* @return MemberDownload the loaded model
* @throws NotFoundHttpException if the model cannot be found
*/
protected function findModel($id)
{
        if (($model = MemberDownload::findOne($id)) !== null) {
    return $model;
}

throw new NotFoundHttpException('The requested page does not exist.');
}
}
