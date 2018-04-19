<?php

class Core {

	// Function to write the config file
function write_config($domain) {

	// Config path
	$template_path 	= 'config/config.php';
	$output_path 	= '../application/config/config.php';

	// Open the file
	$config_file = file_get_contents($template_path);

	$saved  = str_replace("%DEFAULT_URL%",$domain,$config_file);

	// Write the new config.php file
	$handle = fopen($output_path,'w+');

	// Chmod the file, in case the user forgot
	@chmod($output_path,0777);

	// Verify file permissions
	if(is_writable($output_path)) {

		// Write the file
		if(fwrite($handle,$saved)) {
			@chmod($output_path,0644);
			return true;
		} else {
			return false;
		}

	} else {
		return false;
	}
}

	// Function to validate the post data
	function validate_post($data)
	{
		/* Validating the hostname, the database name and the username. The password is optional. */
		return !empty($data['hostname']) && !empty($data['username']) && !empty($data['database']);
	}

	// Function to show an error
	function show_message($type,$message) {
		return $message;
	}

	// Function to write the config file
	function write_database($data) {

		// Config path
		$template_path 	= 'config/database.php';
		$output_path 	= '../application/config/database.php';

		// Open the file
		$database_file = file_get_contents($template_path);

		$new  = str_replace("%HOSTNAME%",$data['hostname'],$database_file);
		$new  = str_replace("%USERNAME%",$data['username'],$new);
		$new  = str_replace("%PASSWORD%",$data['password'],$new);
		$new  = str_replace("%DATABASE%",$data['database'],$new);

		// Write the new database.php file
		$handle = fopen($output_path,'w+');

		// Chmod the file, in case the user forgot
		@chmod($output_path,0777);

		// Verify file permissions
		if(is_writable($output_path)) {

			// Write the file
			if(fwrite($handle,$new)) {
				return true;
			} else {
				return false;
			}

		} else {
			return false;
		}
	}
}
