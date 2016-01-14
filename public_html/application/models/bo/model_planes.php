<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class model_planes extends CI_Model
{
	
	function get_bonos_plan(){
	
		$q=$this->db->query("select * from bono where estatus='ACT' and plan='SI'");
		return $q->result();
	}
	
}