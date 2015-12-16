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
function ingresar_tipo_rango($id_rango,$valores, $id_tipo){

$dato_cross=array(
		"id_rango"=>$id_rango,
		"id_tipo_rango"=>$id_tipo,
		"valor"=>$valores
		);
	$this->db->insert("cross_rango_tipos",$dato_cross);


}

function ingresar_tipo_rango_afil($id_rango,$valores, $id_tipo){

$dato_cross=array(
		"id_rango"=>$id_rango,
		"id_tipo_rango"=>$id_tipo,
		"valor"=>$valores
		);
	$this->db->insert("cross_rango_tipos",$dato_cross);


}

function ingresar_tipo_rango_pun($id_rango,$valores, $id_tipo){

$dato_cross=array(
		"id_rango"=>$id_rango,
		"id_tipo_rango"=>$id_tipo,
		"valor"=>$valores
		);
	$this->db->insert("cross_rango_tipos",$dato_cross);


}

function get_cat_rangos(){

			$q=$this->db->query("select * from cat_rango");
		return $q->result();
}
/*function prueba_tipo_rango($datos_rango){

	$this->db->insert("cat_rango",$datos_rango);
	$q=$this->get_rango_max();
 return $g->result();
}

prueba_tipo_rango2($datos_cross){
$this->db->insert("cross_rango_tipos",$datos_cross);

}*/

function get_rangos_id($id){


	$rangos=$this->db->query('select * from cat_rango where id_rango='.$id.'');
	return $rangos->result();
}

function actualizar_rangos(){

	$datos=array('name' =>$_POST['nombre'] ,
				 'descripcion' =>$_POST['descripcion'] 
	 );

		$this->db->where('id_rango', $_POST['id']);
		$this->db->update('cat_rango', $datos);
		
		return true;
}

function kill_rangos(){

	$this->db->query("delete from cat_rango where id_rango=".$_POST["id"]);
}

function cambiar_estado_rangos(){
	$this->db->query("update cat_rango set estatus = '".$_POST['estado']."' where id_rango=".$_POST["id"]);
		return true;

}


}