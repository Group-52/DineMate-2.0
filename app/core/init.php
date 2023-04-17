<?php
/**
 * Application Initialisation
 * Implements autoloader and includes core files.
 */

// Autoload classes that cannot be found
spl_autoload_register(function ($classname) {
    require $filename = "../app/" . str_replace("\\", "/", $classname) . ".php";
});

// require '../vendor/autoload.php';
require 'config.php';
require 'functions.php';
require 'Database.php';
require 'Model.php';
require 'Controller.php';
require 'App.php';

date_default_timezone_set('Asia/Colombo');