<?php

/** database config **/
const DB_NAME = "dinemate";
const DB_HOST = "localhost";
const DB_USER = "root";
const DB_PASS = "";
const DB_DRIVER = "";

if ($_SERVER["SERVER_NAME"] == "localhost") {
    define("ROOT", "http://localhost/DineMate/public");
} else {
    define("ROOT", "https://www.DineMate.com");
}

const ASSETS = ROOT . "/assets";

const VIEWS = "../app/views";

const APP_NAME = "DineMate";
const APP_DESC = "Restaurant Management System";

/** true means show errors **/
const DEBUG = true;

const LOG_ERRORS = true;
const ERROR_LOG = "/tmp/php-error.log";