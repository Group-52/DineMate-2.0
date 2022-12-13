<?php

/** database config **/
const DBNAME = "dinemate";
const DBHOST = "localhost";
const DBUSER = "root";
const DBPASS = "";
const DBDRIVER = "";

define('ROOT', 'http://localhost/DineMate/public');
define('ASSETS', 'http://localhost/DineMate/public/assets');

if ($_SERVER["SERVER_NAME"] == "localhost")
    define("ROOT", "http://localhost/DineMate/public");
else
    define("ROOT", "https://www.DineMate.com");

const APP_NAME = "DineMate";
const APP_DESC = "Restaurant Management System";

/** true means show errors **/
const DEBUG = true;

const LOG_ERRORS = true;
const ERROR_LOG = "/tmp/php-error.log";