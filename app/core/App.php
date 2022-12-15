<?php

class App
{
    private mixed $module = "";
    private array $modules = ["admin"];
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
            $path .= ucfirst($this->module) . "/";
        }
        $path .= ucfirst($url[0] ?? $this->controller) . ".php";

        // checks if the controller exists
        if (isset($url[0])) {
            if (file_exists($path)) {
                $this->controller = $url[0];
                unset($url[0]);
            } else {
                $this->controller = null;
            }
        }

        include $path;
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

        // checks if method exists
        if ($this->controller && !method_exists($this->controller, $this->method)) {
            $this->controller = null;
        }

        if (!$this->controller) {
            $this->controller = "_404";
            $path = $controllerPath . "_404.php";
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