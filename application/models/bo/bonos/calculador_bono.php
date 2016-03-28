<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class calculador_bono extends CI_Model
{
	private $usuariosRed=array();
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('/bo/bonos/bono');
		$this->load->model('/bo/bonos/condiciones_bono');
		$this->load->model('/bo/bonos/valores_bono');
		$this->load->model('/bo/bonos/activacion_bono');
	}
	
	public function getTodosLosBonos(){
		$q=$this->db->query("SELECT id FROM bono order by id");
		$bonosBaseDeDatos=$q->result();
		$todosLosBonos=array();
		foreach ($bonosBaseDeDatos as $bonoBaseDeDatos){
			$bono=new $this->bono();
			$bono->setUpBono($bonoBaseDeDatos->id);
			array_push($todosLosBonos, $bono);
		}

		return $todosLosBonos;
	}
	
	public function isActivo($bono){
		$estadoBono=$bono->getActivacionBono()->getEstado();

		if($estadoBono=='ACT')
			return true;
		return false;
	}
	
	public function isVigente($bono){
		$fechaActual=date('Y-m-d');
		
		$fechaInicio=$bono->getActivacionBono()->getInicio();
		$fechaFin=$bono->getActivacionBono()->getFin();
		
		if($fechaActual>=$fechaInicio&&$fechaActual<=$fechaFin)
			return true;
		return false;
	}

	public function isDisponibleCobrar($bono){
		
		if($this->isActivo($bono)&&$this->isVigente($bono)){
			return true;
		}
		return false;
	}

	public function isBonoBinario($tipo_bono){
		if($tipo_bono=='SI')
			return true;
		return false;
	}
	
	public function getFinSemana($date) {
		$ts = strtotime($date);
		$start = (date('w', $ts) == 0) ? $ts : strtotime('next sunday', $ts);
		return date('Y-m-d', $start);
	}
	
	public function getInicioSemana($date) {
		$ts = strtotime($date);
		$start = strtotime('last monday', $ts);
		return date('Y-m-d', $start);
	}
	
	public function getInicioQuincena($date) {
		$dateAux = new DateTime();
		
		if(date('d',strtotime($date))<=15){
			$dateAux->setDate(date('Y',strtotime($date)),date('m',strtotime($date)), 1);
			return date_format($dateAux, 'Y-m-d');
		}else {
			$dateAux->setDate(date('Y',strtotime($date)),date('m',strtotime($date)), 16);
			return date_format($dateAux, 'Y-m-d');
		}
	}

	public function getFinQuincena($date) {
		
		$dateAux = new DateTime();
		
		if(date('d',strtotime($date))<=15){
			$dateAux->setDate(date('Y',strtotime($date)),date('m',strtotime($date)), 15);
			return date_format($dateAux, 'Y-m-d');
		}else {
			return date('Y-m-t',strtotime($date));
		}
	}
	
	public function getInicioMes($date) {
		$dateAux = new DateTime();
		$dateAux->setDate(date('Y',strtotime($date)),date('m',strtotime($date)), 1);
		return date_format($dateAux, 'Y-m-d');
	}
	
	public function getFinMes($date) {
		return date('Y-m-t',strtotime($date));
	}
	
	public function getUsuariosRed($id_red) {
		$q=$this->db->query("SELECT u.id as id_afiliado,u.username,u.created,a.debajo_de,a.directo,a.lado FROM users u,afiliar a
								where (u.id=a.id_afiliado) and id_red=".$id_red);
		$datosAfiliado=$q->result();
		$this->setUsuariosRed($datosAfiliado);

		return $this->usuariosRed;
	}
	public function setUsuariosRed($usuariosRed) {
		$this->usuariosRed = $usuariosRed;
		return $this;
	}
	
}