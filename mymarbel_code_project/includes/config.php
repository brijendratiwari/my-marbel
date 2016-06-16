<?php
	/*define("SQL_HOST", "localhost");
	define("SQL_USER", "marbel_web");
	define("SQL_PASSWORD", "pinksillyelephant");
	define("SQL_DATABASE", "marbel");*/
	 
        define("SQL_HOST", "localhost");
	define("SQL_USER", "root");
	define("SQL_PASSWORD", "");
	define("SQL_DATABASE", "marbel");
	define("SECURE", false);

	define("SHOPIFY_APP_SECRET", "ccf2c4635adbc79bf120e3f7362b0322");
	define("SHOPIFY_DEBUG", false);
	
	define("ROOT_PATH", realpath('../'));

	define("CONTACT_ALLOWED_FILESIZE", 1048576 * 10); # 1048576 = 1 mb
	define("CONTACT_UPLOADS_DIRECTORY", 'cache/uploads/');

	define("MANDRILL_API_KEY", "k3nXvdqEhHEa9LLJ__bUCA");
	// define("MANDRILL_API_KEY", "FfkPdqhpdANpREYXKuAM_Q");
	define("CONTACT_EMAIL", 'hello@ridemarbel.com');
?>