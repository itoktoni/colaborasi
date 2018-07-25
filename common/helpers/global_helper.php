<?php


/**
 * Dump and die shortcut
 */
if (!function_exists('vd')) {
    /**
     * Alias of Kint::dump().
     *
     * @return string
     */
    function vd($variable)
    {
        
        var_dump($variable);
        die();
    }
}

/**
 * Alias for vd()
 */
if (!function_exists('dd')) {

    function dd($variable)
    {
        vd($variable);
    }
}

/**
 * Shortcut for YII::$app->request->post();
 */
if (!function_exists('post')) {

    function post($variable = false, $default = false)
    {
        if($variable){
            return (YII::$app->request->post($variable))?YII::$app->request->post($variable):$default;
        }
        
        return YII::$app->request->post();
    }
}

/**
 * Shortcut for YII::$app->request->post();
 */
if (!function_exists('get')) {

    function get($variable = false, $default = false)
    {
        if($variable){
        return (YII::$app->request->get($variable))?YII::$app->request->get($variable):$default;
        }
        
        return YII::$app->request->post();
    }
}


/**
 * Shortcut for curl request;
 */
if (!function_exists('curl')) {

    function curl($url = false, $options = false, $override = false)
    {
        $curl = curl_init($url);

        $default_settings = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30
        ];

        if($override){
            $default_settings = $options;
        }else{
            foreach($options as $key => $item){
                $default_settings[$key] = $item;
            }
        }

        curl_setopt_array($curl, $default_settings);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}



/**
 * Shortcut for YII::$app->request->post();
 */
if (!function_exists('menu')) {

    function menu($context, $menu = false, $submenu = '', $menu_parameter = 'menu', $submenu_parameter = 'submenu')
    {
        if($menu){
            $context->view->params[$menu_parameter] = $menu;
        }

        $context->view->params[$submenu_parameter] = $submenu;
    }
}

