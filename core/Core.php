<?php



class Core
{
    public function __construct()
    {
        $this->run();
    }

    public function run()
    {
        if (isset($_GET['url'])) {
            $url = $_GET['url'];
        }


        if (!empty($url)) {
            $url = explode("/", $url);
            $controller = $url[0] . "Controller";
            print_r($controller);
            array_shift($url);
            if (!empty($url[0]) && isset($url[0])) {
                $method = $url[0];
                array_shift($url);
            } else {
                $method = "index";
            }


            if (count($url) > 0) {
                $parameters = $url;
            }
        } else {
            $parameters = array();
            $controller = "HomeController";
            $method = "index";
        }
        $path = "controllers/" . $controller . ".php";
        if (!file_exists($path) && !method_exists($controller, $method)) {
            $controller = "LoginController";
            $method = "index";
        }

        $c = new $controller;
        $c->{$method}($parameters);
        //call_user_func(array($c, $method), $parameters);
    }
}
