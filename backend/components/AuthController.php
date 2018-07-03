<?php

namespace backend\components;

use Yii;
use yii\web\Controller;
use backend\models\base\Permission;
use yii\web\ForbiddenHttpException;

/**
 * Site controller
 */
class AuthController extends Controller {

    const ACTION_CREATE = 'create';
    const ACTION_DELETE = 'delete';
    const ACTION_UPDATE = 'update';

    /**
     * Check if this guy is a guest
     * @return type
     */
    public function init()
    {
//        if (!Yii::$app->user->isGuest)
//        {
//            return $this->redirect('/dashboard');
//        }
    }

    /**
     * 
     * 
     * Work before action controller
     * @param type $action
     * @return type
     * @throws ForbiddenHttpException
     */
    public function beforeAction($action)
    {


        if (Yii::$app->user->isGuest)
        {
            return $this->redirect('/adminlogin');
        }

        /*
         * Get current session
         */
        $session = Yii::$app->session;

        /**
         * get current accessed controller
         */
        $current = strtolower(Yii::$app->controller->id);

        /**
         * excluded query
         */
        $exclude = ['dashboard', 'signout'];
        
        // delete cache #uncomment if needed
        // Yii::$app->cache->delete('roles_' . Yii::$app->user->identity->roles);

        /**
         * check in cache if this roles exists,
         * this script prevent over query to database
         */
        if (!Yii::$app->cache->exists('roles_' . Yii::$app->user->identity->roles))
        {
            $permission = Permission::find()
                    ->joinWith('feature0', false, 'inner join')
                    ->leftjoin('feature_group', '`feature`.`feature_group` = `feature_group`.`id`')
                    ->where(['roles' => Yii::$app->user->identity->roles, 'feature_group.status' => 1, 'feature.status' => 1])
                    ->select(['feature_group.name as feature_group', 'feature_group.icon as feature_group_icon', 'feature_group.slug as feature_group_slug', 'feature' . '.name', 'feature' . '.slug', 'feature' . '.icon', 'permission' . '.access'])
                    ->orderBy('feature_group.name', SORT_ASC)
                    ->asArray()
                    ->all();


            $menu = $group = $list = [];
            foreach ($permission as $item) {
                if (!isset($group[strtolower($item['feature_group'])]))
                {
                    $group[strtolower($item['feature_group'])] = ['name' => $item['feature_group'], 'icon' => $item['feature_group_icon'], 'slug' => $item['feature_group_slug']];
                }
                $menu[strtolower($item['feature_group'])][] = ['name' => $item['name'], 'slug' => $item['slug'], 'icon' => $item['icon'], 'access' => $item['access']];
                $list[$item['slug']] = ['name' => $item['name'], 'slug' => $item['slug'], 'icon' => $item['icon'], 'access' => $item['access']];
            }

            $data = ['group' => $group, 'menu' => $menu, 'list' => $list];
            Yii::$app->cache->add('roles_' . Yii::$app->user->identity->roles, $data, 360);
        }
        else
        {
//            echo 'cache';
            $data = Yii::$app->cache->get('roles_' . Yii::$app->user->identity->roles);
        }


        /**
         * Check if current url is on exclude item array,
         * If they do, return to action immediately
         */
        if (in_array($current, $exclude))
        {
//            var_dump(in_array($current, $exclude));
//            die();
            return parent::beforeAction($action);
        }

        /**
         * Check if current controller is exists on current roles OR
         * cache / database if his access is exists
         * if not, throw a forbidden exception
         */
        if (!isset($session['menu']['list'][$current]))
        {
            throw new ForbiddenHttpException;
        }


        if (!isset($data['list'][$current]))
        {
            Yii::$app->user->logout();

            return $this->redirect('/adminlogin');
        }

        /*
         * check if access 
         */
        switch ($session['menu']['list'][$current]['access']) {
            /**
             * check if current user have no access
             */
            case Permission::NO_ACCESS:
                throw new ForbiddenHttpException;
            /**
             * check if current user have readonly access
             */
            case Permission::READONLY:
                if (Yii::$app->controller->action->id == self::ACTION_UPDATE ||
                        Yii::$app->controller->action->id == self::ACTION_DELETE ||
                        Yii::$app->controller->action->id == self::ACTION_CREATE)
                {
                    throw new ForbiddenHttpException;
                }
                break;

            /**
             * check if current user have full access
             */
            case Permission::FULL_ACCESS:
                break;

            /**
             * This is illegall access
             */
            default:
                throw new ForbiddenHttpException;
        }

        /**
         * And return to action after doing some filtering
         */
        return parent::beforeAction($action);
    }

}
