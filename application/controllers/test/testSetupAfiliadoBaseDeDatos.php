<?php
class testSetupAfiliadoBaseDeDatos extends CI_Controller {


	public function __construct() {
		parent::__construct();
		$this->load->library('unit_test');
		$this->load->model('/bo/bonos/afiliado');

	}
	
	public function index(){
		$this->Before();
		$this->testSetValoresUsuario();
		$this->testSetValoresUsuarioBaseDeDatos();
		$this->after();
	}
	
	private function Before(){
		$this->afiliado->eliminarUsuarios();
		
		$datosUsuario = array(
				'id_usuario' => 10000,
				'username'   => "giovanny",
				'created'    => "2015-03-17",
				'id_afiliacion' => 20000,
				'id_red'   => 1,
				'id_padre'    => 2,
				'id_sponsor'   => 2,
				'lado_red' => 0
		);
		
		$this->afiliado->nuevoAfiliado ($datosUsuario);
		$this->afiliado->ingresarUsuario ();

	}

	private function after(){
		$this->afiliado->eliminarUsuarios();
	}


	public function testSetValoresUsuario(){
		$usuario=$this->afiliado;
		
		$resultado=$usuario->getIdUsuario();
		echo $this->unit->run(10000,$resultado, 'Test set Base de datos Id Usuario','Resultado es :'.$resultado);
		
		$resultado=$usuario->getUsername();
		echo $this->unit->run("giovanny",$resultado, 'Test set Base de datos Nombre Usuario','Resultado es :'.$resultado);
		
		$resultado=$usuario->getCreated();
		echo $this->unit->run("2015-03-17",$resultado, 'Test set Base de datos Fecha Creacion Usuario','Resultado es :'.$resultado);
		
		$resultado=$usuario->getIdAfiliacion();
		echo $this->unit->run(20000,$resultado, 'Test set Base de datos Fecha Creacion Usuario','Resultado es :'.$resultado);
		
		$resultado=$usuario->getIdRed();
		echo $this->unit->run(1,$resultado, 'Test set Base de datos Id red Usuario','Resultado es :'.$resultado);
		
		$resultado=$usuario->getIdPadre();
		echo $this->unit->run(2,$resultado, 'Test set Base de datos Id Padre Usuario','Resultado es :'.$resultado);
		
		$resultado=$usuario->getIdSponsor();
		echo $this->unit->run(2,$resultado, 'Test set Base de datos Id Sponsor Usuario','Resultado es :'.$resultado);
		
		$resultado=$usuario->getLadoRed();
		echo $this->unit->run(0,$resultado, 'Test set Base de datos Lado Red Usuario','Resultado es :'.$resultado);

	}
	
	public function testSetValoresUsuarioBaseDeDatos(){

		$usuario=new $this->afiliado ();
		$usuario->setUpAfiliado(10000);
		
		$resultado=$usuario->getIdUsuario();
		echo $this->unit->run(10000,$resultado, 'Test set Base de datos Id Usuario','Resultado es :'.$resultado);
		
		$resultado=$usuario->getUsername();
		echo $this->unit->run("giovanny",$resultado, 'Test set Base de datos Nombre Usuario','Resultado es :'.$resultado);
		
		$resultado=$usuario->getCreated();
		echo $this->unit->run("2015-03-17 00:00:00",$resultado, 'Test set Base de datos Fecha Creacion Usuario','Resultado es :'.$resultado);
		
		$resultado=$usuario->getIdAfiliacion();
		echo $this->unit->run(20000,$resultado, 'Test set Base de datos Fecha id Afiliacion','Resultado es :'.$resultado);
		
		$resultado=$usuario->getIdRed();
		echo $this->unit->run(1,$resultado, 'Test set Base de datos Id red Usuario','Resultado es :'.$resultado);
		
		$resultado=$usuario->getIdPadre();
		echo $this->unit->run(2,$resultado, 'Test set Base de datos Id Padre Usuario','Resultado es :'.$resultado);
		
		$resultado=$usuario->getIdSponsor();
		echo $this->unit->run(2,$resultado, 'Test set Base de datos Id Sponsor Usuario','Resultado es :'.$resultado);
		
		$resultado=$usuario->getLadoRed();
		echo $this->unit->run(0,$resultado, 'Test set Base de datos Lado Red Usuario','Resultado es :'.$resultado);
		
		
	}


}