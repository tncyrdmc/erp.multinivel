<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class modelo_cedi extends CI_Model
{
	function crear_cedi($cedi){
		$this->db->insert('cedi',$cedi);
		return mysql_insert_id();
	}
	
	
	function nuevaCiudad(){
		$ciudad = array (
				"Name" => $_POST ['ciudad'],
				"CountryCode" => $_POST ['pais'],
				"District" => $_POST ['departamento']
		);
		$this->db->insert ( "City", $ciudad );
	}
	
}

?>

