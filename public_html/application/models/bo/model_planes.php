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
		return true;
	}
	
	function get_planes_id($id){
		$q=$this->db->query('select * from plan where id ='.$id.'');
		return $q->result();
	}
	
	function get_plan_bonos_by_id($id){
		$rangos=$this->db->query('select * from cross_plan_bonos where id_plan = '.$id.' order by `order` asc');
		return $rangos->result();
	}
	
	function eliminar_plan_bonos($condiciones){	
		$this->db->query('delete from cross_plan_bonos where id_plan='.$_POST["id"].' and id_bono not in ('.$condiciones.')');	
	}
	
	function actualizar_plan_bonos($id_plan,$bonos){
		$this->kill_cross_plan_bonos();
		$bonosPlan = array();
		$i = 0;
		foreach ($bonos as $condicion){
				$condicion = array(
						'id_plan' => $id_plan,
						'id_bono' => $condicion,
						'order' => $i
				);
				array_push($bonosPlan, $condicion);
				$i++;
		}
		foreach ($bonosPlan as $condicion) {
			$this->db->insert("cross_plan_bonos",$condicion);
		}
	}
	
	function kill_plan(){
		return $this->db->query("delete from plan where id =".$_POST["id"]) ? true : false;
		
	}
	
	function kill_cross_plan_bonos(){
		return $this->db->query("delete from cross_plan_bonos where id_plan=".$_POST["id"]) ? true : false;
	}
	
	function actualizar_plan(){
		
		//echo "dentro de modelo plan";
		
		$datos=array(
				'nombre' =>$_POST['nombre'] ,
				'descripcion' =>$_POST['descripcion']
		);
		$this->db->where('id', $_POST['id']);
		$this->db->update('plan', $datos);
		return true;
	}
	function cambiar_estado(){
		$this->db->query("update plan set estatus = '".$_POST['estado']."' where id=".$_POST["id"]);
		return true;
	}
}