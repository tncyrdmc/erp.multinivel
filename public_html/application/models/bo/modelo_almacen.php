<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class modelo_almacen extends CI_Model
{
	function obtenerAlmacenes(){
		$q = $this->db->query("SELECT p.id_cedi,p.nombre,p.descripcion,p.ciudad,p.direccion,p.telefono,p.estatus,c.Name
                               FROM cedi p ,City c where p.ciudad = c.ID and p.tipo= 'A' ");
	    return  $q->result();
		
	}
	
	function crear_almacen($almacen){
		$this->db->insert('cedi',$almacen);
		return mysql_insert_id();
	}
	
	function eliminar_almacen($id){
		$this->db->query("delete from cedi where id_cedi = ".$id);
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
		$this->db->update('almacen', $alamacen, array('id_almacen' => $id));
	}
}