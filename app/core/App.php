<?php

namespace core;

use controllers\_404;
use controllers\api\_401;
use utils\RouteAuth;

class App
{
    private mixed $module = "";
    private array $modules = ["admin", "api"];
    private mixed $controller = "home";
    private string $method = "index";
    private array $params = [];

    function __construct()
    {
        $allowed = false;
        $found = false;

        // splits the url into an array
        $url = $this->splitUrl();

        // generates path of controller
        $path = "../app/controllers/";

        // checks if the first part of the url is a module
        if (isset($url[0]) && in_array($url[0], $this->modules)) {
            $this->module = $url[0];
            array_shift($url);
            //Appends module name to path
            $path .= $this->module . "/";
        }

        //If a controller is not specified, the default controller(home) is used.
        $path .= ucfirst($url[0] ?? $this->controller) . ".php";
        if (!isset($url[0])) {
            $found = true;
            //Check if trying to access admin
            if (!(RouteAuth::checkAuth('home', $this->module))) {
                //Send to 401 page if not authorized
                (new \controllers\_401())->index();
            }else
                $allowed = true;
        } else {
            // checks if the controller exists
            if (file_exists($path)) {
                $this->controller = $url[0];

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
            } else {
                //Send to 404 page if controller not found
                (new _404())->index();
            }
        }

        RouteAuth::guestSession($this->controller, $this->module);

        if ($allowed && $found) {
            //Create an instance of the controller
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
                    //Send to 404 page if method not found
                    (new _404())->index();
                    $found = false;
                }
            }
        }
        // sets the params
        $this->params = $url ? array_values($url) : [];
        unset($url);
        if ($allowed && $found)
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