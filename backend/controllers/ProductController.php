<?php

namespace backend\controllers;

use backend\components\AuthController;
use common\models\base\Product;
use common\models\base\Productcontent;
use common\models\base\ProductCategory;
use common\models\base\Subcategory;
use common\models\search\ProductSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends AuthController
{

    public function init()
    {
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

    public function algolia()
    {

        $client = new \AlgoliaSearch\Client('TP8H76V4RK', 'ae0afaa0a2f3f3ccb559691522805852');
        $index = $client->initIndex('team_product');

        return $index;
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

        return $this->render('index', $data);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        // var_dump(Yii::$app->request->post());
        if (Yii::$app->request->post()) {
            // $model = new Productcontent;
            // $model->video = UploadedFile::getInstances($model, 'video');
            var_dump(json_encode(Yii::$app->request->post()));

            // $model->
            die();
            
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // return $this->redirect('/product/');

            \Cloudinary::config(array(
                "cloud_name" => YII::$app->params['cloudinaryName'],
                "api_key" => YII::$app->params['cloudinaryApiKey'],
                "api_secret" => YII::$app->params['cloudinarySecret'],
            ));

            $subsave = [];
            if (Yii::$app->request->post('Product')['subcategory']) {
                foreach (Yii::$app->request->post('Product')['subcategory'] as $item) {
                    $subsave[] = [$model->id, $item];
                }
                ProductCategory::insertBatch($subsave, $model->id);
            }

            $model->image = UploadedFile::getInstance($model, 'image');
            if ($filename = $model->upload(Url::to('@uploadpath') . '\\' . $model->id . '\\', $model->slug)) {
                // file is uploaded successfully
                $model->image = Url::to('/uploads/' . $model->id . '/' . $filename['filename'] . $filename['extension']);
                $model->image_path = Url::to('@uploadpath') . '/' . $model->id . '/' . $filename['filename'] . $filename['extension'];
                $thumbnail_path = Url::to('@uploadpath') . '/' . $model->id . '/' . $filename['filename'] . '-thumb' . $filename['extension'];
                $portrait_path = Url::to('@uploadpath') . '/' . $model->id . '/' . $filename['filename'] . '-portrait' . $filename['extension'];
                // $model->image_thumbnail = Url::to('/uploads/' . $model->id . '/' . $filename['filename'] . '-thumb' . $filename['extension']);
                // $model->image_portrait = Url::to('/uploads/' . $model->id . '/' . $filename['filename'] . '-portrait' . $filename['extension']);

                $content = file_get_contents($model->image_path);

                $original_image = \Cloudinary\Uploader::upload($model->image_path);
                $thumbnail_image = \Cloudinary\Uploader::upload($thumbnail_path);
                $portrait_image = \Cloudinary\Uploader::upload($portrait_path);

                unlink($thumbnail_path);
                unlink($portrait_path);

                $model->image = $original_image['url'];
                $model->image_thumbnail = $thumbnail_image['url'];
                $model->image_portrait = $portrait_image['url'];

                $media = UploadedFile::getInstance($model, 'product_download_url');
                if ($media != null) {
                    $model->product_download_url = $media;
                    if ($product_filename = $model->product_upload(Url::to('@productpath') . '\\' . $model->id . '\\', $model->slug)) {
                        $product = \Cloudinary\Uploader::upload(Url::to('@productpath') . '/' . $model->id . '/' . $product_filename['filename'] . $product_filename['extension']);
                        $model->product_download_url = $product['url'];
                    }
                }
                $model->save(false);

                $this->algolia()->addObject([
                    'id' => $model->id,
                    'slug' => Url::to('/' . $model->slug),
                    'name' => $model->name,
                    'category' => $model->category,
                    'synopsis' => $model->synopsis,
                    'description' => $model->description,
                    'price' => $model->price,
                    'price_discount' => $model->price_discount,
                    'brand' => $model->brand,
                    'discount_flag' => $model->discount_flag,
                    'image' => $model->image,
                    'image_path' => $model->image_path,
                    'image_thumbnail' => $model->image_thumbnail,
                    'image_portrait' => $model->image_portrait,
                    'headline' => $model->headline,
                    'meta_description' => $model->meta_description,
                    'meta_keyword' => $model->meta_keyword,
                    'product_download_url' => $model->product_download_url,
                    'product_download_path' => $model->product_download_path,
                    'product_view' => $model->product_view,
                    'status' => $model->status,
                    'created_at' => $model->created_at,
                    'updated_at' => $model->updated_at,
                ]);

            }

            Yii::$app->session->setFlash('success', 'Product Created');
            return $this->redirect('/product/');
        }

        $content = $this->renderPartial('_content');
        return $this->render('create', [
            'model' => $model,
            'content' => $content,
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

        $post = Yii::$app->request->post();
        if (!isset($_FILES['image'])) {
            $post['Product']['image'] = $model->image;
        }

        if (!isset($_FILES['product_download_url'])) {
            $post['Product']['product_download_url'] = $model->product_download_url;
        }

        if (Yii::$app->request->post() && $model->load($post) && $model->save()) {

            \Cloudinary::config(array(
                "cloud_name" => YII::$app->params['cloudinaryName'],
                "api_key" => YII::$app->params['cloudinaryApiKey'],
                "api_secret" => YII::$app->params['cloudinarySecret'],
            ));

            if ($post['Product']['subcategory']) {
                $subsave = [];

                foreach ($post['Product']['subcategory'] as $item) {
                    $subsave[] = [$model->id, $item];
                }

                ProductCategory::insertBatch($subsave, $model->id);
            }

            $image = UploadedFile::getInstance($model, 'image');

            if ($image != null) {
                $model->image = $image;
                if ($filename = $model->upload(Url::to('@uploadpath') . '\\' . $model->id . '\\', $model->slug)) {
                    // file is uploaded successfully
                    $model->image = Url::to('/uploads/' . $model->id . '/' . $filename['filename'] . $filename['extension']);
                    $model->image_path = Url::to('@uploadpath') . '/' . $model->id . '/' . $filename['filename'] . $filename['extension'];
                    $thumbnail_path = Url::to('@uploadpath') . '/' . $model->id . '/' . $filename['filename'] . '-thumb' . $filename['extension'];
                    $portrait_path = Url::to('@uploadpath') . '/' . $model->id . '/' . $filename['filename'] . '-portrait' . $filename['extension'];

                    $content = file_get_contents($model->image_path);

                    $original_image = \Cloudinary\Uploader::upload($model->image_path, ["timeout" => 120]);
                    $thumbnail_image = \Cloudinary\Uploader::upload($thumbnail_path, ["timeout" => 120]);
                    $portrait_image = \Cloudinary\Uploader::upload($portrait_path, ["timeout" => 120]);

                    unlink($thumbnail_path);
                    unlink($portrait_path);

                    $model->image = $original_image['url'];
                    $model->image_thumbnail = $thumbnail_image['url'];
                    $model->image_portrait = $portrait_image['url'];
                }
            }

            $media = UploadedFile::getInstance($model, 'product_download_url');
            if ($media != null) {
                $model->product_download_url = $media;
                if ($product_filename = $model->product_upload(Url::to('@productpath') . '\\' . $model->id . '\\', $model->slug)) {
                    $product = \Cloudinary\Uploader::upload(Url::to('@productpath') . '/' . $model->id . '/' . $product_filename['filename'] . $product_filename['extension']);
                    $model->product_download_url = $product['url'];
                    $model->product_download_path = Url::to('@productpath') . '\\' . $model->id . '\\' . $product_filename['filename'] . $product_filename['extension'];
                }
            }

            $model->save(false);

            $client = new \AlgoliaSearch\Client('TP8H76V4RK', 'ae0afaa0a2f3f3ccb559691522805852');
            $index = $client->initIndex('team_product');

            $this->algolia()->saveObjects([
                'id' => $model->id,
                'slug' => Url::to('/' . $model->slug),
                'name' => $model->name,
                'category' => $model->category,
                'synopsis' => $model->synopsis,
                'description' => $model->description,
                'price' => $model->price,
                'price_discount' => $model->price_discount,
                'brand' => $model->brand,
                'discount_flag' => $model->discount_flag,
                'image' => $model->image,
                'image_path' => $model->image_path,
                'image_thumbnail' => $model->image_thumbnail,
                'image_portrait' => $model->image_portrait,
                'headline' => $model->headline,
                'meta_description' => $model->meta_description,
                'meta_keyword' => $model->meta_keyword,
                'product_download_url' => $model->product_download_url,
                'product_download_path' => $model->product_download_path,
                'product_view' => $model->product_view,
                'status' => $model->status,
                'created_at' => $model->created_at,
                'updated_at' => $model->updated_at,
            ]);

            Yii::$app->session->setFlash('success', 'Product Updated');
            return $this->redirect('/product/');
        }

        $content = $this->renderPartial('_content');
        $active_category = ProductCategory::find()->where(['=', 'product', $model->id])->where(['=', 'status', ProductCategory::STATUS_ACTIVE])->all();
        $cats = [];

        foreach ($active_category as $item) {
            $cats[$item->sub_category] = array("selected" => true);
        }

        return $this->render('update', [
            'model' => $model,
            'content' => $content,
            'selected_subcategory' => $cats,
            'subcategory_list' => Subcategory::find()->where(['=', 'category', $model->category])->all(),
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
        $this->algolia()->deleteObjects([$model->id]);
        Yii::$app->session->setFlash('success', 'Product Deleted');
        return $this->redirect('/product');
    }

    /**
     * Upload image
     */
    public function actionUploadimage()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->post()) {

        }
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

    public function actionSubcategory($id = false)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!$id) {
            echo json_encode(['status' => 400, 'message' => 'Bad Parameter', 'error' => 'Email not Found'], JSON_PRETTY_PRINT);
            return;
        }

        $subcategory = SubCategory::find()->where(['category' => $id])->asArray()->all();
        if (!$subcategory) {
            echo json_encode(['status' => 201, 'message' => 'Record not Found!', 'data' => []]);
            return;
        }
        echo json_encode(['status' => 200, 'message' => 'Record Found!', 'data' => $subcategory]);
    }
}
