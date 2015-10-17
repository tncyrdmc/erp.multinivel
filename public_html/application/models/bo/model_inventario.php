<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//header('Content-Type: text/html; charset-utf-8');
//header('Content-Type: text/html; charset=ISO-8859-1');
class model_inventario extends CI_Model
{
	function setDocumento()
	{
		$dato_documento=array(
				"nombre"     => $_POST['nombre'],
				"estatus"     => 'ACT',
            );
             $this->db->insert("documento_inventario",$dato_documento);
	}
	
	function getAlldocumento(){
		$q=$this->db->query('select * from documento_inventario ');
		return $q->result();
	}
	function getAlmacenesCedi(){
		$q=$this->db->query('select * from cedi ');
		return $q->result();
	}
	function updateEstatusdocumento(){
		$datos = array(
				'estatus' => $_POST['estado'],
				
		);
		$this->db->where('id_doc', $_POST['id']);
		$this->db->update('documento_inventario', $datos);
	}
   function kill_Documento(){
      	$q=$this->db->query('delete from documento_inventario where id_doc ='.$_POST['id']);
   }
   
   function getDocumento($id){
       	$q=$this->db->query('select * from documento_inventario where id_doc ='.$_POST['id']);
     	return $q->result();
   }
   
   function getProductos(){
   	$q=$this->db->query('select * from producto  ');
   	return $q->result();
   }
   
   function update_Documento(){
   	$datos = array(
   			'nombre' => $_POST['nombre'],
   	
   	);
   	$this->db->where('id_doc', $_POST['id']);
   	$this->db->update('documento_inventario', $datos);
  }
	function update_bloqueados(){
	   	$this->db->query('update inventario set bloqueados = '.$_POST['bloqueados'].' where id_almacen = '.$_POST['id_cedi'].' and id_mercancia = '.$_POST['mercancia'].'');
  	}
}
