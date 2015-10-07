<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//header('Content-Type: text/html; charset-utf-8');
//header('Content-Type: text/html; charset=ISO-8859-1');
class modelo_proveedor_mensajeria extends CI_Model
{
	function obtenerProveedores(){
		$q = $this->db->query('select * from proveedor_mensajeria');
		$almacenes = $q->result();
		return $almacenes;
	}
	
	function crear_proveedor($proveedor){
		$this->db->insert('proveedor_mensajeria',$proveedor);
		return mysql_insert_id();
	}
	
	function eliminar_proveedor_mensajeria($id){
		$this->db->query("delete from proveedor_mensajeria where id = ".$id);
	}
	
	function cambiar_estado_proveedor_mensajeria($id,$estado) {
		$this->db->query("update proveedor_mensajeria set estatus = '".$estado."' where id = ".$id);
	}
	
	function consultar_proveedor_mensajeria($id){
		$q = $this->db->query('select * from proveedor_mensajeria where id ='.$id);
		$almacenes = $q->result();
		return $almacenes;
	}
	
	function actualizar_almacen($alamacen, $id){
		$this->db->update('almacen', $alamacen, array('id_almacen' => $id));
	}
}
