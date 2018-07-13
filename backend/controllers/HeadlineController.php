<?php

namespace backend\controllers;

use common\models\base\Headline;
use common\models\search\HeadlineSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * HeadlineController implements the CRUD actions for Headline model.
 */
class HeadlineController extends Controller
{

    public function init()
    {
        $this->view->params['menu'] = 'setting';
        $this->view->params['submenu'] = 'headline';
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
     * Lists all Headline models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchmodel = new \common\models\search\HeadlineSearch;
        $query = $searchmodel->search(Yii::$app->request->get());
        $data['pages'] = $query->getPagination();
        $data['dataProvider'] = $query->getModels();

        return $this->render('index', $data);
    }

    /**
     * Creates a new Headline model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Headline();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Cloudinary::config(array(
                "cloud_name" => YII::$app->params['cloudinaryName'],
                "api_key" => YII::$app->params['cloudinaryApiKey'],
                "api_secret" => YII::$app->params['cloudinarySecret'],
            ));

            $model->image = UploadedFile::getInstance($model, 'image');
            if ($filename = $model->upload(Url::to('@uploadpath') . '\\' . 'headline' . '\\' . $model->id . '\\', $model->title)) {

                $model->image = Url::to('/uploads/' . $model->id . '/headline' . '/' . $filename['filename'] . $filename['extension']);
                $image_path = Url::to('@uploadpath') . '/headline' . '/' . $model->id . '/' . $filename['filename'] . $filename['extension'];

                $original_image = \Cloudinary\Uploader::upload($image_path);
                unlink($image_path);

                $model->image = $original_image['url'];

                $model->save(false);
            }

            Yii::$app->session->setFlash('success', 'Headline Created');
            return $this->redirect(['/headline/']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

/**
 * Updates an existing Headline model.
 * If update is successful, the browser will be redirected to the 'view' page.
 * @param integer $id
 * @return mixed
 * @throws NotFoundHttpException if the model cannot be found
 */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $post = Yii::$app->request->post();
        if (!isset($_FILES['image'])) {
            $post['Headline']['image'] = $model->image;
        }

        if (Yii::$app->request->post() && $model->load($post) && $model->save()) {
            \Cloudinary::config(array(
                "cloud_name" => YII::$app->params['cloudinaryName'],
                "api_key" => YII::$app->params['cloudinaryApiKey'],
                "api_secret" => YII::$app->params['cloudinarySecret'],
            ));
            $image = UploadedFile::getInstance($model, 'image');

            if ($image != null) {
                $model->image = $image;
                if ($filename = $model->upload(Url::to('@uploadpath') . '\\' . 'headline' . '\\' . $model->id . '\\', $model->title)) {
                    $model->image = Url::to('/uploads/' . $model->id . '/headline' . '/' . $filename['filename'] . $filename['extension']);
                    $image_path = Url::to('@uploadpath') . '/headline' . '/' . $model->id . '/' . $filename['filename'] . $filename['extension'];

                    $original_image = \Cloudinary\Uploader::upload($image_path);

                    unlink($image_path);

                    $model->image = $original_image['url'];

                    $model->save(false);
                }
            }

            Yii::$app->session->setFlash('success', 'Headline Updated');
            return $this->redirect('/headline/');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

/**
 * Deletes an existing Headline model.
 * If deletion is successful, the browser will be redirected to the 'index' page.
 * @param integer $id
 * @return mixed
 * @throws NotFoundHttpException if the model cannot be found
 */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        Yii::$app->session->setFlash('success', 'Headline Deleted');
        return $this->redirect('/headline');
    }

/**
 * Finds the Headline model based on its primary key value.
 * If the model is not found, a 404 HTTP exception will be thrown.
 * @param integer $id
 * @return Headline the loaded model
 * @throws NotFoundHttpException if the model cannot be found
 */
    protected function findModel($id)
    {
        if (($model = Headline::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
