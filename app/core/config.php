<?php

/**
 * Database configuration
 */
const DB_NAME = "dinemate";

if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == 'localhost') {
    define("DB_HOST", "18.183.143.228");
    define("DB_USER", "dinemate");
} else {
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
}
const DB_PASS = "password";
const DB_PORT = 3306;

/**
 * App configuration
 */
if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == 'localhost') {
    define("ROOT", "/DineMate");
} else {
    define("ROOT", "");
}

const ASSETS = ROOT . "/assets";
const APP_DIR = "../app";
const VIEWS = "../app/views";

const APP_NAME = "DineMate";
const APP_DESC = "Restaurant Management System";

if (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == 'localhost') {
    define("DEBUG", true);
} else {
    define("DEBUG", false);
}
const LOG_ERRORS = true;
const ERROR_LOG = "/tmp/php-error.log";

/**
 * PhpMailer Configuration
 */
const EMAIL = "dinematesl@gmail.com";
const PASS = "hxrgftesoknqsynv";
const PORT = 587;