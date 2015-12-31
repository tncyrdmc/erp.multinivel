<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class model_bonos extends CI_Model
{

public function setUp($nombre,$descripcion,$inicio,$fin,$mes_desde_afiliacion,$mes_desde_activacion,$frecuencia,$estatus,$plan){

	$bono = array(
			'nombre' => $nombre,
			'descripcion' => $descripcion,
			'inicio' => $inicio,
			'fin' => $fin,
			'mes_desde_afiliacion' => $mes_desde_afiliacion,
			'mes_desde_activacion' => $mes_desde_activacion,
			'frecuencia' => $frecuencia,
			'plan' => $plan,
			'estatus' => $estatus,
	);
	return $bono;
}

public function setUpValoresBones($idBono,$nivel,$valor){

	$bono_valores = array(
			'id_bono' => $idBono,
			'nivel' => $nivel,
			'valor' => $valor,
	);
	return $bono_valores;
}

public function setUpCondicion($idBono,$idRango,$idTipoRango,$red,$condicion1,$condicion2){
	$rango=$this->get_rangos_id_tipo($idRango, $idTipoRango);
	$bonoCondiciones = array(
			'id_bono' => $idBono,
			'id_rango' => $idRango,
			'id_tipo_rango' => $idTipoRango,
			'condicion_rango' => $rango[0]->valor,
			'id_red' => $red,
			'condicion1' => $condicion1,
			'condicion2' => $condicion2,
	);
	return $bonoCondiciones;
}

function insert_bono($bono){
	$this->db->insert("bono",$bono);
	$q=$this->db->query("SELECT id FROM bono order by id desc  limit 0,1 ");
	$q=$q->result();
	return $q[0]->id;
}

function insert_bono_valor_niveles($valoresBono){
	$this->db->insert("cat_bono_valor_nivel",$valoresBono);

}

function insert_condicion_bono($condicion){
	$this->db->insert("cat_bono_condicion",$condicion);
}

function get_rangos(){

		$q=$this->db->query("SELECT cr.id_rango as id_rango,cr.nombre as nombre_rango,cr.descripcion as descripcion,
								ct.id as tipo_rango,ct.nombre as nombre_tipo_rango,crt.valor as valor,cr.estatus
								FROM cat_rango cr,cat_tipo_rango ct,cross_rango_tipos crt
								where (cr.id_rango=crt.id_rango)
								and (ct.id=crt.id_tipo_rango)and cr.estatus='ACT'
								group by id_rango ");
		return $q->result();
}
function get_rangos_id($id){

	$q=$this->db->query("SELECT cr.id_rango as id_rango,cr.nombre as nombre_rango,cr.descripcion as descripcion,
								ct.id as tipo_rango,ct.nombre as nombre_tipo_rango,crt.valor as valor,cr.estatus
								FROM cat_rango cr,cat_tipo_rango ct,cross_rango_tipos crt
								where (cr.id_rango=crt.id_rango)
								and (ct.id=crt.id_tipo_rango)and cr.estatus='ACT'
								and(cr.id_rango=".$id.") ");
	return $q->result();
}

function get_rangos_id_tipo($id,$tipoRango){

	$q=$this->db->query("SELECT cr.id_rango as id_rango,cr.nombre as nombre_rango,cr.descripcion as descripcion,
								ct.id as tipo_rango,ct.nombre as nombre_tipo_rango,crt.valor as valor,cr.estatus
								FROM cat_rango cr,cat_tipo_rango ct,cross_rango_tipos crt
								where (cr.id_rango=crt.id_rango)
								and (ct.id=crt.id_tipo_rango)and cr.estatus='ACT'
								and(cr.id_rango=".$id.") and(ct.id=".$tipoRango.")");
	return $q->result();
}

function get_mercancia_tipos(){

	$q=$this->db->query("SELECT * FROM cat_tipo_mercancia;");
	return $q->result();
}
function get_productos_red($idRed){
	$q=$this->db->query("select M.id,P.nombre, CTM.descripcion, TR.nombre red,C.Name
							from mercancia M, producto P, cat_tipo_mercancia CTM, 
							cat_grupo_producto CGP, tipo_red TR, Country C
							where M.sku = P.id and CTM.id = M.id_tipo_mercancia 
							and M.id_tipo_mercancia=1 
							and P.id_grupo = CGP.id_grupo 
							and CGP.id_red = TR.id 
							and C.Code = M.pais
							and TR.id=".$idRed."");
	return $q->result();
}
function get_servicios_red($idRed){
	$q=$this->db->query("select M.id, M.sku, M.fecha_alta, M.real, M.costo, M.costo_publico, M.estatus , S.nombre, CI.url, CTM.descripcion, TR.nombre red, M.pais, C.Name, C.Code2
							from mercancia M, servicio S, cat_tipo_mercancia CTM, cat_img CI, cross_merc_img CMI, tipo_red TR, cat_grupo_producto CGP, Country C
							where M.sku = S.id and CTM.id = M.id_tipo_mercancia and M.id_tipo_mercancia=2 and CI.id_img = CMI.id_cat_imagen and M.id = CMI.id_mercancia and CGP.id_grupo = S.id_red and CGP.id_red = TR.id and C.Code = M.pais
							and TR.id=".$idRed."");
	return $q->result();
}
function get_combinados_red($idRed){
	$q=$this->db->query("select M.id,C.nombre, CTM.descripcion, TR.nombre red,CO.Name
							 from mercancia M, combinado C, cat_tipo_mercancia CTM, cat_img CI, cross_merc_img CMI, 
								  tipo_red TR, cat_grupo_producto CGP, Country CO
							
							where M.sku = C.id and CTM.id = M.id_tipo_mercancia and M.id_tipo_mercancia=3 and 
							CI.id_img = CMI.id_cat_imagen and M.id = CMI.id_mercancia and CGP.id_grupo = C.id_red and
							CGP.id_red = TR.id and CO.Code = M.pais
							and TR.id=".$idRed."");
	return $q->result();
}
function get_paquetes_red($idRed){
	$q=$this->db->query("select M.id,P.nombre, CTM.descripcion, TR.nombre red,CO.Name
						from mercancia M, paquete_inscripcion P, cat_tipo_mercancia CTM, cat_img CI, cross_merc_img CMI, tipo_red TR, cat_grupo_producto CGP, Country CO
						where M.sku = P.id_paquete and CTM.id = M.id_tipo_mercancia and M.id_tipo_mercancia= 4 
						and CI.id_img = CMI.id_cat_imagen and M.id = CMI.id_mercancia and CGP.id_grupo = P.id_red and
						CGP.id_red = TR.id and CO.Code = M.pais
							and TR.id=".$idRed."");
	return $q->result();
}

	
}