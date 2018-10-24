<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Level extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(["level_model"]);
	}

	public function getLevels_APIController()
	{
		echo json_encode($this->level_model->getAllLevels());
	}

}