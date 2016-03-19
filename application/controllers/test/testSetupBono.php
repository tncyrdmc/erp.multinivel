<?php
class testSetupBono extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('unit_test');
		$this->load->model('/bo/bonos/condiciones_bono');
		$this->load->model('/bo/bonos/valores_bono');
		$this->load->model('/bo/bonos/activacion_bono');
		$this->load->model('/bo/bonos/bono');

	}
	
	public function index(){
		
		$this->testSetValoresRango();
		$this->testSetValoresCondicionBono();
		$this->testSetValoresValoresBono();
		$this->testSetValoresActivacionBono();
		$this->testSetValoresBonosCondicionesBono();
		$this->testSetValoresBonosValoresBono();
		$this->testSetValoresBonosActivacionBono();
		$this->testSetBono();
	}
	
	public function testSetValoresRango(){
		$condicionBono=$this->condiciones_bono;
		
		$id_rango=15;
		$tipo_rango=4;
		$valor=5;
		$condicion_red='RED';
		$nivel_red=0;
		
		$condicionBono->setRango($id_rango,$tipo_rango,$valor,$condicion_red,$nivel_red);
		
		echo $this->unit->run(15,$condicionBono->getRango()["id_rango"], 'Test set Id Rango');
		echo $this->unit->run(4,$condicionBono->getRango()["tipo_rango"], 'Test set tipo_rango');
		echo $this->unit->run(5,$condicionBono->getRango()["valor"], 'Test set valor');
		echo $this->unit->run('RED',$condicionBono->getRango()["condicion_red"], 'Test condicion_red');
		echo $this->unit->run(0,$condicionBono->getRango()["nivel_red"], 'Test nivel_red');

	}
	
	public function testSetValoresCondicionBono(){
		$condicionBono=$this->condiciones_bono;

		$id_bono=85;
		$id_red=26;
		$condicion_1=1;
		$condicion_2=131;
		
		$id_rango=19;
		$tipo_rango=6;
		$valor=8;
		$condicion_red='DIRECTOS';
		$nivel_red=3;
	
		$condicionBono->setRango($id_rango,$tipo_rango,$valor,$condicion_red,$nivel_red);
		
		
		echo $this->unit->run(19,$condicionBono->getRango()["id_rango"], 'Test set Id Rango');
		echo $this->unit->run(6,$condicionBono->getRango()["tipo_rango"], 'Test set tipo_rango');
		echo $this->unit->run(8,$condicionBono->getRango()["valor"], 'Test set valor');
		echo $this->unit->run('DIRECTOS',$condicionBono->getRango()["condicion_red"], 'Test condicion_red');
		echo $this->unit->run(3,$condicionBono->getRango()["nivel_red"], 'Test nivel_red');
		
		$condicionBono->setIdBono($id_bono);
		$condicionBono->setIdRed($id_red);
		$condicionBono->setCondicionBono1($condicion_1);
		$condicionBono->setCondicionBono2($condicion_2);
		
		echo $this->unit->run(85,$condicionBono->getIdBono(), 'Test set Id Bono');
		echo $this->unit->run(26,$condicionBono->getIdRed(), 'Test set Id Red');
		echo $this->unit->run(1,$condicionBono->getCondicionBono1(), 'Test set Condicion 1');
		echo $this->unit->run(131,$condicionBono->getCondicionBono2(), 'Test set Condicion 2');
	}
	
	public function testSetValoresValoresBono(){
		$valoresBono=$this->valores_bono;

		$id_bono=15;
		$nivel=4;
		$valor=5;
		
		$valoresBono->setIdBono($id_bono);
		$valoresBono->setNivel($nivel);
		$valoresBono->setValor($valor);

		echo $this->unit->run(15,$valoresBono->getIdBono(), 'Test set Id Bono');
		echo $this->unit->run(4,$valoresBono->getNivel(), 'Test set Nivel');
		echo $this->unit->run(5,$valoresBono->getValor(), 'Test set Valor');

	}
	
	public function testSetValoresActivacionBono(){
		$activacionBono=$this->activacion_bono;
		
		$id_bono=15;
		$inicio='2016-03-01';
		$fin='2026-03-01';
		$mes_desde_afiliacion_afiliado=0;
		$mes_desde_activacion_afiliado=0;
		$estado='ACT';
		$frecuencia='MES';
		
		$activacionBono->setIdBono($id_bono);
		$activacionBono->setInicio($inicio);
		$activacionBono->setFin($fin);
		$activacionBono->setMesDesdeAfiliacionAfiliado($mes_desde_afiliacion_afiliado);
		$activacionBono->setMesDesdeActivacionAfiliado($mes_desde_activacion_afiliado);
		$activacionBono->setEstado($estado);
		$activacionBono->setFrecuencia($frecuencia);
		
		echo $this->unit->run(15,$activacionBono->getIdBono(), 'Test set Id Bono');
		echo $this->unit->run('2016-03-01',$activacionBono->getInicio(), 'Test set Inicio');
		echo $this->unit->run('2026-03-01',$activacionBono->getFin(), 'Test set Fin');
		echo $this->unit->run(0,$activacionBono->getMesDesdeAfiliacionAfiliado(), 'Test set MesDesdeAfiliacionAfiliado');
		echo $this->unit->run(0,$activacionBono->getMesDesdeActivacionAfiliado(), 'Test set MesDesdeActivacionAfiliado');
		echo $this->unit->run('ACT',$activacionBono->getEstado(), 'Test set Estado');
		echo $this->unit->run('MES',$activacionBono->getFrecuencia(), 'Test set Frecuencia');
	}
	
	public function testSetValoresBonosCondicionesBono(){
		$bono=$this->bono;
		
		$condicionBono=$this->condiciones_bono;
		
		$id_bono=85;
		$id_red=26;
		$condicion_1=1;
		$condicion_2=131;
		
		$id_rango=19;
		$tipo_rango=6;
		$valor=8;
		$condicion_red='DIRECTOS';
		$nivel_red=3;
		
		$condicionBono->setRango($id_rango,$tipo_rango,$valor,$condicion_red,$nivel_red);
		
		$bono->setCondiciones($id_bono,$condicionBono->getRango(),$id_red,$condicion_1,$condicion_2);

		echo $this->unit->run(85,$bono->getCondiciones()["id_bono"], 'Test set Id bono');
		
		echo $this->unit->run(19,$bono->getCondiciones()["rango"]["id_rango"], 'Test set Rango');
		echo $this->unit->run(6,$bono->getCondiciones()["rango"]["tipo_rango"], 'Test set Tipo Rango');
		echo $this->unit->run(8,$bono->getCondiciones()["rango"]["valor"], 'Test set valor');
		echo $this->unit->run('DIRECTOS',$bono->getCondiciones()["rango"]["condicion_red"], 'Test set condicion_red');
		echo $this->unit->run(3,$bono->getCondiciones()["rango"]["nivel_red"], 'Test set nivel_red');
		
		
		echo $this->unit->run(26,$bono->getCondiciones()["id_red"], 'Test set Id red');
		echo $this->unit->run(1,$bono->getCondiciones()["condicion_1"], 'Test set condicion_1');
		echo $this->unit->run(131,$bono->getCondiciones()["condicion_2"], 'Test set condicion_2');
	}
	
	public function testSetValoresBonosValoresBono(){
		$bono=$this->bono;
		
		$id_bono=15;
		$nivel=4;
		$valor=5;
		
		$bono->setValores($id_bono,$nivel,$valor);
		
		echo $this->unit->run(15,$bono->getValores()["id_bono"], 'Test set Id bono');
		echo $this->unit->run(4,$bono->getValores()["nivel"], 'Test set nivel');
		echo $this->unit->run(5,$bono->getValores()["valor"], 'Test set valor');
	}
	
	public function testSetValoresBonosActivacionBono(){
		$bono=$this->bono;
	
		$id_bono=15;
		$inicio='2016-03-01';
		$fin='2026-03-01';
		$mes_desde_afiliacion_afiliado=0;
		$mes_desde_activacion_afiliado=0;
		$estado='ACT';
		$frecuencia='MES';
	
		$bono->setActivacion($id_bono,$inicio,$fin,$mes_desde_afiliacion_afiliado,$mes_desde_activacion_afiliado,
				$estado,$frecuencia);
	
		echo $this->unit->run(15,$bono->getActivacion()["id_bono"], 'Test set Id bono');
		echo $this->unit->run('2016-03-01',$bono->getActivacion()["inicio"], 'Test set nivel');
		echo $this->unit->run('2026-03-01',$bono->getActivacion()["fin"], 'Test set valor');
		echo $this->unit->run(0,$bono->getActivacion()["mes_desde_afiliacion_afiliado"], 'Test set mes_desde_afiliacion_afiliado');
		echo $this->unit->run(0,$bono->getActivacion()["mes_desde_activacion_afiliado"], 'Test set mes_desde_activacion_afiliado');
		echo $this->unit->run('ACT',$bono->getActivacion()["estado"], 'Test set estado');
		echo $this->unit->run('MES',$bono->getActivacion()["frecuencia"], 'Test set frecuencia');

	}

	public function testSetBono(){
		$bono=$this->bono;
		
		$id_bono=20;
		$nombre="Asociado";
		$descripcion="Descripcion Asociado";
		
		$bono->setId($id_bono);
		$bono->setNombre($nombre);
		$bono->setDescripcion($descripcion);
		
		echo $this->unit->run(20,$bono->getId(), 'Test set Id bono');
		echo $this->unit->run("Asociado",$bono->getNombre(), 'Test set Nombre');
		echo $this->unit->run("Descripcion Asociado",$bono->getDescripcion(), 'Test set Descripcion');
		
	}
}