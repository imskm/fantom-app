<?php

namespace App;

/**
 * Configuration for storing
 * settings of the current environment
 */
class Config
{
	/**
	 * DB Driver
	 * @var string
	 */
	const DB_DRIVER = "mysql";

	/**
	 * Database host
	 * @var string
	 */
	const DB_HOST = "127.0.0.1";

	/**
	 * Database port
	 * @var string
	 */
	const DB_PORT = "3306";

	/**
	 * Database name
	 * @var string
	 */
	const DB_NAME = "";

	/**
	 * Database username
	 * @var string
	 */
	const DB_USER = "root";

	/**
	 * Database password
	 * @var string
	 */
	const DB_PASSWORD = "";

	/**
	* Show or Hide error messages on screen
	* @var boolean
	*/
	const SHOW_ERRORS = true;

	/**
	 * ------------------------------------------
	 * Mail config
	 * ------------------------------------------
	 *
	 */
	const MAIL_USERNAME 	= "";
	const MAIL_PASSWORD 	= "";
	const MAIL_HOST			= "";
	const MAIL_PORT			= 465;
	const MAIL_ENCRYPTION	= "ssl";

	/**
	 * Get the config from SITE_CONFIG constant
	 * @var string $key of the config name
	 * @return the config set with $key
	 */
	public static function get($key)
	{
		if(! isset(self::SITE_CONFIG[$key])) {
			throw new \Exception("Config $key not found!");
		}

		return self::SITE_CONFIG[$key];
	}

	/**
	 * ------------------------------------------
	 * User defined configs
	 * ------------------------------------------
	 * Additional User configuration
	 *
	 */
	const SITE_CONFIG = array(
		"site_url"				=> "http://fantom-app",
		"site_name" 			=> "Fantom",
		"csrf_name" 			=> "csrf_token",
		"old_post_sessname"		=> "old_post",
		"mail_sender_email"		=> "",
		"mail_sender_name"		=> "",

	);

}
