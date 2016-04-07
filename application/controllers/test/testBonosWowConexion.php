<?php
class testBonosWowConexion extends CI_Controller {

	private $idBonoInicioRapidos=56;

	public function __construct() {
		parent::__construct();
		$this->load->library('unit_test');
		$this->load->model('/bo/bonos/activacion_bono');
		$this->load->model('/bo/bonos/afiliado');
		$this->load->model('/bo/bonos/bono');
		$this->load->model('/bo/bonos/calculador_bono');
		$this->load->model('/bo/bonos/condiciones_bono');
		$this->load->model('/bo/bonos/mercancia');
		$this->load->model('/bo/bonos/red');
		$this->load->model('/bo/bonos/valores_bono');
		$this->load->model('/bo/bonos/venta');
		$this->load->model('/bo/bonos/modelo_bono');

	}

	private function before(){
		$this->modelo_bono->limpiarTodosLosBonos();
		$this->afiliado->eliminarUsuarios();
		$this->red->eliminarRed();
		$this->mercancia->eliminarMercancias();
		$this->mercancia->eliminarCategorias();
		$this->venta->eliminarVentas();
		$this->repartidor_comision_bono->eliminarHistorialComisionBono();
		$this->ingresarBonos();
		$this->ingresarRedDeAfiliacion();
		$this->ingresarVentas();
	}
	
	private function after(){
		$this->modelo_bono->limpiarTodosLosBonos();
		$this->afiliado->eliminarUsuarios();
		$this->red->eliminarRed();
		$this->mercancia->eliminarMercancias();
		$this->mercancia->eliminarCategorias();
		$this->venta->eliminarVentas();
		$this->repartidor_comision_bono->eliminarHistorialComisionBono();
		$this->repartidor_comision_bono->eliminarHistorialComisionBono();

	}
	
	public function index(){
		
		$this->before();
		$this->testValidarSiElBonoYaCobroFalso();
		$this->after();
		
		$this->before();
		$this->testCalcularComisionesAfiliadosTodosLosBonos();
		$this->testValidarSiElBonoYaCobroVerdadero();
		$this->after();

	}

	public function testValidarSiElBonoYaCobroFalso(){
		$this->repartidor_comision_bono->eliminarHistorialComisionBono();
		
		$calculadorBono=new $this->calculador_bono();

		$id_bono=$this->idBonoInicioRapidos;$bono=new $this->bono();$bono->setUpBono($id_bono);
		$resultado=$calculadorBono->isPagado($bono);
		echo $this->unit->run(false,$resultado, 'Test validar si el bono no sea pagado','Resultado es :'.$resultado);

	}

	public function testCalcularComisionesAfiliadosTodosLosBonos(){
		$this->repartidor_comision_bono->eliminarHistorialComisionBono();
		$repartidorComisionBono=new$this->repartidor_comision_bono();
		
		$calculadorBono=new $this->calculador_bono();
		
		$calculadorBono->calcularComisionesBonos();

		//BONO Inicio Rapido

		$id_bono=$this->idBonoInicioRapidos;
		
		$id_usuario=10000;
		$resultado=$repartidorComisionBono->getTotalValoresTransaccionPorBonoYUsuario($id_bono,$id_usuario)[0]->total;
		echo $this->unit->run(40,$resultado, 'Test validar si entrega comisiones bono en red al afiliado '.$id_usuario,'Resultado es :'.$resultado);

		$id_usuario=10002;
		$resultado=$repartidorComisionBono->getTotalValoresTransaccionPorBonoYUsuario($id_bono,$id_usuario)[0]->total;
		echo $this->unit->run(20,$resultado, 'Test validar si entrega comisiones bono en red al afiliado '.$id_usuario,'Resultado es :'.$resultado);

		$id_usuario=10003;
		$resultado=$repartidorComisionBono->getTotalValoresTransaccionPorBonoYUsuario($id_bono,$id_usuario)[0]->total;
		echo $this->unit->run(10,$resultado, 'Test validar si entrega comisiones bono en red al afiliado '.$id_usuario,'Resultado es :'.$resultado);
		
		
		$id_usuario=10006;
		$resultado=$repartidorComisionBono->getTotalValoresTransaccionPorBonoYUsuario($id_bono,$id_usuario)[0]->total;
		echo $this->unit->run(30,$resultado, 'Test validar si entrega comisiones bono en red al afiliado '.$id_usuario,'Resultado es :'.$resultado);
		
		$id_usuario=10007;
		$resultado=$repartidorComisionBono->getTotalValoresTransaccionPorBonoYUsuario($id_bono,$id_usuario)[0]->total;
		echo $this->unit->run(20,$resultado, 'Test validar si entrega comisiones bono en red al afiliado '.$id_usuario,'Resultado es :'.$resultado);
		
		$id_usuario=10012;
		$resultado=$repartidorComisionBono->getTotalValoresTransaccionPorBonoYUsuario($id_bono,$id_usuario)[0]->total;
		echo $this->unit->run(50,$resultado, 'Test validar si entrega comisiones bono en red al afiliado '.$id_usuario,'Resultado es :'.$resultado);
		
		$id_usuario=10014;
		$resultado=$repartidorComisionBono->getTotalValoresTransaccionPorBonoYUsuario($id_bono,$id_usuario)[0]->total;
		echo $this->unit->run(20,$resultado, 'Test validar si entrega comisiones bono en red al afiliado '.$id_usuario,'Resultado es :'.$resultado);
		
		$id_usuario=10016;
		$resultado=$repartidorComisionBono->getTotalValoresTransaccionPorBonoYUsuario($id_bono,$id_usuario)[0]->total;
		echo $this->unit->run(40,$resultado, 'Test validar si entrega comisiones bono en red al afiliado '.$id_usuario,'Resultado es :'.$resultado);
		
		$id_usuario=10017;
		$resultado=$repartidorComisionBono->getTotalValoresTransaccionPorBonoYUsuario($id_bono,$id_usuario)[0]->total;
		echo $this->unit->run(40,$resultado, 'Test validar si entrega comisiones bono en red al afiliado '.$id_usuario,'Resultado es :'.$resultado);
		
		$id_usuario=10019;
		$resultado=$repartidorComisionBono->getTotalValoresTransaccionPorBonoYUsuario($id_bono,$id_usuario)[0]->total;
		echo $this->unit->run(30,$resultado, 'Test validar si entrega comisiones bono en red al afiliado '.$id_usuario,'Resultado es :'.$resultado);
		
		$id_usuario=10020;
		$resultado=$repartidorComisionBono->getTotalValoresTransaccionPorBonoYUsuario($id_bono,$id_usuario)[0]->total;
		echo $this->unit->run(30,$resultado, 'Test validar si entrega comisiones bono en red al afiliado '.$id_usuario,'Resultado es :'.$resultado);
		
		$id_usuario=10022;
		$resultado=$repartidorComisionBono->getTotalValoresTransaccionPorBonoYUsuario($id_bono,$id_usuario)[0]->total;
		echo $this->unit->run(60,$resultado, 'Test validar si entrega comisiones bono en red al afiliado '.$id_usuario,'Resultado es :'.$resultado);
		
	
	}
	
	public function testValidarSiElBonoYaCobroVerdadero(){
		
		$calculadorBono=new $this->calculador_bono();

		$id_bono=$this->idBonoInicioRapidos;$bono=new $this->bono();$bono->setUpBono($id_bono);
		$resultado=$calculadorBono->isPagado($bono);
		echo $this->unit->run(true,$resultado, 'Test validar si el bono ya se pago','Resultado es :'.$resultado);

		
	}
	
	private function ingresarBonos(){
		$this->modelo_bono->limpiarTodosLosBonos();
		
		//----------------------------BONO INICIO RAPIDO ------------------------------------------------
		/* [ id_tipo_rango ]= Tipo de condicion que se debe cumplir.
		 * 					  	1.Afiliaciones
		 * 					  	2.Ventas Red
		 * 					  	3.Compras Personales
		 * 					  	4.Puntos Comisionables Personales
		 * 					  	5.Puntos Comisionables Red
		 * 
		 * [condicion1]= (Afiliados) Red (Los demas) Tipo de Mercancia
		 * 												1.Productos
		 * 												2.Servicios
		 * 												3.Combinado
		 * 												4.Paquete de Inscripcion
		 * 												5.Membresia
		 * 
		 * [condicion2]= (Afiliados) Nivel (Los demas) ID Mercancia
		 * 
		 */
		
		$comprasPersonales=3;
		$servicios=2;
		$id_mercancia=501;
		
		$datosRango = array(
				'id_rango' => 66,
				'nombre_rango'   => "Bluetooth",
				'descripcion_rango'    => "Bluetooth",
				'id_tipo_rango' => $comprasPersonales,
				'valor'   => 100,
				'condicion_red'    => "RED",
				'nivel_red'   => 0,
				'id_condicion' => 7,
				'id_red'   => 300,
				'condicion_red_afilacion'    => "EQU",
				'condicion1'    => $servicios,
				'condicion2'	=> $id_mercancia,
				'estatus_rango'	=> 'ACT'
		);
		
		$inicioAfiliacion=0;
		$fechaActual=0;
		
		$datosBono = array(
				'id_bono' => $this->idBonoInicioRapidos,
				'nombre_bono'   => "Bono Bluetooth",
				'descripcion_bono'    => "Bono Bluetooth",
				'plan'	=> "NO",
				'inicio' => '2016-03-01',
				'fin'   => '2026-03-25',
				'frecuencia'    => "UNI",
				'mes_desde_afiliacion'	=> $inicioAfiliacion,
				'mes_desde_activacion'	=> $fechaActual,
				'estatus_bono' => "ACT"
		);
		
		
		$datosValoresBono=array();
		
		$datosValoresBonoAfiliado = array(
				'id_valor' => 7,
				'id_rango'   => $this->idBonoInicioRapidos,
				'nivel'    => 0,
				'condicion_red'    => "RED",
				'verticalidad'    => "ASC",
				'valor'	=> 0
		);
		
		$datosValoresBonoHijo = array(
				'id_valor' => 8,
				'id_rango'   => $this->idBonoInicioRapidos,
				'nivel'    => 1,
				'condicion_red'    => "RED",
				'verticalidad'    => "ASC",
				'valor'	=> 30
		);
		
		$datosValoresBonoNieto = array(
				'id_valor' => 9,
				'id_rango'   => $this->idBonoInicioRapidos,
				'nivel'    => 2,
				'condicion_red'    => "RED",
				'verticalidad'    => "ASC",
				'valor'	=> 20
		);
		
		$datosValoresBonoBisNieto = array(
				'id_valor' => 10,
				'id_rango'   => $this->idBonoInicioRapidos,
				'nivel'    => 3,
				'condicion_red'    => "RED",
				'verticalidad'    => "ASC",
				'valor'	=> 10
		);
		
		
		array_push($datosValoresBono, $datosValoresBonoAfiliado,$datosValoresBonoHijo,$datosValoresBonoNieto,$datosValoresBonoBisNieto);
		$nuevoBono=new $this->modelo_bono();
		$nuevoBono->nuevoBono ($datosRango,$datosBono,$datosValoresBono);
		$nuevoBono->ingresarBono ();

		
	}

	private function ingresarRedDeAfiliacion(){
		
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
		
/*							RED DE AFILIACION
*           	                      __________
*           	               	     | GIOVANNY |
*           					     | ID:10000 |
*        	   	                     |_Spr:_2___|
*                  	       __________/           \____________
*           	          |  CARLOS  |        	  |   PEDRO  |
*           	          | ID:10001 |   		  | ID:10002 |
*        	   	          |_Spr:10000|            |_Spr:10000|       
*              __________/       _____\____    ___/_______    \_________ 
*             |   CAMILO |      | NICOLAS  |  | ESPERANZA|   |   MARIA  |
*             | ID:10003 |   	| ID:10004 |  | ID:10005 |   | ID:10006 |
*        	  |_Spr:10001|      |_Spr:10001|  |_Spr:10000|   |_Spr:10000|       
*		    ___/_____   __\_______                      _____/____     __\_______
*         | PEPE     | | DARIO    |                    |  DIEGO   |   |  ANDRES  |
*         | ID:10007 | | ID:10008 |                    | ID:10009 |   | ID:10010 |
*         |_Spr:10003| |_Spr:10001|                    |_Spr:10000|   |_Spr:10000| 
*  _______/__   _____\____                                       _____/____    __\_______
* | RICARDO  | | MIGUEL   |                                     |  PAOLA   |   | FERNANDO |
* | ID:10011 | | ID:10012 |                                     | ID:10013 |   | ID:10014 |
* |_Spr:10007| |_Spr:10007|                                     |_Spr:10010|   |_Spr:10010| 
*        _______/__   _____\____                                            ____/____     _\_________
*       | LAURA    | | DAVID    |                                          |  MARIO   |   | ANDREA   |
*       | ID:10015 | | ID:10016 |                                          | ID:10017 |   | ID:10018 |
*       |_Spr:10012| |_Spr:10012|                                          |_Spr:10014|   |_Spr:10014| 
*              _______/___  _____\____                                 ____/____      _\________
*             | JOAN     | |ALEJANDRO |                               | MARCEL   |   | DANIEL   |
*             | ID:10019 | | ID:10020 |                               | ID:10021 |   | ID:10022 |
*             |_Spr:10016| |_Spr:10001|\                              |_Spr:10017|   |_Spr:10017| 
* __________/  _____\____   _/________  \__________                          ___________/ ___\______
*| JULIAN   | | GERMAN   | |  LUIS    | |ALBERTO   |                        | CAROLINA | | HAROLL   |
*| ID:10023 | | ID:10024 | | ID:10025 | | ID:10026 |                        | ID:10027 | | ID:10028 |
*|_Spr:10019| |_Spr:10019| |_Spr:10016| |_Spr:10020|                        |_Spr:10022| |_Spr:10022| 
*_____|_____     ____|_____               ____|_____             __________/   ____\______
*|  RUBEN   |   |   MARCELA|             |  NELLY   |    	     |  JOSE    | | JOHANA   |
*| ID:10029 |   | ID:10030 |       	     | ID:10031 |            | ID:10032 | | ID:10033 |
*|Spr:10001 |   |Spr:10001 |             |Spr:10026 |            |_Spr:10027| |_Spr:10027| 
*/
		$this->ingresarAfiliado(10000,"giovanny",2,2,0);
		$this->ingresarAfiliado(10001,"carlos",10000,10000,0);
		$this->ingresarAfiliado(10002,"pedro",10000,10000,1);
		$this->ingresarAfiliado(10003,"camilo",10001,10001,0);
		$this->ingresarAfiliado(10004,"Nicolas",10001,10001,1);
		$this->ingresarAfiliado(10005,"esperanza",10002,10000,0);
		$this->ingresarAfiliado(10006,"maria",10002,10000,1);
		$this->ingresarAfiliado(10007,"pepe",10003,10003,0);
		$this->ingresarAfiliado(10008,"dario",10003,10001,1);
		$this->ingresarAfiliado(10009,"diego",10006,10000,0);
		$this->ingresarAfiliado(10010,"andres",10006,10000,1);
		$this->ingresarAfiliado(10011,"ricardo",10007,10007,0);
		$this->ingresarAfiliado(10012,"miguel",10007,10007,1);
		$this->ingresarAfiliado(10013,"paola",10010,10010,0);
		$this->ingresarAfiliado(10014,"fernando",10010,10010,1);
		$this->ingresarAfiliado(10015,"laura",10012,10012,0);
		$this->ingresarAfiliado(10016,"david",10012,10012,1);
		$this->ingresarAfiliado(10017,"mario",10014,10014,0);
		$this->ingresarAfiliado(10018,"andrea",10014,10014,1);
		$this->ingresarAfiliado(10019,"joan",10016,10016,0);
		$this->ingresarAfiliado(10020,"alejandro",10016,10001,1);
		$this->ingresarAfiliado(10021,"marcel",10017,10017,0);
		$this->ingresarAfiliado(10022,"daniel",10017,10017,1);
		$this->ingresarAfiliado(10023,"julian",10019,10019,0);
		$this->ingresarAfiliado(10024,"german",10019,10019,1);
		$this->ingresarAfiliado(10025,"luis",10020,10016,0);
		$this->ingresarAfiliado(10026,"alberto",10020,10020,1);
		$this->ingresarAfiliado(10027,"carolina",10022,10022,0);
		$this->ingresarAfiliado(10028,"haroll",10022,10022,1);
		$this->ingresarAfiliado(10029,"ruben",10023,10001,0);
		$this->ingresarAfiliado(10030,"marcela",10024,10001,0);
		$this->ingresarAfiliado(10031,"nelly",10026,10026,0);
		$this->ingresarAfiliado(10032,"jose",10027,10027,0);
		$this->ingresarAfiliado(10033,"johana",10027,10027,1);
	}

	private function ingresarAfiliado($id,$nombre,$debajo_de,$sponsor,$lado){
		$afiliador=new $this->modelo_bono();
		$afiliador->crearNuevoUsuario ($id,$nombre,"2016-03-17",$id,300,$debajo_de,$sponsor,$lado);
	}
	
	private function ingresarMercancia($id,$tipo,$costo,$puntos){
		
		$datosMercancia = array(
				'id_mercancia' => $id,
				'id_tipo_mercancia'   => $tipo,
				'costo'    => $costo,
				'puntos_comisionables' => $puntos,
				'id_categoria' => 250,
				'id_red' => 300
		);
		
		$this->mercancia->nuevaMercancia ($datosMercancia);
		$this->mercancia->ingresarMercancia ();
	}

	private function ingresarVentaMercanciaUsuario($id_venta,$id_usuario,$fecha,$mercanciasVendidas){
		
		$datosMercanciasVendidas=array();
		
		foreach ($mercanciasVendidas as $mercanciaId){
			$mercancia=new $this->mercancia ();
			$mercancia->setUpMercancia($mercanciaId);
			
			$datosMercancia = array(
					'id_mercancia' => $mercancia->getIdMercancia(),
					'costo_total'   => $mercancia->getCosto(),
					'puntos_comisionables'    => $mercancia->getPuntosComisionables(),
			);
			
			array_push($datosMercanciasVendidas,$datosMercancia);
		}

		
		$datosVenta = array(
				'id_venta' =>$id_venta,
				'id_usuario'   => $id_usuario,
				'estatus'    => 'ACT',
				'fecha' => $fecha,
				'mercancia'=>$datosMercanciasVendidas
		);
		
		$this->venta->nuevaVenta ($datosVenta);
		$this->venta->ingresarVenta ();
	}

	private function ingresarVentas(){

		$datosCategoria = array(
				'id_categoria' => 250,
				'id_red'   => 300,
		);
		
		$this->mercancia->ingresarCategoria ($datosCategoria);
		
		$this->ingresarMercancia(500,2,250,25);
		$this->ingresarMercancia(501,2,450,45);
		$this->ingresarMercancia(502,2,1000,10);
		

/*							RED DE AFILIACION
*           	                      __________
*           	               	     | GIOVANNY |
*           					     | ID:10000 |
*        	   	                     |  Spr:_2  |
*        							 |Comp:$1700|
*                  	       __________/           \____________
*           	          |  CARLOS  |        	  |   PEDRO  |
*           	          | ID:10001 |   		  | ID:10002 |
*        	   	          | Spr:10000|			  |Spr:10000 |
*        				  |Comp:$250 |            |Comp:$450 |
*              __________/       _____\____    ___/_______    \_________
*             |   CAMILO |      | NICOLAS  |  | ESPERANZA|   |   MARIA  |
*             | ID:10003 |   	| ID:10004 |  | ID:10005 |   | ID:10006 |
*        	  |_Spr:10001|      |_Spr:10001|  |_Spr:10000|   |_Spr:10000|
*        	  |Comp:$250 |      |Comp:$250 |  |Comp:$250 |   |Comp:$250 |
*		    ___/_____   __\_______                      _____/____     __\_______
*         | PEPE     | | DARIO    |                    |  DIEGO   |   |  ANDRES  |
*         | ID:10007 | | ID:10008 |                    | ID:10009 |   | ID:10010 |
*         |_Spr:10003| |_Spr:10001|                    |_Spr:10000|   |_Spr:10000|
*         |_Comp:$250| |Comp:$1000|                    |Comp:$450 |   |Comp:$250 |
*  _______/__   _____\____                                       _____/____    __\_______
* | RICARDO  | | MIGUEL   |                                     |  PAOLA   |   | FERNANDO |
* | ID:10011 | | ID:10012 |                                     | ID:10013 |   | ID:10014 |
* |_Spr:10007| |_Spr:10007|                                     |_Spr:10010|   |_Spr:10010|
* |_Comp:$250| |_Comp:$250|                                     |_Comp:$250|   |_Comp:$250|
*        _______/__   _____\____                                            ____/____     _\_________
*       | LAURA    | | DAVID    |                                          |  MARIO   |   | ANDREA   |
*       | ID:10015 | | ID:10016 |                                          | ID:10017 |   | ID:10018 |
*       |_Spr:10012| |_Spr:10012|                                          |_Spr:10014|   |_Spr:10014|
*       |Comp:$1000| |Comp:$1700|                                          |Comp:$500 |   |Comp:$250 |
*              _______/___  _____\____                                 ____/____      _\________
*             | JOAN     | |ALEJANDRO |                               | MARCEL   |   | DANIEL   |
*             | ID:10019 | | ID:10020 |                               | ID:10021 |   | ID:10022 |
*             |_Spr:10016| |_Spr:10001|                               |_Spr:10017|   |_Spr:10017|
*             |Comp:$250 | |Comp:$250 |\                              |Comp:$250 |   |Comp:$250 |
* __________/  _____\____   _/________  \__________                          ___________/ ___\______
*| JULIAN   | | GERMAN   | |  LUIS    | |ALBERTO   |                        | CAROLINA | | HAROLL   |
*| ID:10023 | | ID:10024 | | ID:10025 | | ID:10026 |                        | ID:10027 | | ID:10028 |
*|_Spr:10019| |_Spr:10019| |_Spr:10016| |_Spr:10020|                        |_Spr:10022| |_Spr:10022|
*|Comp:$450 | |Comp:$250 | |Comp:$250 | |Comp:$450 |                        |Comp:$450 | |Comp:$450 |
*_____|_____     ____|_____               ____|_____             __________/   ____\______
*|  RUBEN   |   |   MARCELA|             |  NELLY   |    	     |  JOSE    | | JOHANA   |
*| ID:10029 |   | ID:10030 |       	     | ID:10031 |            | ID:10032 | | ID:10033 |
*|Spr:10001 |   |Spr:10001 |             |Spr:10026 |            |_Spr:10027| |_Spr:10027|
*|Comp:$250 |   |Comp:$250 |             |Comp:$250 |            |Comp:$250 | |Comp:$250 |
*/

		$fecha=date('Y-m-d');
		
		$this->ingresarVentaMercanciaUsuario(700,10000,$fecha,array(500,501,502));
		$this->ingresarVentaMercanciaUsuario(701,10001,$fecha,array(500));
		$this->ingresarVentaMercanciaUsuario(702,10002,$fecha,array(501));
		$this->ingresarVentaMercanciaUsuario(703,10003,$fecha,array(500));
		$this->ingresarVentaMercanciaUsuario(704,10004,$fecha,array(500));
		$this->ingresarVentaMercanciaUsuario(705,10005,$fecha,array(500));
		$this->ingresarVentaMercanciaUsuario(706,10006,$fecha,array(500));
		$this->ingresarVentaMercanciaUsuario(707,10007,$fecha,array(500));
		$this->ingresarVentaMercanciaUsuario(708,10008,$fecha,array(502));
		$this->ingresarVentaMercanciaUsuario(709,10009,$fecha,array(501));
		$this->ingresarVentaMercanciaUsuario(710,10010,$fecha,array(500));
		$this->ingresarVentaMercanciaUsuario(711,10011,$fecha,array(500));
		$this->ingresarVentaMercanciaUsuario(712,10012,$fecha,array(500));
		$this->ingresarVentaMercanciaUsuario(713,10013,$fecha,array(500));
		$this->ingresarVentaMercanciaUsuario(714,10014,$fecha,array(500));
		$this->ingresarVentaMercanciaUsuario(715,10015,$fecha,array(502));
		$this->ingresarVentaMercanciaUsuario(716,10016,$fecha,array(500,501,502));
		$this->ingresarVentaMercanciaUsuario(717,10017,$fecha,array(500,500));
		$this->ingresarVentaMercanciaUsuario(718,10018,$fecha,array(500));
		$this->ingresarVentaMercanciaUsuario(719,10019,$fecha,array(500));
		$this->ingresarVentaMercanciaUsuario(720,10020,$fecha,array(500));
		$this->ingresarVentaMercanciaUsuario(721,10021,$fecha,array(500));
		$this->ingresarVentaMercanciaUsuario(722,10022,$fecha,array(500));
		$this->ingresarVentaMercanciaUsuario(723,10023,$fecha,array(501));
		$this->ingresarVentaMercanciaUsuario(724,10024,$fecha,array(500));
		$this->ingresarVentaMercanciaUsuario(725,10025,$fecha,array(500));
		$this->ingresarVentaMercanciaUsuario(726,10026,$fecha,array(501));
		$this->ingresarVentaMercanciaUsuario(727,10027,$fecha,array(501));
		$this->ingresarVentaMercanciaUsuario(728,10028,$fecha,array(501));
		$this->ingresarVentaMercanciaUsuario(729,10029,$fecha,array(500));
		$this->ingresarVentaMercanciaUsuario(730,10030,$fecha,array(500));
		$this->ingresarVentaMercanciaUsuario(731,10031,$fecha,array(500));
		$this->ingresarVentaMercanciaUsuario(732,10032,$fecha,array(500));
		$this->ingresarVentaMercanciaUsuario(733,10033,$fecha,array(500));
		
	}
}