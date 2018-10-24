<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Level_model extends CI_Model
{
	private $table = "tb_levels";
	public function __construct()
	{
		parent::__construct();
	}

	public function getAllLevels()
	{
		$levels = [];
		foreach ($this->db->get($this->table)->result_array() as $item) 
		{
			$levels[$item['id']] = $item;
		}
		return $levels;
	}

	public function getLevels_API()
    {
        $rs = $this->db->get($this->table)->result_array();
        return ["DATA"=>$rs];
    }
	/*public function getLevelsByCategory_API()
	{
		$cate_id = $this->uri->segment(4,0);

		$this->db->distinct("level");
		$this->db->select("level,tb_levels.id,level_name,level_image,category");
		$this->db->from($this->table);
		$this->db->join($this->table_exercise,"level = tb_levels.id");
		$this->db->where("category",$cate_id);
		$this->db->order_by("level","ASC");
		return $this->db->get()->result_array();
	}*/
}