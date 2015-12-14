<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class model_rangos extends CI_Model
{

function get_tipo_rango(){

		$q=$this->db->query("select * from cat_tipo_rango");
		return $q->result();
}

function get_tipo_rango_not_in($id){

		$q=$this->db->query("select * from cat_tipo_rango where id not in (".$id.")");
		return $q->result();
}


}