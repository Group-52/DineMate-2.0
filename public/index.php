<?php

session_start();

require "../app/core/init.php";

ini_set("display_errors", DEBUG ? "1" : "0");
ini_set("log_errors", LOG_ERRORS ? "1" : "0");
ini_set("error_log", ERROR_LOG);

$app = new App();