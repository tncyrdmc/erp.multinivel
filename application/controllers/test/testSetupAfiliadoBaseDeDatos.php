<?php
class testSetupAfiliadoBaseDeDatos extends CI_Controller {


	public function __construct() {
		parent::__construct();
		$this->load->library('unit_test');
		$this->load->model('/bo/bonos/afiliado');
		$this->load->model('/bo/bonos/red');
		$this->load->model('/bo/bonos/modelo_bono');
		$this->load->model('/bo/bonos/venta');
		$this->load->model('/bo/bonos/mercancia');
		

	}
	
	public function index(){
		$this->Before();
		$this->testSetValoresUsuario();
		$this->testSetValoresUsuarioBaseDeDatos();
		$this->testGetAfiliacionesTodaLaRedBaseDeDatos();
		$this->testGetAfiliacionesDirectosRedBaseDeDatos();
		$this->testGetAfiliacionesIntervalosDeTiempoDirectosRedBaseDeDatos();
		$this->testGetComprasPersonalesBaseDeDatos();
		$this->testGetComprasPersonalesDiferentesRedesBaseDeDatos();
		$this->testGetComprasPersonalesIntervalosDeTiempo();
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

	public function testGetAfiliacionesTodaLaRedBaseDeDatos(){
		$this->afiliado->eliminarUsuarios();
		$this->red->eliminarRed();
		
		$red=$this->red;
		$infinito=0;
		$datosRed = array(
				'id_red' => "300",
				'nombre'   => "Binario",
				'descripcion'    => "Test de Red Binaria",
				'frontal' => 2,
				'profundidad'   => $infinito,
				'valor_punto'    => 1,
				'estatus'   => 'ACT',
				'plan' => 'BIN'
		);
		
		$red->nuevaRed($datosRed);
		$red->ingresarRed();
		
		/*							RED DE AFILIACION PRUEBA
		 *           	                 __________
		 *           	               	|  10000   |
		 *        	   	               /| giovanny | \
		 *           	              / |_____2____|  \
		 *           	        _____/__             __\___
		 *           	       | 10001  |   	    | 10002 |
		 *       	           | carlos |   	    | pedro |\
		 *       	           |_10000__|   	    |_10000_| \
		 *  	          ______ /       _\_____    __/_____   \_______
		 *  	         |10003 |   	 | 10004 | |   10005 |  |10006 |
		 * 	           	 |camilo|   	 |nicolas| |esperanza|  |maria |
		 * 	         	 |10001_|   	 |_10001_| |__10002__|  |_10002|
		 *       ____/___    __\____       		  ____/__
		 *     |10007 	|  | 10008 |      		 |10009  |
		 * 	   |fernando|  |andres |      	     |ricardo|
		 * 	   |10003___|  |_10003_|      	     |_10002_|
		 */
		
		
		$this->modelo_bono->crearNuevoUsuario (10000,"giovanny","2016-03-17",20000,300,2,2,0);
		$this->modelo_bono->crearNuevoUsuario (10001,"carlos","2016-03-17",20001,300,10000,10000,0);
		$this->modelo_bono->crearNuevoUsuario (10002,"pedro","2016-03-17",20002,300,10000,10000,1);
		$this->modelo_bono->crearNuevoUsuario (10003,"camilo","2016-03-17",20003,300,10001,10001,0);
		$this->modelo_bono->crearNuevoUsuario (10004,"nicolas","2016-03-17",20004,300,10001,10001,1);
		$this->modelo_bono->crearNuevoUsuario (10005,"esperanza","2016-03-17",20005,300,10002,10000,0);
		$this->modelo_bono->crearNuevoUsuario (10006,"maria","2016-03-17",20006,300,10002,10002,1);
		$this->modelo_bono->crearNuevoUsuario (10007,"fernando","2016-03-17",20007,300,10003,10003,0);
		$this->modelo_bono->crearNuevoUsuario (10008,"andres","2016-03-17",20008,300,10003,10003,1);
		$this->modelo_bono->crearNuevoUsuario (10009,"ricardo","2016-03-17",20009,300,10005,10002,0);
	
		$usuario=$this->afiliado;
		$id_afiliado=10000;$red=300;$tipo='RED';$nivel=0;
		$resultado=$usuario->getAfiliados($id_afiliado,$red,$tipo,$nivel);
		echo $this->unit->run(9,$resultado, 'Test get Afiliados directos e indirectos ,en toda la red','Resultado es :'.$resultado);
		
		$usuario=new $this->afiliado();
		$id_afiliado=10001;$red=300;$tipo='RED';$nivel=0;
		$resultado=$usuario->getAfiliados($id_afiliado,$red,$tipo,$nivel);
		echo $this->unit->run(4,$resultado, 'Test get Afiliados directos e indirectos ,en toda la red','Resultado es :'.$resultado);
		
		$usuario=new $this->afiliado();
		$id_afiliado=10002;$red=300;$tipo='RED';$nivel=0;
		$resultado=$usuario->getAfiliados($id_afiliado,$red,$tipo,$nivel);
		echo $this->unit->run(3,$resultado, 'Test get Afiliados directos e indirectos ,en toda la red','Resultado es :'.$resultado);
		
		$usuario=new $this->afiliado();
		$id_afiliado=10003;$red=300;$tipo='RED';$nivel=0;
		$resultado=$usuario->getAfiliados($id_afiliado,$red,$tipo,$nivel);
		echo $this->unit->run(2,$resultado, 'Test get Afiliados directos e indirectos ,en toda la red','Resultado es :'.$resultado);
		

		$usuario=new $this->afiliado();
		$id_afiliado=10004;$red=300;$tipo='RED';$nivel=0;
		$resultado=$usuario->getAfiliados($id_afiliado,$red,$tipo,$nivel);
		echo $this->unit->run(0,$resultado, 'Test get Afiliados directos e indirectos ,en toda la red','Resultado es :'.$resultado);
		
		$usuario=new $this->afiliado();
		$id_afiliado=10005;$red=300;$tipo='RED';$nivel=0;
		$resultado=$usuario->getAfiliados($id_afiliado,$red,$tipo,$nivel);
		echo $this->unit->run(1,$resultado, 'Test get Afiliados directos e indirectos ,en toda la red','Resultado es :'.$resultado);
		
		$usuario=new $this->afiliado();
		$id_afiliado=10006;$red=300;$tipo='RED';$nivel=0;
		$resultado=$usuario->getAfiliados($id_afiliado,$red,$tipo,$nivel);
		echo $this->unit->run(0,$resultado, 'Test get Afiliados directos e indirectos ,en toda la red','Resultado es :'.$resultado);
		
		$usuario=new $this->afiliado();
		$id_afiliado=10007;$red=300;$tipo='RED';$nivel=0;
		$resultado=$usuario->getAfiliados($id_afiliado,$red,$tipo,$nivel);
		echo $this->unit->run(0,$resultado, 'Test get Afiliados directos e indirectos ,en toda la red','Resultado es :'.$resultado);
		
		$usuario=new $this->afiliado();
		$id_afiliado=10008;$red=300;$tipo='RED';$nivel=0;
		$resultado=$usuario->getAfiliados($id_afiliado,$red,$tipo,$nivel);
		echo $this->unit->run(0,$resultado, 'Test get Afiliados directos e indirectos ,en toda la red','Resultado es :'.$resultado);
		
		$usuario=new $this->afiliado();
		$id_afiliado=10009;$red=300;$tipo='RED';$nivel=0;
		$resultado=$usuario->getAfiliados($id_afiliado,$red,$tipo,$nivel);
		echo $this->unit->run(0,$resultado, 'Test get Afiliados directos e indirectos ,en toda la red','Resultado es :'.$resultado);
		
	}
	
	public function testGetAfiliacionesDirectosRedBaseDeDatos(){
		$this->afiliado->eliminarUsuarios();
		$this->red->eliminarRed();
	
		$red=$this->red;
		$infinito=0;
		$datosRed = array(
				'id_red' => "300",
				'nombre'   => "Binario",
				'descripcion'    => "Test de Red Binaria",
				'frontal' => 2,
				'profundidad'   => $infinito,
				'valor_punto'    => 1,
				'estatus'   => 'ACT',
				'plan' => 'BIN'
		);
	
		$red->nuevaRed($datosRed);
		$red->ingresarRed();
	
		/*							RED DE AFILIACION PRUEBA
		 *           	                 __________
		 *           	               	|  10000   |
		 *        	   	               /| giovanny | \
		 *           	              / |_____2____|  \
		 *           	        _____/__             __\___
		 *           	       | 10001  |   	    | 10002 |
		 *       	           | carlos |   	    | pedro |\
		 *       	           |_10000__|   	    |_10000_| \
		 *  	          ______ /       _\_____    __/_____   \_______
		 *  	         |10003 |   	 | 10004 | |   10005 |  |10006 |
		 * 	           	 |camilo|   	 |nicolas| |esperanza|  |maria |
		 * 	         	 |10001_|   	 |_10001_| |__10000__|  |_10002|
		 *       ____/___    __\____       		  ____/__
		 *     |10007 	|  | 10008 |      		 |10009  |
		 * 	   |fernando|  |andres |      	     |ricardo|
		 * 	   |10003___|  |_10003_|      	     |_10002_|
		 * 	       |			|
		 * 	   |10010 	|  | 10011 |      	
		 * 	   |paola   |  |andrea |      	    
		 * 	   |10007___|  |_10003_|
		*/
	
	
		$this->modelo_bono->crearNuevoUsuario (10000,"giovanny","2016-03-17",20000,300,2,2,0);
		$this->modelo_bono->crearNuevoUsuario (10001,"carlos","2016-03-17",20001,300,10000,10000,0);
		$this->modelo_bono->crearNuevoUsuario (10002,"pedro","2016-03-17",20002,300,10000,10000,1);
		$this->modelo_bono->crearNuevoUsuario (10003,"camilo","2016-03-17",20003,300,10001,10001,0);
		$this->modelo_bono->crearNuevoUsuario (10004,"nicolas","2016-03-17",20004,300,10001,10001,1);
		$this->modelo_bono->crearNuevoUsuario (10005,"esperanza","2016-03-17",20005,300,10002,10000,0);
		$this->modelo_bono->crearNuevoUsuario (10006,"maria","2016-03-17",20006,300,10002,10002,1);
		$this->modelo_bono->crearNuevoUsuario (10007,"fernando","2016-03-17",20007,300,10003,10003,0);
		$this->modelo_bono->crearNuevoUsuario (10008,"andres","2016-03-17",20008,300,10003,10003,1);
		$this->modelo_bono->crearNuevoUsuario (10009,"ricardo","2016-03-17",20009,300,10005,10002,0);
		$this->modelo_bono->crearNuevoUsuario (10010,"paola","2016-03-17",20010,300,10007,10007,0);
		$this->modelo_bono->crearNuevoUsuario (10011,"andrea","2016-03-17",20011,300,10008,10003,0);
	
		$usuario=$this->afiliado;
		$id_afiliado=10000;$red=300;$tipo='DIRECTOS';$nivel=0;
		$resultado=$usuario->getAfiliados($id_afiliado,$red,$tipo,$nivel);
		echo $this->unit->run(3,$resultado, 'Test get Afiliados directos ,en toda la red','Resultado es :'.$resultado);
	
		$usuario=new $this->afiliado();
		$id_afiliado=10001;$red=300;$tipo='DIRECTOS';$nivel=0;
		$resultado=$usuario->getAfiliados($id_afiliado,$red,$tipo,$nivel);
		echo $this->unit->run(2,$resultado, 'Test get Afiliados directos ,en toda la red','Resultado es :'.$resultado);
	
		$usuario=new $this->afiliado();
		$id_afiliado=10002;$red=300;$tipo='DIRECTOS';$nivel=0;
		$resultado=$usuario->getAfiliados($id_afiliado,$red,$tipo,$nivel);
		echo $this->unit->run(2,$resultado, 'Test get Afiliados directos  ,en toda la red','Resultado es :'.$resultado);
	
		$usuario=new $this->afiliado();
		$id_afiliado=10003;$red=300;$tipo='DIRECTOS';$nivel=0;
		$resultado=$usuario->getAfiliados($id_afiliado,$red,$tipo,$nivel);
		echo $this->unit->run(3,$resultado, 'Test get Afiliados directos  ,en toda la red','Resultado es :'.$resultado);
	
	
		$usuario=new $this->afiliado();
		$id_afiliado=10004;$red=300;$tipo='DIRECTOS';$nivel=0;
		$resultado=$usuario->getAfiliados($id_afiliado,$red,$tipo,$nivel);
		echo $this->unit->run(0,$resultado, 'Test get Afiliados directos  ,en toda la red','Resultado es :'.$resultado);
	
		$usuario=new $this->afiliado();
		$id_afiliado=10005;$red=300;$tipo='DIRECTOS';$nivel=0;
		$resultado=$usuario->getAfiliados($id_afiliado,$red,$tipo,$nivel);
		echo $this->unit->run(0,$resultado, 'Test get Afiliados directos  ,en toda la red','Resultado es :'.$resultado);
	
		$usuario=new $this->afiliado();
		$id_afiliado=10006;$red=300;$tipo='DIRECTOS';$nivel=0;
		$resultado=$usuario->getAfiliados($id_afiliado,$red,$tipo,$nivel);
		echo $this->unit->run(0,$resultado, 'Test get Afiliados directos  ,en toda la red','Resultado es :'.$resultado);
	
		$usuario=new $this->afiliado();
		$id_afiliado=10007;$red=300;$tipo='DIRECTOS';$nivel=0;
		$resultado=$usuario->getAfiliados($id_afiliado,$red,$tipo,$nivel);
		echo $this->unit->run(1,$resultado, 'Test get Afiliados directos  ,en toda la red','Resultado es :'.$resultado);
	
		$usuario=new $this->afiliado();
		$id_afiliado=10008;$red=300;$tipo='DIRECTOS';$nivel=0;
		$resultado=$usuario->getAfiliados($id_afiliado,$red,$tipo,$nivel);
		echo $this->unit->run(0,$resultado, 'Test get Afiliados directos  ,en toda la red','Resultado es :'.$resultado);
	
		$usuario=new $this->afiliado();
		$id_afiliado=10009;$red=300;$tipo='DIRECTOS';$nivel=0;
		$resultado=$usuario->getAfiliados($id_afiliado,$red,$tipo,$nivel);
		echo $this->unit->run(0,$resultado, 'Test get Afiliados directos  ,en toda la red','Resultado es :'.$resultado);
	
	}
	
	public function testGetAfiliacionesIntervalosDeTiempoDirectosRedBaseDeDatos(){
		$this->afiliado->eliminarUsuarios();
		$this->red->eliminarRed();
	
		$red=$this->red;
		$infinito=0;
		$datosRed = array(
				'id_red' => "300",
				'nombre'   => "Binario",
				'descripcion'    => "Test de Red Binaria",
				'frontal' => 2,
				'profundidad'   => $infinito,
				'valor_punto'    => 1,
				'estatus'   => 'ACT',
				'plan' => 'BIN'
		);
	
		$red->nuevaRed($datosRed);
		$red->ingresarRed();
	
		/*							RED DE AFILIACION PRUEBA
		 *           	                 __________
		 *           	               	|  10000   |
		 *        	   	               /| giovanny | \
		 *           	              / |_____2____|  \
		 *           	        _____/__             __\___
		 *           	       | 10001  |   	    | 10002 |
		 *       	           | carlos |   	    | pedro |\
		 *       	           |_10000__|   	    |_10000_| \
		 *  	          ______ /       _\_____    __/_____   \_______
		 *  	         |10003 |   	 | 10004 | |   10005 |  |10006 |
		 * 	           	 |camilo|   	 |nicolas| |esperanza|  |maria |
		 * 	         	 |10000_|   	 |_10000_| |__10002__|  |_10000|
		 *       ____/___    __\____       		  ____/__
		 *     |10007 	|  | 10008 |      		 |10009  |
		 * 	   |fernando|  |andres |      	     |ricardo|
		 * 	   |10003___|  |_10003_|      	     |_10000_|
		*/
	
	
		$this->modelo_bono->crearNuevoUsuario (10000,"giovanny","2016-03-01",20000,300,2,2,0);
		$this->modelo_bono->crearNuevoUsuario (10001,"carlos","2016-03-02",20001,300,10000,10000,0);
		$this->modelo_bono->crearNuevoUsuario (10002,"pedro","2016-03-03",20002,300,10000,10000,1);
		$this->modelo_bono->crearNuevoUsuario (10003,"camilo","2016-03-03",20003,300,10000,10000,0);
		$this->modelo_bono->crearNuevoUsuario (10004,"nicolas","2016-03-07",20004,300,10000,10000,1);
		$this->modelo_bono->crearNuevoUsuario (10005,"esperanza","2016-03-06",20005,300,10002,10002,0);
		$this->modelo_bono->crearNuevoUsuario (10006,"maria","2016-03-15",20006,300,10002,10002,1);
		$this->modelo_bono->crearNuevoUsuario (10007,"fernando","2016-03-05",20007,300,10003,10003,0);
		$this->modelo_bono->crearNuevoUsuario (10008,"andres","2016-03-20",20008,300,10003,10003,1);
		$this->modelo_bono->crearNuevoUsuario (10009,"ricardo","2016-03-18",20009,300,10005,10000,0);
	
		$usuario=$this->afiliado;
		$id_afiliado=10000;$red=300;$tipo='RED';$nivel=0;$fechaInicio='2016-02-29';$fechaFin='2016-03-06';
		$resultado=$usuario->getAfiliadosIntervaloDeTiempo($id_afiliado,$red,$tipo,$nivel,$fechaInicio,$fechaFin);
		echo $this->unit->run(3,$resultado, 'Test get Afiliados directos ,en toda la red en 1 semana','Resultado es :'.$resultado);
	
		$usuario=new $this->afiliado();
		$id_afiliado=10003;$red=300;$tipo='RED';$nivel=0;$fechaInicio='2016-02-29';$fechaFin='2016-03-06';
		$resultado=$usuario->getAfiliadosIntervaloDeTiempo($id_afiliado,$red,$tipo,$nivel,$fechaInicio,$fechaFin);
		echo $this->unit->run(1,$resultado, 'Test get Afiliados directos ,en toda la red en 1 semana','Resultado es :'.$resultado);

		
		$usuario=$this->afiliado;
		$id_afiliado=10000;$red=300;$tipo='RED';$nivel=0;$fechaInicio='2016-03-01';$fechaFin='2016-03-15';
		$resultado=$usuario->getAfiliadosIntervaloDeTiempo($id_afiliado,$red,$tipo,$nivel,$fechaInicio,$fechaFin);
		echo $this->unit->run(4,$resultado, 'Test get Afiliados directos ,en toda la red en 1 Quincena','Resultado es :'.$resultado);
		
		$usuario=new $this->afiliado();
		$id_afiliado=10000;$red=300;$tipo='RED';$nivel=0;$fechaInicio='2016-03-16';$fechaFin='2016-03-31';
		$resultado=$usuario->getAfiliadosIntervaloDeTiempo($id_afiliado,$red,$tipo,$nivel,$fechaInicio,$fechaFin);
		echo $this->unit->run(1,$resultado, 'Test get Afiliados directos ,en toda la red en 2 Quincena','Resultado es :'.$resultado);
		
		$usuario=$this->afiliado;
		$id_afiliado=10003;$red=300;$tipo='RED';$nivel=0;$fechaInicio='2016-03-01';$fechaFin='2016-03-15';
		$resultado=$usuario->getAfiliadosIntervaloDeTiempo($id_afiliado,$red,$tipo,$nivel,$fechaInicio,$fechaFin);
		echo $this->unit->run(1,$resultado, 'Test get Afiliados directos ,en toda la red en 1 Quincena','Resultado es :'.$resultado);
		
		$usuario=new $this->afiliado();
		$id_afiliado=10003;$red=300;$tipo='RED';$nivel=0;$fechaInicio='2016-03-16';$fechaFin='2016-03-31';
		$resultado=$usuario->getAfiliadosIntervaloDeTiempo($id_afiliado,$red,$tipo,$nivel,$fechaInicio,$fechaFin);
		echo $this->unit->run(1,$resultado, 'Test get Afiliados directos ,en toda la red en 2 Quincena','Resultado es :'.$resultado);
		
	}

	public function testGetComprasPersonalesBaseDeDatos(){
		
		$this->venta->eliminarVentas();
		$this->mercancia->eliminarMercancias();
		$this->mercancia->eliminarCategorias();
		
		$datosCategoria = array(
				'id_categoria' => 250,
				'id_red'   => 300,
		);
		
		$this->mercancia->ingresarCategoria ($datosCategoria);
		
		$usuario=$this->afiliado;
		
		$servicios=2;
		
		$datosMercancia = array(
				'id_mercancia' => 500,
				'id_tipo_mercancia'   => $servicios,
				'costo'    => 150,
				'puntos_comisionables' => 100,
				'id_categoria' => 250,
				'id_red'   => 300
		);
		
		$this->mercancia->nuevaMercancia ($datosMercancia);
		$this->mercancia->ingresarMercancia ();
		
		$servicios=2;
		
		$datosMercancia = array(
				'id_mercancia' => 501,
				'id_tipo_mercancia'   => $servicios,
				'costo'    => 200,
				'puntos_comisionables' => 250,
				'id_categoria' => 250,
				'id_red'   => 300
		);
		
		$this->mercancia->nuevaMercancia ($datosMercancia);
		$this->mercancia->ingresarMercancia ();
		
		$datosMercanciasVendidas=array();
		$datosMercancia1 = array(
				'id_mercancia' => 500,
				'costo_total'   => 150,
				'puntos_comisionables'    => 100,
		);
		
		$datosMercancia2 = array(
				'id_mercancia' => 501,
				'costo_total'   => 200,
				'puntos_comisionables'    => 250,
		);
		
		
		array_push($datosMercanciasVendidas,$datosMercancia1,$datosMercancia2);
		
		$datosVenta = array(
				'id_venta' =>700,
				'id_usuario'   => 10000,
				'estatus'    => 'ACT',
				'fecha' => '2016-03-01',
				'mercancia'=>$datosMercanciasVendidas
		);
		
		$this->venta->nuevaVenta ($datosVenta);
		$this->venta->ingresarVenta ();
		
		$id_afiliado=10000;$id_red=300;

		$resultado=$usuario->getComprasPersonales($id_afiliado,$id_red);
		echo $this->unit->run(350,$resultado, 'Test get Compras personales','Resultado es :'.$resultado);
		
	}
	
	public function testGetComprasPersonalesDiferentesRedesBaseDeDatos(){
	
		$this->venta->eliminarVentas();
		$this->mercancia->eliminarMercancias();
		$this->mercancia->eliminarCategorias();
	
		$datosCategoria = array(
				'id_categoria' => 250,
				'id_red'   => 300,
		);
	
		$this->mercancia->ingresarCategoria ($datosCategoria);
		
		$datosCategoria = array(
				'id_categoria' => 251,
				'id_red'   => 301,
		);
		
		$this->mercancia->ingresarCategoria ($datosCategoria);
	
		$usuario=$this->afiliado;
	
		$servicios=2;
	
		$datosMercancia = array(
				'id_mercancia' => 500,
				'id_tipo_mercancia'   => $servicios,
				'costo'    => 150,
				'puntos_comisionables' => 100,
				'id_categoria' => 250,
				'id_red'   => 300
		);
	
		$this->mercancia->nuevaMercancia ($datosMercancia);
		$this->mercancia->ingresarMercancia ();
	
		$servicios=2;
	
		$datosMercancia = array(
				'id_mercancia' => 501,
				'id_tipo_mercancia'   => $servicios,
				'costo'    => 200,
				'puntos_comisionables' => 250,
				'id_categoria' => 251,
				'id_red'   => 301
		);
	
		$this->mercancia->nuevaMercancia ($datosMercancia);
		$this->mercancia->ingresarMercancia ();
	
		$datosMercanciasVendidas=array();
		$datosMercancia1 = array(
				'id_mercancia' => 500,
				'costo_total'   => 150,
				'puntos_comisionables'    => 100,
		);
	
		$datosMercancia2 = array(
				'id_mercancia' => 501,
				'costo_total'   => 200,
				'puntos_comisionables'    => 250,
		);
	
	
		array_push($datosMercanciasVendidas,$datosMercancia1,$datosMercancia2);
	
		$datosVenta = array(
				'id_venta' =>700,
				'id_usuario'   => 10000,
				'estatus'    => 'ACT',
				'fecha' => '2016-03-01',
				'mercancia'=>$datosMercanciasVendidas
		);
	
		$this->venta->nuevaVenta ($datosVenta);
		$this->venta->ingresarVenta ();
	
		$id_afiliado=10000;$id_red=300;
	
		$resultado=$usuario->getComprasPersonales($id_afiliado,$id_red);
		echo $this->unit->run(150,$resultado, 'Test get Compras personales','Resultado es :'.$resultado);
	
		
		$this->venta->eliminarVentas();
		$this->mercancia->eliminarMercancias();
		$this->mercancia->eliminarCategorias();
		
		$datosCategoria = array(
				'id_categoria' => 250,
				'id_red'   => 300,
		);
		
		$this->mercancia->ingresarCategoria ($datosCategoria);
		
		$datosCategoria = array(
				'id_categoria' => 251,
				'id_red'   => 301,
		);
		
		$this->mercancia->ingresarCategoria ($datosCategoria);
		
		$usuario=$this->afiliado;
		
		$servicios=2;
		
		$datosMercancia = array(
				'id_mercancia' => 500,
				'id_tipo_mercancia'   => $servicios,
				'costo'    => 150,
				'puntos_comisionables' => 100,
				'id_categoria' => 251,
				'id_red'   => 301
		);
		
		$this->mercancia->nuevaMercancia ($datosMercancia);
		$this->mercancia->ingresarMercancia ();
		
		$servicios=2;
		
		$datosMercancia = array(
				'id_mercancia' => 501,
				'id_tipo_mercancia'   => $servicios,
				'costo'    => 200,
				'puntos_comisionables' => 250,
				'id_categoria' => 251,
				'id_red'   => 301
		);
		
		$this->mercancia->nuevaMercancia ($datosMercancia);
		$this->mercancia->ingresarMercancia ();
		
		$datosMercanciasVendidas=array();
		$datosMercancia1 = array(
				'id_mercancia' => 500,
				'costo_total'   => 150,
				'puntos_comisionables'    => 100,
		);
		
		$datosMercancia2 = array(
				'id_mercancia' => 501,
				'costo_total'   => 200,
				'puntos_comisionables'    => 250,
		);
		
		
		array_push($datosMercanciasVendidas,$datosMercancia1,$datosMercancia2);
		
		$datosVenta = array(
				'id_venta' =>700,
				'id_usuario'   => 10000,
				'estatus'    => 'ACT',
				'fecha' => '2016-03-01',
				'mercancia'=>$datosMercanciasVendidas
		);
		
		$this->venta->nuevaVenta ($datosVenta);
		$this->venta->ingresarVenta ();
		
		$id_afiliado=10000;$id_red=300;
		
		$resultado=$usuario->getComprasPersonales($id_afiliado,$id_red);
		echo $this->unit->run(0,$resultado, 'Test get Compras personales','Resultado es :'.$resultado);
		
	}
	
	public function testGetComprasPersonalesIntervalosDeTiempo(){

		$this->venta->eliminarVentas();
		$this->mercancia->eliminarMercancias();
		$this->mercancia->eliminarCategorias();
		
		$datosCategoria = array(
				'id_categoria' => 250,
				'id_red'   => 300,
		);
		
		$this->mercancia->ingresarCategoria ($datosCategoria);
		
		$datosCategoria = array(
				'id_categoria' => 251,
				'id_red'   => 301,
		);
		
		$this->mercancia->ingresarCategoria ($datosCategoria);
		
		$usuario=$this->afiliado;
		
		$servicios=2;
		
		$datosMercancia = array(
				'id_mercancia' => 500,
				'id_tipo_mercancia'   => $servicios,
				'costo'    => 150,
				'puntos_comisionables' => 100,
				'id_categoria' => 250,
				'id_red'   => 300
		);
		
		$this->mercancia->nuevaMercancia ($datosMercancia);
		$this->mercancia->ingresarMercancia ();
		
		$servicios=2;
		
		$datosMercancia = array(
				'id_mercancia' => 501,
				'id_tipo_mercancia'   => $servicios,
				'costo'    => 200,
				'puntos_comisionables' => 250,
				'id_categoria' => 251,
				'id_red'   => 301
		);
		
		$this->mercancia->nuevaMercancia ($datosMercancia);
		$this->mercancia->ingresarMercancia ();
		
		$datosMercanciasVendidas=array();
		$datosMercancia1 = array(
				'id_mercancia' => 500,
				'costo_total'   => 150,
				'puntos_comisionables'    => 100,
		);
		
		$datosMercancia2 = array(
				'id_mercancia' => 501,
				'costo_total'   => 200,
				'puntos_comisionables'    => 250,
		);
		
		
		array_push($datosMercanciasVendidas,$datosMercancia1,$datosMercancia2);
		
		$datosVenta = array(
				'id_venta' =>700,
				'id_usuario'   => 10000,
				'estatus'    => 'ACT',
				'fecha' => '2016-02-01',
				'mercancia'=>$datosMercanciasVendidas
		);
		
		$this->venta->nuevaVenta ($datosVenta);
		$this->venta->ingresarVenta ();
		
		$id_afiliado=10000;$id_red=300;$fechaInicio='2016-03-16';$fechaFin='2016-03-31';
		
		
		$resultado=$usuario->getComprasPersonalesIntervaloDeTiempo($id_afiliado,$id_red,$fechaInicio,$fechaFin);
		echo $this->unit->run(0,$resultado, 'Test get Compras personales Intervalos de Tiempo','Resultado es :'.$resultado);
		
		
		$this->venta->eliminarVentas();
		$this->mercancia->eliminarMercancias();
		$this->mercancia->eliminarCategorias();
		
		$datosCategoria = array(
				'id_categoria' => 250,
				'id_red'   => 300,
		);
		
		$this->mercancia->ingresarCategoria ($datosCategoria);
		
		$datosCategoria = array(
				'id_categoria' => 251,
				'id_red'   => 301,
		);
		
		$this->mercancia->ingresarCategoria ($datosCategoria);
		
		$usuario=$this->afiliado;
		
		$servicios=2;
		
		$datosMercancia = array(
				'id_mercancia' => 500,
				'id_tipo_mercancia'   => $servicios,
				'costo'    => 150,
				'puntos_comisionables' => 100,
				'id_categoria' => 250,
				'id_red'   => 300
		);
		
		$this->mercancia->nuevaMercancia ($datosMercancia);
		$this->mercancia->ingresarMercancia ();
		
		$servicios=2;
		
		$datosMercancia = array(
				'id_mercancia' => 501,
				'id_tipo_mercancia'   => $servicios,
				'costo'    => 200,
				'puntos_comisionables' => 250,
				'id_categoria' => 250,
				'id_red'   => 300
		);
		
		$this->mercancia->nuevaMercancia ($datosMercancia);
		$this->mercancia->ingresarMercancia ();
		
		$datosMercanciasVendidas=array();
		$datosMercancia1 = array(
				'id_mercancia' => 500,
				'costo_total'   => 150,
				'puntos_comisionables'    => 100,
		);
		
		$datosMercancia2 = array(
				'id_mercancia' => 501,
				'costo_total'   => 200,
				'puntos_comisionables'    => 250,
		);
		
		
		array_push($datosMercanciasVendidas,$datosMercancia1,$datosMercancia2);
		
		$datosVenta = array(
				'id_venta' =>700,
				'id_usuario'   => 10000,
				'estatus'    => 'ACT',
				'fecha' => '2016-03-01',
				'mercancia'=>$datosMercanciasVendidas
		);
		
		$this->venta->nuevaVenta ($datosVenta);
		$this->venta->ingresarVenta ();
		
		$id_afiliado=10000;$id_red=300;$fechaInicio='2016-03-01';$fechaFin='2016-03-31';
		
		$resultado=$usuario->getComprasPersonalesIntervaloDeTiempo($id_afiliado,$id_red,$fechaInicio,$fechaFin);
		echo $this->unit->run(350,$resultado, 'Test get Compras personales Intervalos de Tiempo','Resultado es :'.$resultado);
		
		$this->venta->eliminarVentas();
		
		$datosVenta = array(
				'id_venta' =>700,
				'id_usuario'   => 10000,
				'estatus'    => 'ACT',
				'fecha' => '2016-03-06',
				'mercancia'=>$datosMercanciasVendidas
		);
		
		$this->venta->nuevaVenta ($datosVenta);
		$this->venta->ingresarVenta ();
		
		$id_afiliado=10000;$id_red=300;$fechaInicio='2016-03-01';$fechaFin='2016-03-06';
		
		$resultado=$usuario->getComprasPersonalesIntervaloDeTiempo($id_afiliado,$id_red,$fechaInicio,$fechaFin);
		echo $this->unit->run(350,$resultado, 'Test get Compras personales Intervalos de Tiempo','Resultado es :'.$resultado);
		
		$this->venta->eliminarVentas();
		
		array_push($datosMercanciasVendidas,$datosMercancia1,$datosMercancia2);
		
		$datosVenta = array(
				'id_venta' =>700,
				'id_usuario'   => 10000,
				'estatus'    => 'ACT',
				'fecha' => '2016-03-06',
				'mercancia'=>$datosMercanciasVendidas
		);
		
		$this->venta->nuevaVenta ($datosVenta);
		$this->venta->ingresarVenta ();
		
		$id_afiliado=10000;$id_red=300;$fechaInicio='2016-03-07';$fechaFin='2016-03-13';
		
		$resultado=$usuario->getComprasPersonalesIntervaloDeTiempo($id_afiliado,$id_red,$fechaInicio,$fechaFin);
		echo $this->unit->run(0,$resultado, 'Test get Compras personales Intervalos de Tiempo','Resultado es :'.$resultado);
		
	}
}