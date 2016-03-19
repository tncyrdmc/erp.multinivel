<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class calculador_bono extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('/bo/bonos/condiciones_bono');
		$this->load->model('/bo/bonos/valores_bono');
		$this->load->model('/bo/bonos/activacion_bono');
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
}