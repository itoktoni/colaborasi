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
        return $this->render('index');
    }

}
