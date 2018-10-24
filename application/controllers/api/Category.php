<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("category_model");
	}

	public function getCategories_APIController()
	{
		echo json_encode($this->category_model->getCategories_API());
	}
}