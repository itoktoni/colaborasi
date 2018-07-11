<?php

namespace backend\controllers;

use backend\models\base\Roles;
use backend\models\search\RolesSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\models\base\Permission;
use backend\components\AuthController;

/**
 * RolesController implements the CRUD actions for Roles model.
 */
class RolesController extends AuthController 
{

    public function init()
    {
        $this->view->params['menu']     = 'setting';
        $this->view->params['submenu']  = 'roles';
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
     * Lists all Roles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchmodel = new \backend\models\search\RolesSearch;
        $query = $searchmodel->search(Yii::$app->request->get());
        $data['pages'] = $query->getPagination();
        $data['dataProvider'] = $query->getModels();

        return $this->render('index', $data);
    }

    /**
     * Creates a new Roles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Roles();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $data = Yii::$app->request->post();
            $each = [];
            $roles = $model->id;
            
            foreach ($data['feature'] as $feature => $item) {
                $model = Permission::find()->where(['roles' => $roles, 'feature' => $feature])->one();
                if ($model) {
                    $model->access = $item;
                    $model->save(false);
                } else {
                    $each[] = [$roles, $feature, $item];
                }
            }

            if ($each) {
                Yii::$app->db->createCommand()->batchInsert('permission', ['roles', 'feature', 'access'], $each)->execute();
            }

            Yii::$app->cache->delete('roles_' . $roles);

            Yii::$app->session->setFlash('success', 'Roles Created');
            return $this->redirect('/roles/');
        }

        return $this->render('create', [
            'model' => $model,
            'roles' => false,
        ]);
    }

/**
 * Updates an existing Roles model.
 * If update is successful, the browser will be redirected to the 'view' page.
 * @param integer $id
 * @return mixed
 * @throws NotFoundHttpException if the model cannot be found
 */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $data = Yii::$app->request->post();
            $each = [];
            $roles = $model->id;
            
            foreach ($data['feature'] as $feature => $item) {
                $model = Permission::find()->where(['roles' => $roles, 'feature' => $feature])->one();
                if ($model) {
                    $model->access = $item;
                    $model->save(false);
                } else {
                    $each[] = [$roles, $feature, $item];
                }
            }

            if ($each) {
                Yii::$app->db->createCommand()->batchInsert('permission', ['roles', 'feature', 'access'], $each)->execute();
            }

            Yii::$app->cache->delete('roles_' . $roles);

            if ($id == YII::$app->user->identity->roles) {

                $permission = Permission::find()->joinWith('feature0', false, 'inner join')->leftjoin('feature_group', '`feature`.`feature_group` = `feature_group`.`id`')->where(['roles' => YII::$app->user->identity->roles, 'feature_group.status' => 1, 'feature.status' => 1])->select(['feature_group.name as feature_group', 'feature_group.icon as feature_group_icon', 'feature_group.slug as feature_group_slug', 'feature' . '.name', 'feature' . '.slug', 'feature' . '.icon', 'permission' . '.access'])->orderBy('feature_group.name', SORT_ASC)->asArray()->all();
                $menu = $group = $list = [];
                foreach ($permission as $item) {
                    if (!isset($group[strtolower($item['feature_group'])])) {
                        $group[strtolower($item['feature_group'])] = ['name' => $item['feature_group'], 'icon' => $item['feature_group_icon'], 'slug' => $item['feature_group_slug']];
                    }
                    $menu[strtolower($item['feature_group'])][] = ['name' => $item['name'], 'slug' => $item['slug'], 'icon' => $item['icon'], 'access' => $item['access']];
                    $list[$item['slug']] = ['name' => $item['name'], 'slug' => $item['slug'], 'icon' => $item['icon'], 'access' => $item['access']];
                }

                $result = ['group' => $group, 'menu' => $menu, 'list' => $list];
                $session = Yii::$app->session;
                $session->set('menu', $result);
            }   

            Yii::$app->session->setFlash('success', 'Roles Updated');
            return $this->redirect('/roles/');
        }
        return $this->render('update', [
            'model' => $model,
            'roles' => $id,
        ]);

    }

/**
 * Deletes an existing Roles model.
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
        Yii::$app->session->setFlash('success', 'Roles Deleted');
        return $this->redirect('/roles');
    }

/**
 * Finds the Roles model based on its primary key value.
 * If the model is not found, a 404 HTTP exception will be thrown.
 * @param integer $id
 * @return Roles the loaded model
 * @throws NotFoundHttpException if the model cannot be found
 */
    protected function findModel($id)
    {
        if (($model = Roles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
