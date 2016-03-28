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
		$this->load->model('/bo/bonos/repartidor_comision_bono');
		$this->load->model('/bo/bonos/afiliado');
	}
	
	public function calcularComisionesBonos(){

		$bonos=$this->getTodosLosBonos();
		foreach ($bonos as $datosBono){
			$bono=new $this->bono();
			$bono->setUpBono($datosBono->getId());
			if($this->isDisponibleCobrar($bono)){
				$this->pagarComisionesBono($datosBono->getId());
			}
		}
	}
	private function pagarComisionesBono($id_bono) {
		$bono=new $this->bono();
		$bono->setUpBono($id_bono);
		$red=$bono->getCondicionesBono()->getIdRed();
		$usuarios=$this->getUsuariosRed($red);
		
		foreach ($usuarios as $usuario){
			$id_afiliado=$usuario->id_afiliado;
			if ($this->usuarioPuedeCobrarBono($id_bono, $id_afiliado)){
				$this->darComisionRedDeAfiliado($id_bono,1,$id_afiliado);
			}
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
	
	public function darComisionRedDeAfiliado($id_bono,$id_bono_historial,$id_usuario){

		if($this->usuarioPuedeCobrarBono($id_bono,$id_usuario)){
			
			$bono=new $this->bono();
			$bono->setUpBono($id_bono);
			$red=$bono->getCondicionesBono()->getIdRed();

			$valores=$bono->getValoresBono();

			foreach ($valores as $valor){
				if($valor->getNivel()==0){
					$repartidorComisionBono=new $this->repartidor_comision_bono();
					$repartidorComisionBono->repartirComisionBono($this->getIdTransaccion(),$id_usuario,$id_bono,$id_bono_historial,$valor->getValor());
				}else {
					$this->repartirComisionesBonoEnLaRed ( $id_bono,$id_bono_historial,$id_usuario,$red,$valor->getNivel(),$valor->getValor(),$valor->getCondicionRed(),$valor->getVerticalidad());
				}
			}
		
		}
	}
	
	private function repartirComisionesBonoEnLaRed($id_bono,$id_bono_historial,$id_usuario,$red,$nivel,$valor,$condicionRed,$verticalidad) {
		$repartidorComisionBono=new $this->repartidor_comision_bono();
		$usuario=new $this->afiliado();
		$usuario->getAfiliadosPorNivel($id_usuario,$red,$nivel,$condicionRed,1,$verticalidad);
		$afiliados=$usuario->getIdAfiliadosRed();
		
		foreach ($afiliados as $idAfiliado){
			$repartidorComisionBono->repartirComisionBono($this->getIdTransaccion(),$idAfiliado,$id_bono,$id_bono_historial,$valor);
		}
	}
	
	public function usuarioPuedeCobrarBono($id_bono,$id_usuario){
		$bono=$this->bono;
		$bono->setUpBono($id_bono);
		
		$red=$bono->getCondicionesBono()->getIdRed();
		$profundidadRed=$bono->getCondicionesBono()->getNivelRed();
		$tipoDeAfiliados=$bono->getCondicionesBono()->getCondicionRed();
		$tipoDeCondicion=$bono->getCondicionesBono()->getIdTipoRango();
		$valorCondicion=$bono->getCondicionesBono()->getValor();
		$tipoDeBusquedaEnLaRed=$bono->getCondicionesBono()->getCondicionAfiliadosRed();
		$condicion1=$bono->getCondicionesBono()->getCondicionBono1();
		$condicion2=$bono->getCondicionesBono()->getCondicionBono2();
		
		$fechaInicio=$bono->getActivacionBono()->getInicio();
		$fechaFin=$bono->getActivacionBono()->getFin();

		$valor = $this->getValorCondicionUsuario ( $tipoDeCondicion,$id_usuario,$red,$tipoDeAfiliados,$tipoDeBusquedaEnLaRed,$profundidadRed,$fechaInicio,$fechaFin ,$condicion1,$condicion2);

		if($valor>=$valorCondicion)
			return TRUE;
		return false;
	}
	
	private function getValorCondicionUsuario($tipoDeCondicion,$id_usuario,$red,$tipoDeAfiliados,$tipoDeBusquedaEnLaRed,$profundidadRed,$fechaInicio,$fechaFin,$condicion1,$condicion2) {
		$usuario= new $this->afiliado ();
		$valor=0;
		
		/* Afiliados a la red   =1;
		 * Ventas de la red     =2;
		 * Compras Personales   =3;
		 * Puntos Comisionables =4;
		 * Puntos  red          =5
		 */
		switch ($tipoDeCondicion){
			case 1:{
				$valor=$usuario->getAfiliadosIntervaloDeTiempo($id_usuario,$red,"DIRECTOS",0,$fechaInicio,$fechaFin);
				break;
			}
			case 2:{
				$valor=$usuario->getVentasTodaLaRed($id_usuario,$red,$tipoDeAfiliados,$tipoDeBusquedaEnLaRed,$profundidadRed,$fechaInicio,$fechaFin,$condicion2,"COSTO");
				break;
			}
			case 3:{
				$valor=$usuario->getComprasPersonalesIntervaloDeTiempo($id_usuario,$red,$fechaInicio,$fechaFin,$condicion2,"COSTO");
				break;
			}
			case 4:{
				$valor=$usuario->getComprasPersonalesIntervaloDeTiempo($id_usuario,$red,$fechaInicio,$fechaFin,$condicion2,"PUNTOS");
				break;
			}
			case 5:{
				$valor=$usuario->getVentasTodaLaRed($id_usuario,$red,$tipoDeAfiliados,$tipoDeBusquedaEnLaRed,$profundidadRed,$fechaInicio,$fechaFin,$condicion2,"PUNTOS");
				break;
			}
		}

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
	
	private function getIdTransaccion(){
		$q=$this->db->query("SELECT id FROM comision_bono order by id desc limit 0,1");
		$idTransaccion=$q->result();
		if($idTransaccion==NULL)
			return 1;
		return $idTransaccion[0]->id+1;

	}
	
}