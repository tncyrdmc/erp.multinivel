<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
require_once APPPATH.'controllers/ov/compras.php';

class cuentasporcobrar extends compras{
	function __construct() {
		parent::__construct ();
		
		$this->load->model ( 'bo/modelo_dashboard' );
	}
	
	function index() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		
		if(!$this->general->isAValidUser($id,"administracion"))
		{
			redirect('/auth/logout');
		}
		
		$usuario=$this->general->get_username($id);
		
		$style = $this->modelo_dashboard->get_style(1);
		
		
		$cobros = $this->modelo_historial_consignacion->ListarHistorialPendiente ();
		
		$this->template->set ( "style", $style );
		$this->template->set ( "usuario", $usuario );
		$this->template->set ( "cobros", $cobros );
		
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/administracion/CuentasCobrar/listar' );
	}
	
	function cambiar_estado(){
		
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		
		if(!$this->general->isAValidUser($id,"administracion"))
		{
			redirect('/auth/logout');
		}

		
		if(isset($_POST['id_venta'])){
			$id_venta = $_POST['id_venta'];
			
	
			$datosCuentaPagar = $this->modelo_historial_consignacion->getDatosPagoBanco($id_venta);

			if(!$datosCuentaPagar)
				echo  "No se ha podido realizar el cambio de estado de la peticion.";
			
			$id_afiliado_comprador=$datosCuentaPagar[0]->id_usuario;

			$this->pagarComisionVenta($id_venta,$id_afiliado_comprador);
			
			$this->modelo_historial_consignacion->CambiarEstadoPago($id_venta, $datosCuentaPagar[0]->id);
		
			echo  "La petición se ha cambiado de estado a pago y ha calculado las comisiones.";
		
		}else{
			echo  "No se ha podido realizar el cambio de estado de la peticion.";
		
		}
		
	}
	
	function cambiar_estado_cancelado(){
		$id_venta = $_POST['id_venta'];
		
		$estadoCuenta=$this->modelo_historial_consignacion->getEstadoPagoBanco($id_venta);
		
		if(!$estadoCuenta){
			echo "Ya se han eliminado todos los datos de la venta";
			return false;
		}

		$this->modelo_historial_consignacion->CambiarEstadoCancelado($id_venta);
		echo  "Se han eliminado todos los datos de la venta.";
	}
	
	private function pagarComisionVenta($id_venta,$id_afiliado_comprador){
		$mercancias = $this->modelo_compras->consultarMercanciaTotalVenta($id_venta);
		
		foreach ($mercancias as $mercancia){
			
			$id_red_mercancia = $this->modelo_compras->ObtenerCategoriaMercancia($mercancia->id);
			$costoVenta=$mercancia->costo_unidad_total;

			$this->calcularComisionAfiliado($id_venta,$id_red_mercancia,$costoVenta,$id_afiliado_comprador);
				
		}
		

	}
	
	private function calcularComisionAfiliado($id_venta,$id_red_mercancia,$costoVenta,$id_afiliado){
		
		$valor_comision_por_nivel = $this->modelo_compras->ValorComision($id_red_mercancia);
		$capacidad_red = $this->model_tipo_red->CapacidadRed($id_red_mercancia);
		$profundidadRed=$capacidad_red[0]->profundidad;

		
		for($i=0;$i<$profundidadRed;$i++){
			
			$afiliado_padre = $this->model_perfil_red->ConsultarIdPadre($id_afiliado,$id_red_mercancia);
			
			if(!$afiliado_padre||$afiliado_padre[0]->debajo_de==1)
				return false;
			
			$id_afiliado_padre=$afiliado_padre[0]->debajo_de;
			
			$valor_comision=(($valor_comision_por_nivel[$i]->valor*$costoVenta)/100);
			
			$this->modelo_compras->set_comision_afiliado($id_venta,$id_red_mercancia,$id_afiliado_padre,$valor_comision);
			
			$id_afiliado=$id_afiliado_padre;
		}

	}
	
/*							//	   $historico
	private function ComisionBanco($datosCuentaPagar,$id_red_mercancia){
		$this->CalcularComision2($datosCuentaPagar[0]->id_venta, $id_red_mercancia,$valor_comision_por_nivel, $capacidad_red ,1,$datosCuentaPagar[0]->costo_unidad);
		
	}
	*/
	private function EnvarMail($id_historial){
		$datos = $this->modelo_historial_consignacion->Datos_Email($id_historial);
		
		$cobro['username'] = $datos[0]->username;
		$cobro['nombre'] = $datos[0]->nombre;
		$cobro['apellido'] = $datos[0]->apellido;
		$cobro['id_venta'] = $datos[0]->id_venta;
		$cobro['banco'] = $datos[0]->banco;
		$cobro['cuenta'] = $datos[0]->cuenta;
		$cobro['valor'] = $datos[0]->valor;
		$cobro['email'] = $datos[0]->email;
		$cobro['fecha'] = $datos[0]->fecha;
		
		$this->load->library('email');
		$this->email->from($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->to($datos[0]->email);
		$this->email->subject('Confirmacion de pago por Banco');
		$this->email->message($this->load->view('email/CuentasCobrar-html', $cobro, TRUE));
		//$this->email->set_alt_message($this->load->view('email/activate-txt', $data, TRUE));
		$this->email->send();
	}
}