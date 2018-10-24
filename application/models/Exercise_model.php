<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exercise_model extends CI_Model
{
	private $table="tb_exercises";
	private $tb_levels ="tb_levels";
    private $categoryies=[];
    private $levels=[];
	public function __construct()
	{
        parent:: __construct();
        $this->load->model(["category_model","level_model"]);
        $this->categories = $this->category_model->getAllCategories();
        $this->levels = $this->level_model->getAllLevels();
    }
    private function IsNullOrEmptyString($txt)
    {
        return (!isset($txt) || trim($txt)==='');
    }
    public function getExercisesLatest_API($param)
    {
        $limit = 10;
        $offset = ($param["page"]-1) * $limit;
        if($offset < 0) $offset=0;

        $this->db->select("id,status,category,question_number,question,level,hits,created_at");
        $this->db->from($this->table);
        $this->db->limit($limit,$offset);
        $ex = $this->db->order_by("created_at,question_number","DESC")->get()->result_array();
        foreach ($ex as $key => $item) 
        {
            if(!array_key_exists($item['level'], $this->levels)) continue;
            if(!array_key_exists($item['category'], $this->categories)) continue;
            $ex[$key]['category'] = $this->categories[$item['category']];
            $ex[$key]['level'] = $this->levels[$item['level']];
            $question = strip_tags($item['question']);
            $ex[$key]['question'] = count($question>50)? mb_substr($question,0,50) : $question;
            $ex[$key]["question_number"] = "លំហាត់ទី ".$item["question_number"];
        }
        $total = $this->db->count_all_results($this->table);
        return ['DATA'=>$ex,'TOTAL'=>ceil($total/$limit),'PAGE'=>($offset/$limit)+1];
    }

    public function getExercisesBatchById_API($param)
    {
        $ex = [];
        $total = 0;
        try
        {
            if(count($param["ids"])<1) throw new Exception();
            $this->db->select("id,status,category,question_number,question,level,hits,created_at");
            $this->db->from($this->table);
            $this->db->where_in("id",$param["ids"]);
            $ex = $this->db->order_by("question_number","DESC")->get()->result_array();
            foreach ($ex as $key => $item) 
            {
                if(!array_key_exists($item['level'], $this->levels)) continue;
                if(!array_key_exists($item['category'], $this->categories)) continue;
                $ex[$key]['category'] = $this->categories[$item['category']];
                $ex[$key]['level'] = $this->levels[$item['level']];
                $question = strip_tags($item['question']);
                $ex[$key]['question'] = count($question>50)? mb_substr($question,0,50) : $question;
                $ex[$key]["question_number"] = "លំហាត់ទី ".$item["question_number"];
            }
            $total = $this->db->where_in("id",$param["ids"])->count_all_results($this->table);
        }
        catch(Exception $e){}
        
        return ['DATA'=>$ex,'TOTAL'=>$total,'PAGE'=>0];
    }

    public function getExerciseById_API($param)
    {
    	$result = [];
        $result = $this->db->select("*")
    	->from($this->table)
    	->where("id",$param["id"])
    	->get()
    	->result_array();
        
    	//update hits count
    	$this->db->set('hits', '`hits`+1',FALSE);
		$this->db->where('id', $param["id"]);
		$this->db->update($this->table);

		if(count($result) > 0) return $result[0];
        return $result;
    }

    public function getExercisesByCategoryId_API($param)
    {
        $limit = 10;
        $offset = ($param["page"]-1) * $limit;
        if($offset < 0) $offset=0;

        $this->db->select("id,status,category,question_number,question,level");
        $this->db->from($this->table);
        $this->db->limit($limit,$offset);
        $this->db->where("category",$param["cate_id"]);
        $ex = $this->db->order_by("question_number","DESC")->get()->result_array();
        foreach ($ex as $key => $item) 
        {
            if(!array_key_exists($item['level'], $this->levels)) continue;
            if(!array_key_exists($item['category'], $this->categories)) continue;
            $ex[$key]['category'] = $this->categories[$item['category']];
            $ex[$key]['level'] = $this->levels[$item['level']];
            $question = strip_tags($item['question']);
            $ex[$key]['question'] = count($question>50)? mb_substr($question,0,50) : $question;
        }
        $total = $this->db->where("category",$param["cate_id"])->count_all_results($this->table);
        return ['DATA'=>$ex,'TOTAL'=>$total];
    }

    public function getExcerciesByFilter_API($param)
    {
        $ex = [];
        $total = 0;
        $limit = 10;
        $offset = ($param["page"]-1) * $limit;
        if($offset < 0) $offset=0;
        try
        {
            if($this->IsNullOrEmptyString($param['level'])
                && $this->IsNullOrEmptyString($param['cate'])
                && $this->IsNullOrEmptyString($param['txt'])
                )
            {
                throw new Exception();
            }

            $this->db->select("id,status,category,question_number,question,level,hits,created_at");
            if(!$this->IsNullOrEmptyString($param['level']))
            {
                $this->db->where('level',$param['level']);
            }
            if(!$this->IsNullOrEmptyString($param['cate']))
            {
                $this->db->where('category',$param['cate']);    
            }
            if(!$this->IsNullOrEmptyString($param['txt']))
            {
                $this->db->like('question',$param['txt']);
                $this->db->or_like('answer',$param['txt']);
            }
            
            $this->db->limit($limit,$offset);
            $ex = $this->db->order_by('created_at,question_number',"DESC")->get($this->table)->result_array();
            
            foreach ($ex as $key => $item) 
            {
                if(!array_key_exists($item['level'], $this->levels)) continue;
                if(!array_key_exists($item['category'], $this->categories)) continue;
                $ex[$key]['category'] = $this->categories[$item['category']];
                $ex[$key]['level'] = $this->levels[$item['level']];
                $question = strip_tags($item['question']);
                $ex[$key]['question'] = count($question>50)? mb_substr($question,0,50) : $question;
                $ex[$key]["question_number"] = "លំហាត់ទី ".$item["question_number"];
            }

            if(!$this->IsNullOrEmptyString($param['level']))
            {
                $this->db->where('level',$param['level']);
            }
            if(!$this->IsNullOrEmptyString($param['cate']))
            {
                $this->db->where('category',$param['cate']);    
            }
            if(!$this->IsNullOrEmptyString($param['txt']))
            {
                $this->db->like('question',$param['txt']);
                $this->db->or_like('answer',$param['txt']);
            }
            $total = $this->db->count_all_results($this->table);
        }catch(Exception $e){}
        sleep(1);
        return ['DATA'=>$ex,'TOTAL'=>ceil($total/$limit),'PAGE'=>($offset/$limit)+1];
    }

}