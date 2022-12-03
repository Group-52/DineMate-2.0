<?php 

if($_SERVER['SERVER_NAME'] == 'localhost')
{
	/** database config **/
	define('DBNAME', 'dinemate2');
	define('DBHOST', 'localhost');
	define('DBUSER', 'Dineth');
	define('DBPASS', '1234');
	define('DBDRIVER', '');
	
	define('ROOT', 'http://localhost/DineMate/public');

}else
{
	/** database config **/
	define('DBNAME', 'dinemate2');
	define('DBHOST', 'localhost');
	define('DBUSER', 'Dineth');
	define('DBPASS', '1234');
	define('DBDRIVER', '');

	define('ROOT', 'https://www.DineMate.com');

}

define('APP_NAME', "DineMate ");
define('APP_DESC', "Restaurant Management System");

/** true means show errors **/
define('DEBUG', true);
