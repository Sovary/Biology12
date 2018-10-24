<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//For version lower then Aug 20, 2018
class ExerciseOld extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("exercise_model");
	}

	public function index()
	{
		
		$type = $this->input->get("type");
		$cid = $this->input->get("cid");

		$cate = $this->input->get("cate");
		$lvl = $this->input->get("lvl");
		$p = $this->input->get("p");

		if($type!=null)
		{
			if($type == "category")
			{
				$this->getCategories_Controller();
			}
			else if($type=="level" && $cid !=null)
			{
				$this->getLevelByCategory_Controller();
			}
		}
		else if($cate !=null && $lvl !=null)
		{
			$this->getExerciseByLevelId_Controller();
		}
		else
		{
		    echo '
		    <html lang="en" class="no-js logged-in client-root">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title></title>
		    <meta property="al:android:app_name" content="Khmer Biology Exercises" />
            <meta property="al:android:package" content="com.hellokhdev.sovary.biology" />
            
            </head>
    <body></body>
    </html>
            ';
		}

	}

	public function getCategories_Controller()
	{
		$rs = $this->db->where("ordering !=",0)->get("tb_categories")->result_array();
		echo json_encode(["DATA"=>$rs]);
	}

	public function getLevelByCategory_Controller()
	{
		$query = [];
		try
		{
			$cid = $this->input->get("cid");
			if($cid == null) throw new Exception();
			$sql = "SELECT DISTINCT `level`,l.id,level_name,level_image,category 
		 	FROM tb_exercises e JOIN tb_levels l ON e.`level`=l.id  WHERE category = ? ORDER BY `level` ASC";
			$query = $this->db->query($sql,[$cid])->result();
		}catch(Exception $e){}
		echo json_encode(["DATA"=>$query]);

	}

	public function getExerciseByLevelId_Controller()
	{
		$query = [];
		$totalPage  = 0;
		$limit = 10;
		try
		{
			$cate_id = $this->input->get("cate");
			$lvl_id = $this->input->get("lvl");
			$p = $this->input->get("p");
			$p = $p==null ? 1: $p;
			$order = $this->input->get("order");
			$order = $order==null || strtolower($order) == "asc" ? "ASC": "DESC";
			if($cate_id ==null && $lvl_id == null && $p==null)throw new Exception();
			
			$limit = 10;
		 	$offset = ($p-1) *$limit;
		 	if($offset<0)$offset=0;

		 	$sql="SELECT e.id,level_name,level_image,status,category,question_number,question,created_at ";
		 	if($lvl_id ==0)
		 	{
			 	$sql .= " FROM tb_exercises e join tb_levels l on e.`level`=l.id WHERE 
			 	category= ? ORDER BY question_number $order LIMIT ? OFFSET ?";
			 	$query = $this->db->query($sql,[$cate_id,$limit,$offset])->result();
			 	$sql_total = "SELECT COUNT(*) as total FROM tb_exercises WHERE category= ?";
			 	$q = $this->db->query($sql_total,[$cate_id])->row();
			 	$totalPage = $q->total;
			}
			 else
			{
			 	$sql .= " FROM tb_exercises e join tb_levels l on e.`level`=l.id WHERE 
			 	e.level=? AND category= ? ORDER BY question_number $order LIMIT ? OFFSET ?";
			 	$query = $this->db->query($sql,[$lvl_id,$cate_id,$limit,$offset])->result();
		 		$sql_total = "SELECT COUNT(*) as total FROM tb_exercises WHERE level=? AND category= ?";
		 		$q = $this->db->query($sql_total,[$lvl_id,$cate_id])->row();
		 		$totalPage = $q->total;
			}

		}catch(Exception $e){}
		foreach ($query as $item) 
		{
			$item->question = count($item->question > 70)? 
				mb_substr($item->question,0,70) : $item->question;
		}
		echo json_encode(["DATA"=>$query,"SIZE"=>count($query),"TOTAL_PAGE"=>ceil($totalPage/$limit)]);

	}

	public function getExerciseById_Controller()
	{
		$param = ['id'=>$this->input->get("id")];
		if($param['id']==null) return;
		$rs = $this->exercise_model->getExerciseById_API($param);
		$this->load->view("question.php",["question"=>$rs["question"],"answer"=>$rs["answer"]]);
	}
	
	public function policy()
	{
		$this->load->view("privacy_policy.html");
	}

	public function termCondition()
	{
		$this->load->view("terms_and_conditions.html");
	}
}
