<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class modelo_cedi extends CI_Model
{
	function crear_cedi($cedi){
		$this->db->insert('cedi',$cedi);
		return mysql_insert_id();
	}
	function buscarCiudad($id){
		$q = $this->db->query('select * from City where CountryCode='.$id);
		$ciudades = $q->result();
		return $ciudades;
	}
	
	function nuevaCiudad(){
		
	}
	
}

?>

