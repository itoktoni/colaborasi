<?php

namespace backend\controllers;
use backend\components\AuthController;

/**
 * Site controller
 */
class DashboardController extends AuthController {

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        menu($this,'dashboard','');
    	$this->view->params['menu'] 	= 'dashboard';
        // $this->view->params['submenu'] 	= '';
        return $this->render('index');
    }

}
