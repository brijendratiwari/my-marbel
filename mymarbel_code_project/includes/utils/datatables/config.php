<?php if (!defined('DATATABLES')) exit(); // Ensure being used in DataTables env.

require_once '../functions.php';

// Enable error reporting for debugging (remove for production)
error_reporting(E_ALL);
ini_set('display_errors', '1');


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Database user / pass
 */
$sql_details = array(
	"type" => "Mysql",  // Database type: "Mysql", "Postgres", "Sqlite" or "Sqlserver"
	"user" => SQL_USER,       // Database user name
	"pass" => SQL_PASSWORD,       // Database password
	"host" => SQL_HOST,       // Database host
	"port" => SQL_PORT,       // Database connection port (can be left empty for default)
	"db"   => SQL_DATABASE,       // Database name
	"dsn"  => "charset=utf8"        // PHP DSN extra information. Set as `charset=utf8` if you are using MySQL
);


