<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class model_planes extends CI_Model
{
	
	function get_bonos_plan(){
	
		$q=$this->db->query("select * from bono where estatus='ACT' and plan='SI'");
		return $q->result();
	}
	
	function get_planes(){
	
		$q=$this->db->query("select * from plan");
		return $q->result();
	}
	
	function get_cross_plan_bonos(){
	
		$q=$this->db->query("select * from cross_plan_bonos order by id_plan , `order` asc");
		return $q->result();
	}
	
	function ingresar_plan(){
		$plan = array(
				'nombre' => $_POST['nombre'],
				'descripcion' => $_POST['desc'],
				'estatus' => 'ACT'
		);
	
		$this->db->insert("plan",$plan);
		$q=$this->get_plan_max();
		return $q[0]->max;
	}
	
	function get_plan_max(){
	
		$g=$this->db->query("select max(id) as max from plan");
		return $g->result();
	}
	
	function ingresar_plan_bonos($id,$bonos){
	
		$bonosPlan = array();
		$i = 0;
		foreach ($bonos as $bono){
				$bono = array(
						'id_plan' => intval($id),
						'id_bono' => intval($bono),
						'order' => $i,
				);
				array_push($bonosPlan, $bono);
				$i = $i + 1;
		}
		foreach ($bonosPlan as $bonoPlan) {
			$this->db->insert("cross_plan_bonos",$bonoPlan);
		}
	}
}