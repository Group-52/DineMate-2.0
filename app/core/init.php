<?php
/**
 * Application Initialisation
 * Implements autoloader and includes core files.
 */

// Autoload classes that cannot be found
spl_autoload_register(function($classname){

	require $filename = "../app/models/".ucfirst($classname).".php";
});

require 'config.php';
require 'functions.php';
require 'Database.php';
require 'Model.php';
require 'Controller.php';
require 'App.php';