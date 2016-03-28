<?php
class testCalculadorDeBonos extends CI_Controller {


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
		$this->ingresarBonos();
		$this->ingresarRedDeAfiliacion();
	}
	
	private function after(){
		$this->modelo_bono->limpiarTodosLosBonos();
		$this->afiliado->eliminarUsuarios();
		$this->red->eliminarRed();
	}
	
	public function index(){
		$this->Before();
		$this->testGetBonosActivosPorCobrar();
		$this->after();
		
		$this->Before();
		$this->testGetUsuariosDeLaRedtestGetUsuariosDeLaRed();
		$this->after();
	}

	public function testGetBonosActivosPorCobrar(){
		$calculadorBono=new $this->calculador_bono();
		$bono=$this->bono;
		
		$this->bono->setUpBono(50);
		$resultado=$calculadorBono->isDisponibleCobrar($bono);
		echo $this->unit->run(true,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);

		$this->bono->setUpBono(51);
		$resultado=$calculadorBono->isDisponibleCobrar($bono);
		echo $this->unit->run(false,$resultado, 'Test set Base de datos No Esta disponible Para Cobrar porque esta desactivado','Resultado es :'.$resultado);
		
		$this->bono->setUpBono(52);
		$resultado=$calculadorBono->isDisponibleCobrar($bono);
		echo $this->unit->run(false,$resultado, 'Test set Base de datos No Esta disponible Para Cobrar porque no esta vigente','Resultado es :'.$resultado);
		
		$bonos=$calculadorBono->getTodosLosBonos();

		$resultado=$calculadorBono->isDisponibleCobrar($bonos[0]);
		echo $this->unit->run(true,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$calculadorBono->isDisponibleCobrar($bonos[1]);
		echo $this->unit->run(false,$resultado, 'Test set Base de datos No Esta disponible Para Cobrar porque esta desactivado','Resultado es :'.$resultado);
		
		$resultado=$calculadorBono->isDisponibleCobrar($bonos[2]);
		echo $this->unit->run(false,$resultado, 'Test set Base de datos No Esta disponible Para Cobrar porque no esta vigente','Resultado es :'.$resultado);
		
		$resultado=$calculadorBono->isDisponibleCobrar($bonos[3]);
		echo $this->unit->run(true,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
	}

	public function testGetUsuariosDeLaRedtestGetUsuariosDeLaRed(){
		$calculadorBono=new $this->calculador_bono();

		$usuarios=$calculadorBono->getUsuariosRed(300);
		
		$resultado=$usuarios[0]->id_afiliado;
		echo $this->unit->run(10000,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[1]->id_afiliado;
		echo $this->unit->run(10001,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[2]->id_afiliado;
		echo $this->unit->run(10002,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[3]->id_afiliado;
		echo $this->unit->run(10003,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[4]->id_afiliado;
		echo $this->unit->run(10004,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[5]->id_afiliado;
		echo $this->unit->run(10005,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[6]->id_afiliado;
		echo $this->unit->run(10006,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[7]->id_afiliado;
		echo $this->unit->run(10007,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[8]->id_afiliado;
		echo $this->unit->run(10008,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[9]->id_afiliado;
		echo $this->unit->run(10009,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[10]->id_afiliado;
		echo $this->unit->run(10010,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[11]->id_afiliado;
		echo $this->unit->run(10011,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[12]->id_afiliado;
		echo $this->unit->run(10012,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[13]->id_afiliado;
		echo $this->unit->run(10013,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[14]->id_afiliado;
		echo $this->unit->run(10014,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[15]->id_afiliado;
		echo $this->unit->run(10015,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[16]->id_afiliado;
		echo $this->unit->run(10016,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[17]->id_afiliado;
		echo $this->unit->run(10017,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[18]->id_afiliado;
		echo $this->unit->run(10018,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[19]->id_afiliado;
		echo $this->unit->run(10019,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[20]->id_afiliado;
		echo $this->unit->run(10020,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[21]->id_afiliado;
		echo $this->unit->run(10021,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[22]->id_afiliado;
		echo $this->unit->run(10022,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[23]->id_afiliado;
		echo $this->unit->run(10023,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[24]->id_afiliado;
		echo $this->unit->run(10024,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[25]->id_afiliado;
		echo $this->unit->run(10025,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[26]->id_afiliado;
		echo $this->unit->run(10026,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[27]->id_afiliado;
		echo $this->unit->run(10027,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[28]->id_afiliado;
		echo $this->unit->run(10028,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[29]->id_afiliado;
		echo $this->unit->run(10029,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[30]->id_afiliado;
		echo $this->unit->run(10030,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[31]->id_afiliado;
		echo $this->unit->run(10031,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[32]->id_afiliado;
		echo $this->unit->run(10032,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		$resultado=$usuarios[33]->id_afiliado;
		echo $this->unit->run(10033,$resultado, 'Test set Base de datos Esta disponible Para Cobrar','Resultado es :'.$resultado);
		
		
	
	}
	private function ingresarBonos(){
		$this->modelo_bono->limpiarTodosLosBonos();
		
//----------------------------BONO 1 ------------------------------------------------
		$puntosComisionables=4;
		$infinito=0;
		$servicios=2;
		$id_mercancia=145;
		
		$datosRango = array(
				'id_rango' => 60,
				'nombre_rango'   => "Bluetooth",
				'descripcion_rango'    => "Bluetooth",
				'id_tipo_rango' => $puntosComisionables,
				'valor'   => 110,
				'condicion_red'    => "RED",
				'nivel_red'   => $infinito,
				'id_condicion' => 1,
				'id_red'   => 26,
				'condicion_red_afilacion'    => "EQU",
				'condicion1'    => $servicios,
				'condicion2'	=> $id_mercancia,
				'estatus_rango'	=> 'ACT'
		);
		
		$inicioAfiliacion=0;
		$fechaActual=0;
		
		$datosBono = array(
				'id_bono' => 50,
				'nombre_bono'   => "Bono Bluetooth",
				'descripcion_bono'    => "Bono Bluetooth",
				'plan'	=> "NO",
				'inicio' => '2015-01-01',
				'fin'   => '2026-01-01',
				'frecuencia'    => "MES",
				'mes_desde_afiliacion'	=> $inicioAfiliacion,
				'mes_desde_activacion'	=> $fechaActual,
				'estatus_bono' => "ACT"
		);
		
		
		$datosValoresBono=array();
		
		$datosValoresBonoAfiliado = array(
				'id_valor' => 1,
				'id_rango'   => 50,
				'nivel'    => 0,
				'condicion_red'    => "RED",
				'valor'	=> 0
		);
		
		
		array_push($datosValoresBono, $datosValoresBonoAfiliado);
		$nuevoBono=new $this->modelo_bono();
		$nuevoBono->nuevoBono ($datosRango,$datosBono,$datosValoresBono);
		$nuevoBono->ingresarBono ();
		
		
		
		//----------------------------BONO 2 ------------------------------------------------
		$puntosComisionables=4;
		$infinito=0;
		$servicios=2;
		$id_mercancia=145;
		
		$datosRango = array(
				'id_rango' => 61,
				'nombre_rango'   => "Bluetooth",
				'descripcion_rango'    => "Bluetooth",
				'id_tipo_rango' => $puntosComisionables,
				'valor'   => 110,
				'condicion_red'    => "RED",
				'nivel_red'   => $infinito,
				'id_condicion' => 2,
				'id_red'   => 26,
				'condicion_red_afilacion'    => "EQU",
				'condicion1'    => $servicios,
				'condicion2'	=> $id_mercancia,
				'estatus_rango'	=> 'ACT'
		);
		
		$inicioAfiliacion=0;
		$fechaActual=0;
		
		$datosBono = array(
				'id_bono' => 51,
				'nombre_bono'   => "Bono Bluetooth",
				'descripcion_bono'    => "Bono Bluetooth",
				'plan'	=> "NO",
				'inicio' => '2015-01-01',
				'fin'   => '2026-01-01',
				'frecuencia'    => "MES",
				'mes_desde_afiliacion'	=> $inicioAfiliacion,
				'mes_desde_activacion'	=> $fechaActual,
				'estatus_bono' => "DES"
		);
		
		
		$datosValoresBono=array();
		
		$datosValoresBonoAfiliado = array(
				'id_valor' => 2,
				'id_rango'   => 51,
				'nivel'    => 0,
				'condicion_red'    => "RED",
				'valor'	=> 0
		);
		
		
		array_push($datosValoresBono, $datosValoresBonoAfiliado);
		$nuevoBono=new $this->modelo_bono();
		$nuevoBono->nuevoBono ($datosRango,$datosBono,$datosValoresBono);
		$nuevoBono->ingresarBono ();

		
		//----------------------------BONO 3 ------------------------------------------------
		$puntosComisionables=4;
		$infinito=0;
		$servicios=2;
		$id_mercancia=145;
		
		$datosRango = array(
				'id_rango' => 62,
				'nombre_rango'   => "Bluetooth",
				'descripcion_rango'    => "Bluetooth",
				'id_tipo_rango' => $puntosComisionables,
				'valor'   => 110,
				'condicion_red'    => "RED",
				'nivel_red'   => $infinito,
				'id_condicion' => 3,
				'id_red'   => 26,
				'condicion_red_afilacion'    => "EQU",
				'condicion1'    => $servicios,
				'condicion2'	=> $id_mercancia,
				'estatus_rango'	=> 'ACT'
		);
		
		$inicioAfiliacion=0;
		$fechaActual=0;
		
		$datosBono = array(
				'id_bono' => 52,
				'nombre_bono'   => "Bono Bluetooth",
				'descripcion_bono'    => "Bono Bluetooth",
				'plan'	=> "NO",
				'inicio' => '2015-01-01',
				'fin'   => '2016-03-25',
				'frecuencia'    => "MES",
				'mes_desde_afiliacion'	=> $inicioAfiliacion,
				'mes_desde_activacion'	=> $fechaActual,
				'estatus_bono' => "ACT"
		);
		
		
		$datosValoresBono=array();
		
		$datosValoresBonoAfiliado = array(
				'id_valor' => 3,
				'id_rango'   => 52,
				'nivel'    => 0,
				'condicion_red'    => "RED",
				'valor'	=> 0
		);
		
		
		array_push($datosValoresBono, $datosValoresBonoAfiliado);
		$nuevoBono=new $this->modelo_bono();
		$nuevoBono->nuevoBono ($datosRango,$datosBono,$datosValoresBono);
		$nuevoBono->ingresarBono ();
		
		//----------------------------BONO 4 ------------------------------------------------
		$puntosComisionables=4;
		$infinito=0;
		$servicios=2;
		$id_mercancia=145;
		
		$datosRango = array(
				'id_rango' => 63,
				'nombre_rango'   => "Bluetooth",
				'descripcion_rango'    => "Bluetooth",
				'id_tipo_rango' => $puntosComisionables,
				'valor'   => 110,
				'condicion_red'    => "RED",
				'nivel_red'   => $infinito,
				'id_condicion' => 4,
				'id_red'   => 26,
				'condicion_red_afilacion'    => "EQU",
				'condicion1'    => $servicios,
				'condicion2'	=> $id_mercancia,
				'estatus_rango'	=> 'ACT'
		);
		
		$inicioAfiliacion=0;
		$fechaActual=0;
		
		$datosBono = array(
				'id_bono' => 53,
				'nombre_bono'   => "Bono Bluetooth",
				'descripcion_bono'    => "Bono Bluetooth",
				'plan'	=> "NO",
				'inicio' => '2016-03-26',
				'fin'   => '2026-03-25',
				'frecuencia'    => "MES",
				'mes_desde_afiliacion'	=> $inicioAfiliacion,
				'mes_desde_activacion'	=> $fechaActual,
				'estatus_bono' => "ACT"
		);
		
		
		$datosValoresBono=array();
		
		$datosValoresBonoAfiliado = array(
				'id_valor' => 4,
				'id_rango'   => 53,
				'nivel'    => 0,
				'condicion_red'    => "RED",
				'valor'	=> 0
		);
		
		
		array_push($datosValoresBono, $datosValoresBonoAfiliado);
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
		$this->ingresarAfiliado(10005,"esperanza",10001,10000,0);
		$this->ingresarAfiliado(10006,"maria",10001,10000,1);
		$this->ingresarAfiliado(10007,"pepe",10001,10003,0);
		$this->ingresarAfiliado(10008,"dario",10001,10001,1);
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
		$this->ingresarAfiliado(10031,"nelly",10026,10031,0);
		$this->ingresarAfiliado(10032,"jose",10027,10027,0);
		$this->ingresarAfiliado(10033,"johana",10027,10027,1);
	}

	private function ingresarAfiliado($id,$nombre,$debajo_de,$sponsor,$lado){
		$afiliador=new $this->modelo_bono();
		$afiliador->crearNuevoUsuario ($id,$nombre,"2016-03-17",$id,300,$debajo_de,$sponsor,$lado);
	}
	
}