<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exercise extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("exercise_model");
	}

	private function IsNullOrEmptyString($txt)
	{
        return (!isset($txt) || trim($txt)==='');
    }

	public function getExercisesLatest_APIController()
	{
		$param =["page"=>$this->input->get("page")];
		echo json_encode($this->exercise_model->getExercisesLatest_API($param));
	}

	public function getExercisesBatchById_APIController()
	{
		$ids = $this->input->post("ids");
		$param =["ids"=>json_decode($ids)];
		echo json_encode($this->exercise_model->getExercisesBatchById_API($param));
	}

	public function getExerciseById_APIController()
	{
		$param=["id"=>$this->uri->segment(4,0)];
		$rs = $this->exercise_model->getExerciseById_API($param);
		$this->load->view("question.php",["question"=>$rs["question"],"answer"=>$rs["answer"]]);
	}

	public function getExercisesByCategoryId_APIController()
	{
		$param = [
				 "page"=>$this->input->get("page"),
				 'cate_id'=>$this->uri->segment(4)
				 ];
		echo json_encode($this->exercise_model->getExercisesByCategoryId_API($param));
	}

	public function getExercisesByFilter_APIController()
	{
		$param = array(
			"page"=>$this->input->get("page"),
			'txt'=>$this->input->get("text"),
			'level'=>$this->input->get("level"),
			'cate'=>$this->input->get("cate"),
		);		
		echo json_encode($this->exercise_model->getExcerciesByFilter_API($param));
	}
}