<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class modelo_cedi extends CI_Model
{
	function crear_cedi($cedi){
		$this->db->insert('cedi',$cedi);
		return mysql_insert_id();
	}
	
	function consultar_departamento_activo($city){
		$q = $this->db->query("select * from estate where id=(Select id_estate from City where ID =  '".$city." ')");
		$departamento = $q->result();
		return $departamento;
	}
	
	function consultar_ciudad_actual($city){
		$q = $this->db->query("select * from City where ID = ".$city );
		$ciudades = $q->result();
		return $ciudades;
		
	}
	function nuevaCiudad(){
		$ciudad = array (
				"Name" => $_POST ['ciudad'],
				"CountryCode" => $_POST ['pais'],
				"District" => $_POST ['departamento']
		);
		$this->db->insert ( "City", $ciudad );
	}
	function  consultar_departamento($city){
		$q = $this->db->query("select * from estate where id_pais=(Select CountryCode from City where ID =  '".$city." ')");
		$departamento = $q->result();
		return $departamento;
	}
	function all_cedi(){
		$q = $this->db->query("SELECT p.id_cedi,p.nombre,p.descripcion,p.ciudad,p.direccion,p.telefono,p.estatus,c.Name
                               FROM cedi p ,City c where p.ciudad = c.ID and p.tipo= 'C' ");
	    return  $q->result();
	}
	
	function get_mercancia_cedi($id_cedi){
		$q = $this->db->query("SELECT p.id, p.nombre FROM inventario i, producto p where i.id_mercancia = p.id and i.id_almacen = '".$id_cedi."'");
	    return  $q->result();
	}
	
	function get_cant_disp_y_bloq_cedi($id_prod, $id_cedi){
		$q = $this->db->query("SELECT i.cantidad, i.bloqueados FROM inventario i, producto p where i.id_mercancia = '".$id_prod."' and i.id_mercancia = p.id and i.id_almacen = '".$id_cedi."'");
	    return  $q->result();
	}
	
	function all(){
		$q = $this->db->query("SELECT p.id_cedi,p.nombre,p.descripcion,p.ciudad,p.direccion,p.telefono,p.estatus,c.Name, co.Name pais

FROM cedi p , City c, Country co where p.ciudad = c.ID and c.CountryCode = co.Code");
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
		$q = $this->db->query("select * from City where id_estate =(Select id_estate from City where ID =  '".$city." ') ");
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

