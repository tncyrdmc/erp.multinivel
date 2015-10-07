<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//header('Content-Type: text/html; charset-utf-8');
//header('Content-Type: text/html; charset=ISO-8859-1');
class modelo_proveedor_mensajeria extends CI_Model
{
	function obtenerProveedores(){
		$q = $this->db->query('select pm.id, pm.nombre_empresa, pm.razon_social, c.Name as pais, pm.direccion, pm.direccion_web, pm.estatus
				from proveedor_mensajeria pm, Country c where pm.id_pais = c.Code');
		$almacenes = $q->result();
		return $almacenes;
	}
	
	function crear_proveedor_mensajeria($proveedor){
		$this->db->insert('proveedor_mensajeria',$proveedor);
		return mysql_insert_id();
	}
	
	function crear_contacto_mensajeria($contacto){
		$this->db->insert('proveedor_contacto',$contacto);
		
	}
	
	function crear_tarifa_mensajeria($tarifa){
		$this->db->insert('proveedor_tarifas',$tarifa);
		return mysql_insert_id();
	}
	
	function eliminar_proveedor_mensajeria($id){
		$this->db->query("delete from proveedor_mensajeria where id = ".$id);
		$this->db->query("delete from proveedor_contacto where id_proveedor = ".$id);
		$this->db->query("delete from proveedor_tarifas where id_proveedor = ".$id);
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
