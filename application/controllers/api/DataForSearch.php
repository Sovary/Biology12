<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataForSearch extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(["category_model","level_model"]);
	}

	public function getDataForSearch_APIController()
	{
		$cates = $this->category_model->getCategories_API();
		$levels = $this->level_model->getLevels_API();
		echo json_encode(["CATEGORY"=>$cates,"LEVEL"=>$levels]);
	}
}