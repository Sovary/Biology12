<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model
{

	private $table = "tb_categories";
	public function __construct()
	{
        parent:: __construct();
    }

    public function getAllCategories()
    {
        $categories = [];
        foreach ($this->db->where("ordering !=",0)->get($this->table)->result_array() as $item)
        {
            $categories[$item['id']] = $item;
        }
        return $categories;
    }

    public function getCategories_API()
    {
        $rs = $this->db->where("ordering !=",0)->get($this->table)->result_array();
        return ["DATA"=>$rs];
    }
    
}