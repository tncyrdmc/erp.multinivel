<?php
class testSetupMercanciaBaseDeDatos extends CI_Controller {


	public function __construct() {
		parent::__construct();
		$this->load->library('unit_test');
		$this->load->model('/bo/bonos/mercancia');

	}
	
	public function index(){
		$this->Before();
		$this->testSetValoresMercancia();
		$this->testSetValoresMercanciaBaseDeDatos();
		$this->after();
	}
	
	private function Before(){
		$this->mercancia->eliminarMercancias();
		
		$servicios=2;
		
		$datosMercancia = array(
				'id_mercancia' => 500,
				'id_tipo_mercancia'   => $servicios,
				'costo'    => 150,
				'puntos_comisionables' => 100
		);
		
		$this->mercancia->nuevaMercancia ($datosMercancia);
		$this->mercancia->ingresarMercancia ();

	}

	private function after(){
		$this->mercancia->eliminarMercancias();
	}


	public function testSetValoresMercancia(){
		$mercancia=$this->mercancia;
		
		$resultado=$mercancia->getIdMercancia();
		echo $this->unit->run(500,$resultado, 'Test set Base de datos Id Mercancia','Resultado es :'.$resultado);

		$resultado=$mercancia->getIdTipoMercancia();
		echo $this->unit->run(2,$resultado, 'Test set Base de datos Id Tipo Mercancia','Resultado es :'.$resultado);
		
		$resultado=$mercancia->getCosto();
		echo $this->unit->run(150,$resultado, 'Test set Base de datos Costo','Resultado es :'.$resultado);
		
		$resultado=$mercancia->getPuntosComisionables();
		echo $this->unit->run(100,$resultado, 'Test set Base de datos Puntos Comisionables','Resultado es :'.$resultado);
		
	}
	
	public function testSetValoresMercanciaBaseDeDatos(){

		$mercancia=new $this->mercancia ();
		$mercancia->setUpMercancia(500);
		
		$resultado=$mercancia->getIdMercancia();
		echo $this->unit->run(500,$resultado, 'Test set Base de datos Id Mercancia','Resultado es :'.$resultado);

		$resultado=$mercancia->getIdTipoMercancia();
		echo $this->unit->run(2,$resultado, 'Test set Base de datos Id Tipo Mercancia','Resultado es :'.$resultado);
		
		$resultado=$mercancia->getCosto();
		echo $this->unit->run(150,$resultado, 'Test set Base de datos Costo','Resultado es :'.$resultado);
		
		$resultado=$mercancia->getPuntosComisionables();
		echo $this->unit->run(100,$resultado, 'Test set Base de datos Puntos Comisionables','Resultado es :'.$resultado);
		
		
	}


}