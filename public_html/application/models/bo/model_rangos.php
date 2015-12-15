<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class model_rangos extends CI_Model
{

function get_tipo_rango(){

		$q=$this->db->query("select * from cat_tipo_rango where estatus='ACT'");
		return $q->result();
}

function get_tipo_rango_not_in($id){
//$r="";	
//$r+=$id;
/*for ($i=0;$i<count($id);$i++) {
	$r+="".$id[$i];
	if(!count($id) == ($i+1)){

		$r+=",";

	}
}*/
		$q=$this->db->query("select * from cat_tipo_rango where id not in (".$id.")");
			//$r+=",";


		return $q->result();
}
function ingresar_rango($nombre,$desc){

	$dato_rango=array(
		"name"=>$nombre,
		"descripcion"=>$desc
		);
	$this->db->insert("cat_rango",$dato_rango);
	$q=$this->get_rango_max();
	return $q->result();
}

function get_rango_max(){

	$g=$this->db->query("select max(id_rango) from cat_rango");
	return $g->result();
}
function ingresar_tipo_rango($id_tipos,$valores){
/*for ($i=0;$i<$_POST['id_tipos'];$i++) {
		$dato_cross=array(
		"id_rango"=>$_POST['id'],
		"id_tipo_rango"=>$_POST['id_tipos'][$i],
		"valor"=>$_POST['valores'][$i]
		);*/
$ObtenerMax=$this->get_rango_max()+0.0;

$dato_cross=array(
		"id_rango"=>$ObtenerMax,
		"id_tipo_rango"=>$id_tipos,
		"valor"=>$valores
		);
	$this->db->insert("cross_rango_tipos",$dato_cross);


}
/*function prueba_tipo_rango($datos_rango){

	$this->db->insert("cat_rango",$datos_rango);
	$q=$this->get_rango_max();
 return $g->result();
}

prueba_tipo_rango2($datos_cross){
$this->db->insert("cross_rango_tipos",$datos_cross);

}*/


}