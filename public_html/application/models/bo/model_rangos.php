<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class model_rangos extends CI_Model
{

function get_tipo_rango(){

		$q=$this->db->query("select * from cat_tipo_rango");
		return $q->result();
}

function get_tipo_rango_not_in($id){
	$r="";

for ($i=0;$i<count($id);$i++) {
	$r+="".$id[$i];
	if(!count($id) == ($i+1)){

		$r+=",";

	}
}
		$q=$this->db->query("select * from cat_tipo_rango where id not in (".$r.")");
	
		return $q->result();
}
function ingresar_rango(){

	$dato_rango=array(
		"name"=>$_POST['nombre'],
		"descripcion"=>$_POST['desc']
		);
	$this->db->insert("cat_rango",$dato_rango);
	$q=$this->get_rango_max();
	return $q->maximo;
}

function get_rango_max(){

	$g=$this->db->query("select max(id) maximo from cat_rango");
	return $g->result();
}
function ingresar_tipo_rango(){
for ($i=0;$i<$_POST['id_tipos'];$i++) {
		$dato_cross=array(
		"id_rango"=>$_POST['id'],
		"id_tipo_rango"=>$_POST['id_tipos'][$i],
		"valor"=>$_POST['valores'][$i]
		);
	$this->db->insert("cat_rango",$dato_rango);
}

}


}