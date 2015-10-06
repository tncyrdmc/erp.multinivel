<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class modelo_almacen extends CI_Model
{
	function obtenerAlmacenes(){
		$q = $this->db->query('select * from almacen');
		$almacenes = $q->result();
		return $almacenes;
	}
	
	function crear_almacen($almacen){
		$this->db->insert('almacen',$almacen);
		return mysql_insert_id();
	}
	
	function eliminar_almacen($id){
		$this->db->query("delete from almacen where id_almacen = ".$id);
	}
	
	function cambiar_estado_almacen($id,$estado) {
		$this->db->query("update almacen set estatus = '".$estado."' where id_almacen = ".$id);
	}
	
	function consultar_almacen($id){
		$q = $this->db->query('select * from almacen where id_almacen ='.$id);
		$almacenes = $q->result();
		return $almacenes;
	}
	
	function actualizar_almacen($alamacen, $id){
		$this->db->where('id_almacen', $id);
		$this->db->update('archivo', $alamacen);
	}
}