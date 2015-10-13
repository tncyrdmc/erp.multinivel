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
	
	function all_cedi(){
		$q = $this->db->query("SELECT p.id_cedi,p.nombre,p.descripcion,p.ciudad,p.direccion,p.telefono,p.estatus,c.Name
                               FROM cedi p ,City c where p.ciudad = c.ID ");
	    return  $q->result();
	}
	
	function cambiar_estado_cedi($id,$estado){
		$this->db->query("update cedi set estatus = '".$estado."' where id_cedi = ".$id);
		
	}
	function eliminar_cedi($id){
		$this->db->query("delete from cedi where id_cedi = ".$id);
	}
	function consultar_cedi($id){
		$q = $this->db->query('select * from cedi where id_cedi ='.$id);
		$cedi = $q->result();
		return $cedi;
	}
	function consultar_ciudades($city){
		$q = $this->db->query("SELECT * FROM City where CountryCode =(Select CountryCode from City where ID = '".$city." ') ");
		$ciudades = $q->result();
		return $ciudades;
	}
	
	function consultar_PaisCiudad($city){
		$q = $this->db->query("Select * from City where ID = ".$city);
		$ciudades = $q->result();
		return $ciudades;
	}
	function actualizar_cedi($cedi, $id){
		$this->db->update('cedi', $cedi, array('id_cedi' => $id));
	}
}

?>

