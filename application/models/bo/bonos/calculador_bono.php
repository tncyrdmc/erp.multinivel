<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class calculador_bono extends CI_Model
{
	private $usuariosRed=array();
	private $valorCondicion;
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('/bo/bonos/bono');
		$this->load->model('/bo/bonos/condiciones_bono');
		$this->load->model('/bo/bonos/valores_bono');
		$this->load->model('/bo/bonos/activacion_bono');
		$this->load->model('/bo/bonos/repartidor_comision_bono');
		$this->load->model('/bo/bonos/afiliado');
	}
	
	public function calcularComisionesBonos(){

		$bonos=$this->getTodosLosBonos();
		foreach ($bonos as $datosBono){
			$bono=new $this->bono();
			$bono->setUpBono($datosBono->getId());
			if($this->isDisponibleCobrar($bono)){
				$this->pagarComisionesBono($bono);
			}
		}
	}
	
	public function calcularComisionesPorBono($id_bono,$fechaCalculo){
	
		$bono=new $this->bono();
		$bono->setUpBono($id_bono);
			
		if($this->isActivo($bono)&&$this->isVigentePorFecha($bono,$fechaCalculo)&&($this->isPagado($bono, $fechaCalculo)==false)){
			$this->pagarComisionesBonoPorFecha($bono,$fechaCalculo);
		}
			
	}
	
	private function pagarComisionesBono($bono) {
		$id_bono=$bono->getId();
		$red=$bono->getCondicionesBono()[0]->getIdRed();
		$usuarios=$this->getUsuariosRed($red);

		$repartidorComisionBono=new $this->repartidor_comision_bono();
		
		$frecuencia=$bono->getActivacionBono()->getFrecuencia();
		$fechaActual=date('Y-m-d');
		
		$fechaInicio=$this->getFechaInicioPagoDeBono($frecuencia,$fechaActual);
		$ano= date('Y',strtotime($fechaInicio));		
		$mes= date('m',strtotime($fechaInicio));
		$dia= date('d',strtotime($fechaInicio));
		$id_historial_pago_bono=$repartidorComisionBono->ingresarHistorialComisionBono($repartidorComisionBono->getIdHistorialTransaccion(),
															   $id_bono,$dia,$mes,$ano,
															   $fechaActual);
		
		foreach ($usuarios as $usuario){
			$id_afiliado=$usuario->id_afiliado;
			$this->darComisionRedDeAfiliado($bono,$id_historial_pago_bono,$id_afiliado,$fechaActual);
		}
	}
	
	private function pagarComisionesBonoPorFecha($bono,$fecha) {
		$id_bono=$bono->getId();
		$red=$bono->getCondicionesBono()[0]->getIdRed(); 
		$usuarios=$this->getUsuariosRed($red);
	
		$repartidorComisionBono=new $this->repartidor_comision_bono();
	
		$frecuencia=$bono->getActivacionBono()->getFrecuencia();

		$fechaActual=$fecha;

		$fechaInicio=$this->getFechaInicioPagoDeBono($frecuencia,$fechaActual);

		$ano= date('Y',strtotime($fechaInicio));
		$mes= date('m',strtotime($fechaInicio));
		$dia= date('d',strtotime($fechaInicio));
		$id_historial_pago_bono=$repartidorComisionBono->ingresarHistorialComisionBono($repartidorComisionBono->getIdHistorialTransaccion(),
				$id_bono,$dia,$mes,$ano,
				$fechaActual);
	
		foreach ($usuarios as $usuario){
			$id_afiliado=$usuario->id_afiliado;
			$this->darComisionRedDeAfiliado($bono,$id_historial_pago_bono,$id_afiliado,$fechaActual);
		}
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
	
	public function isVigentePorFecha($bono,$fecha){
	
		$fechaInicio=$bono->getActivacionBono()->getInicio();
		$fechaFin=$bono->getActivacionBono()->getFin();
	
		if($fecha>=$fechaInicio&&$fecha<=$fechaFin)
			return true;
		return false;
	}

	public function isDisponibleCobrar($bono){
		$fecha=date('Y-m-d');
		
		if($this->isActivo($bono)&&$this->isVigente($bono)&&($this->isPagado($bono, $fecha)==false)){
			return true;
		}
		return false;
	}

	public function isBonoBinario($tipo_bono){
		if($tipo_bono=='SI')
			return true;
		return false;
	}
	
	public function isPagado($bono,$fecha){
		$id_bono=$bono->getId();

		$frecuencia=$bono->getActivacionBono()->getFrecuencia();
		$fechaActual=$fecha;
		
		$fechaInicio=$this->getFechaInicioPagoDeBono($frecuencia,$fechaActual);
		$ano= date('Y',strtotime($fechaInicio));
		$mes= date('m',strtotime($fechaInicio));
		$dia= date('d',strtotime($fechaInicio));
		
		$q=$this->db->query("SELECT * FROM comision_bono_historial
								where id_bono=".$id_bono."
								and dia=".$dia."
								and mes=".$mes."
								and ano=".$ano."");


		$idTransaccion=$q->result();

		if($idTransaccion==NULL)
			return false;
		
		return true;	
		
	}
	
	public function darComisionRedDeAfiliado($bono,$id_bono_historial,$id_usuario,$fecha){
		$id_bono=$bono->getId();
		if($this->usuarioPuedeCobrarBono($id_bono,$id_usuario,$fecha)){

			$red=$bono->getCondicionesBono()[0]->getIdRed();

			$valores=$bono->getValoresBono();

			foreach ($valores as $valor){
				$this->repartirComisionSegunTipoDeReparticion( $id_bono,$id_bono_historial,$id_usuario,$red,$valor->getNivel(),$valor->getValor(),$valor->getCondicionRed(),$valor->getVerticalidad() );
			}
		}
	}
	
	private function repartirComisionSegunTipoDeReparticion($id_bono,$id_bono_historial,$id_usuario,$red,$nivel,$valor,$condicion_red,$verticalidad) {

		if(($verticalidad=="ASC")||($verticalidad=="DESC")){
			if($nivel==0){
				$repartidorComisionBono=new $this->repartidor_comision_bono();
				$repartidorComisionBono->repartirComisionBono($repartidorComisionBono->getIdTransaccionPagoBono(),$id_usuario,$id_bono,$id_bono_historial,$valor);
			}else {
				$this->repartirComisionesBonoEnLaRed ( $id_bono,$id_bono_historial,$id_usuario,$red,$nivel,$valor,$condicion_red,$verticalidad);
			}
			
		}else if($verticalidad=="PDES"){
			if($nivel==0){
				$repartidorComisionBono=new $this->repartidor_comision_bono();
				$valorTotal=(($this->valorCondicion*$valor)/100);
				$repartidorComisionBono->repartirComisionBono($repartidorComisionBono->getIdTransaccionPagoBono(),$id_usuario,$id_bono,$id_bono_historial,$valorTotal);
			}else {
				
				/* 
				 *  FALTA PROGRAMAR
				 * 
				 */
				//$this->repartirComisionesBonoEnLaRed ( $id_bono,$id_bono_historial,$id_usuario,$red,$nivel,$valor,$condicion_red,$verticalidad);
			
			
			}
		}
	}

	private function repartirComisionesBonoEnLaRed($id_bono,$id_bono_historial,$id_usuario,$red,$nivel,$valor,$condicionRed,$verticalidad) {
		$repartidorComisionBono=new $this->repartidor_comision_bono();
		$usuario=new $this->afiliado();
		$usuario->getAfiliadosPorNivel($id_usuario,$red,$nivel,$condicionRed,1,$verticalidad);
		$afiliados=$usuario->getIdAfiliadosRed();
		
		foreach ($afiliados as $idAfiliado){
			$repartidorComisionBono->repartirComisionBono($repartidorComisionBono->getIdTransaccionPagoBono(),$idAfiliado,$id_bono,$id_bono_historial,$valor);
		}
	}
	
	public function usuarioPuedeCobrarBono($id_bono,$id_usuario,$fechaActual){
		$bono=$this->bono;
		$bono->setUpBono($id_bono);
		
		$esUnPlanBinario=$bono->getTipoBono();

		$frecuencia=$bono->getActivacionBono()->getFrecuencia();
		
		if($frecuencia=="UNI"){
			if($this->buscarSiUsuarioYaReclamoBono($id_bono,$id_usuario)){
				return false;
			}
		}
		
	
		$fechaInicio=$this->getFechaInicioPagoDeBono($frecuencia,$fechaActual);
		$fechaFin=$this->getFechaFinPagoDeBono($frecuencia,$fechaActual);
		
		$resultadoBinario=true;
		
		foreach ($bono->getCondicionesBono() as $condicionBono){
			
			$red=$condicionBono->getIdRed();
			$profundidadRed=$condicionBono->getNivelRed();
			$tipoDeAfiliados=$condicionBono->getCondicionRed();
			$tipoDeCondicion=$condicionBono->getIdTipoRango();
			$valorCondicion=$condicionBono->getValor();
			$tipoDeBusquedaEnLaRed=$condicionBono->getCondicionAfiliadosRed();
			$condicion1=$condicionBono->getCondicionBono1();
			$condicion2=$condicionBono->getCondicionBono2();
			
			$valor = $this->getValorCondicionUsuario ($id_bono,$esUnPlanBinario, $tipoDeCondicion,$id_usuario,$red,$tipoDeAfiliados,$tipoDeBusquedaEnLaRed,$profundidadRed,$fechaInicio,$fechaFin ,$condicion1,$condicion2);
			
			if($esUnPlanBinario=="SI"){
				if($valor<$valorCondicion&&$resultadoBinario==true)
					$resultadoBinario=false;
			}else {
				if($valor<$valorCondicion)
					return false;
			}
		}
		
		if($esUnPlanBinario=="SI"){
			return $resultadoBinario;
		}
		
		return true;
	}
	
	public function buscarSiUsuarioYaReclamoBono($id_bono,$id_usuario){
		$q=$this->db->query("SELECT * FROM comision_bono where id_bono=".$id_bono." and id_usuario=".$id_usuario."");
		$datosBonoCobrado=$q->result();
		
		if($datosBonoCobrado==NULL)
			return false;
		
		return true;
	}
	
	public function getFechaInicioPagoDeBono($frecuencia,$fechaActual){
		if($frecuencia=="SEM")
			return $this->getInicioSemana($fechaActual);
		else if($frecuencia=="QUI")
			return $this->getInicioQuincena($fechaActual);
		else if($frecuencia=="MES")
			return $this->getInicioMes($fechaActual);
		else if($frecuencia=="ANO")
			return $this->getInicioAno($fechaActual);
		else if($frecuencia=="UNI")
			return "2016-01-01";
	}
	
	public function getFechaFinPagoDeBono($frecuencia,$fechaActual){
		if($frecuencia=="SEM")
			return $this->getFinSemana($fechaActual);
		else if($frecuencia=="QUI")
			return $this->getFinQuincena($fechaActual);
		else if($frecuencia=="MES")
			return $this->getFinMes($fechaActual);
		else if($frecuencia=="ANO")
			return $this->getFinAno($fechaActual);
		else if($frecuencia=="UNI")
			return "2090-01-01";
	}
	
	private function getValorCondicionUsuario($id_bono,$esUnPlanBinario,$tipoDeCondicion,$id_usuario,$red,$tipoDeAfiliados,$tipoDeBusquedaEnLaRed,$profundidadRed,$fechaInicio,$fechaFin,$condicion1,$condicion2) {
		$usuario= new $this->afiliado ();
		$usuario->setTipoDeBono($esUnPlanBinario);
		$usuario->setIdBono($id_bono);
		$valor=0;
		
		/* Afiliados a la red   =1;
		 * Ventas de la red     =2;
		 * Compras Personales   =3;
		 * Puntos Comisionables =4;
		 * Puntos  red          =5
		 */
		switch ($tipoDeCondicion){
			case 1:{
				$valor=$usuario->getAfiliadosIntervaloDeTiempo($id_usuario,$red,"DIRECTOS",$tipoDeBusquedaEnLaRed,0,$fechaInicio,$fechaFin);
				break;
			}
			case 2:{
				$valor=$usuario->getVentasTodaLaRed($id_usuario,$red,$tipoDeAfiliados,$tipoDeBusquedaEnLaRed,$profundidadRed,$fechaInicio,$fechaFin,$condicion1,$condicion2,"COSTO");
				break;
			}
			case 3:{
				$valor=$usuario->getComprasPersonalesIntervaloDeTiempo($id_usuario,$red,$fechaInicio,$fechaFin,$condicion1,$condicion2,"COSTO");
				break;
			}
			case 4:{
				$valor=$usuario->getComprasPersonalesIntervaloDeTiempo($id_usuario,$red,$fechaInicio,$fechaFin,$condicion1,$condicion2,"PUNTOS");
				break;
			}
			case 5:{
				$valor=$usuario->getVentasTodaLaRed($id_usuario,$red,$tipoDeAfiliados,$tipoDeBusquedaEnLaRed,$profundidadRed,$fechaInicio,$fechaFin,$condicion1,$condicion2,"PUNTOS");
				break;
			}
		}
		$this->setValorCondicion($valor);
		return $valor;
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
	
	public function getInicioAno($date) {
		$year = new DateTime($date);
		$year->setDate($year->format('Y'), 1, 1);
		return date_format($year, 'Y-m-d');
	}
	
	public function getFinAno($date) {
		$year = new DateTime($date);
		$year->setDate($year->format('Y'), 12, 31);
		return date_format($year, 'Y-m-d');
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
	
	public function getValorCondicion() {

		return $this->valorCondicion;
	}
	
	public function setValorCondicion($valorCondicion) {
		$this->valorCondicion = $valorCondicion;
		return $this;
	}
}