<?php

namespace core;
class App
{
    private mixed $module = "";
    private array $modules = ["admin", "api"];
    private mixed $controller = "home";
    private string $method = "index";
    private array $params = [];

    function __construct()
    {
        // splits the url into an array
        $url = $this->splitUrl();

        // checks if the first part of the url is a module
        if (isset($url[0]) && in_array($url[0], $this->modules)) {
            $this->module = $url[0];
            array_shift($url);
        }

        $controllerPath = "../app/controllers/";

        // generates path of controller
        $path = $controllerPath;
        if ($this->module) {
            // appends module name if it exists
            $path .= $this->module . "/";
        }
        $path .= ucfirst($url[0] ?? $this->controller) . ".php";

        // checks if the controller exists
        if (isset($url[0])) {
            if (file_exists($path)) {
<<<<<<< HEAD
<<<<<<< HEAD
                $this->controller = $url[0];
                unset($url[0]);
=======
                $this->controller = ucfirst($url[0]);
=======
                $this->controller = $url[0];
>>>>>>> f89be9ccaf1258b7066f4b2dd4a3fd47ca3e46b2

                //Check if the user is allowed to access the controller
                if (!(RouteAuth::checkAuth($this->controller, $this->module))) {
                    //Send to 401 page if not authorized
                    if ($this->module === "api")
                        (new _401())->index();
                    else
                        (new \controllers\_401())->index();
                } else {
                    $allowed = true;
                    unset($url[0]);
                }
                $found = true;
>>>>>>> f10f7c0659e90f0badd5c5173d2df0cac462f440
            } else {
                $this->controller = null;
            }
        }

<<<<<<< HEAD
        if ($this->controller) {
            include $path;
=======
        RouteAuth::guestSession($this->controller, $this->module);

        if ($allowed && $found) {
            //Create an instance of the controller
>>>>>>> f89be9ccaf1258b7066f4b2dd4a3fd47ca3e46b2
            if ($this->module) {
                $this->controller = "controllers\\" . $this->module . "\\" . ucfirst($this->controller);
            } else {
                $this->controller = "controllers\\" . ucfirst($this->controller);
            }
            $this->controller = new $this->controller;

            // checks if the method exists
            if (isset($url[1])) {
                if (method_exists($this->controller, $url[1])) {
                    $this->method = $url[1];
                    unset($url[1]);
                } else {
                    $this->controller = null;
                }
            }
        } else {
            $this->controller = null;
        }

        if (!$this->controller) {
            $this->controller = "controllers\\";
            $path = $controllerPath;
            if ($this->module) {
                $this->controller .= $this->module . '\\';
                $path .= $this->module . "/";
            }
            $this->controller .= "_404";
            $path .= "_404.php";
            include $path;
            $this->controller = new $this->controller;
        }


        // sets the params
        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    /**
     * Splits the URL into an array and assigns the values to the controller, method and params properties.
     * @return array|string[]
     */
    private function splitUrl(): array
    {
        if (isset($_GET["url"])) {
            return explode("/", filter_var(rtrim($_GET["url"], "/"), FILTER_SANITIZE_URL));
        } else {
            return [];
        }
    }
}