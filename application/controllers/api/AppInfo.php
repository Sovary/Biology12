<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @ Nov 11, 2018
 */
class AppInfo extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @app_version_code :required specified to update
	 */
	public function getVersion_APIController()
	{
		echo json_encode(["app_version_name"=>"1.5.18.1","app_version_code"=>5]);
	}
}