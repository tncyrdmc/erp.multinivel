<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class POS extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
		$this->load->model('bo/modelo_dashboard');
		$this->load->model('bo/model_admin');
		$this->load->model('bo/model_mercancia');
		$this->load->model('bo/model_inventario');
		$this->load->model('bo/modelo_logistico');
		$this->load->model('bo/modelo_cedi');
		$this->load->model('bo/general');
	}

	function index()
	{
		if (!$this->tank_auth->is_logged_in()) 
		{																		// logged in
			redirect('/auth');
		}
		
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		
		$style=$this->modelo_dashboard->get_style($id);
		$this->template->set("cajero",$usuario[0]->nombre." ".$usuario[0]->apellido);
		$data = array("user" => $usuario[0]->nombre."<br/>".$usuario[0]->apellido);
		$this->template->set("style",$style);

		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/CEDI/header',$data);
        $this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/CEDI/pos/caja');
	}
	
	function new_item()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
		$style=$this->modelo_dashboard->get_style($id);
		
		$this->template->build('website/CEDI/pos/crearItem');
	}
	
	function ver_cobro()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		
		$descuento = $_POST['desc'];
	
		$almacen  = $this->modelo_cedi->getUsuarioId($id);
		$users = $this->modelo_cedi->getClientes();
		$id_temporal = $this->modelo_cedi->setIdTemporal ( $id, $almacen[0]->cedi );
	
		$total = $this->modelo_cedi->getTotalNeto($id_temporal);		
		$total -= ($total * $descuento)/100;		
		
		$this->template->set("valor",$total);
		$this->template->set("users",$users);
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->build('website/CEDI/pos/verContado');
	}
	
	function facturar()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
		$saldo =  $_POST['saldo'];
		$pago = $_POST['pago'];
		$user = $_POST['user'];
		
		$almacen  = $this->modelo_cedi->getUsuarioId($id);
		
		$id_temporal = $this->modelo_cedi->setIdTemporal ( $id, $almacen[0]->cedi );
		
		$datos = $this->modelo_cedi->registrarVenta($id_temporal,$pago,$user);
		
		$style=$this->modelo_dashboard->get_style($id);
		$this->template->set("cajero",$usuario[0]->nombre." ".$usuario[0]->apellido);
		$data = array("user" => $usuario[0]->nombre."<br/>".$usuario[0]->apellido);
		
		$this->template->set("style",$style);
		$this->template->set("saldo",$saldo);
		$this->template->set("pago",$pago);

		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/CEDI/header',$data);
        $this->template->set_partial('footer', 'website/bo/footer');
	
		$this->template->build('website/CEDI/pos/factura');
	}
	
	function descuento()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		
		$item =  $_POST['item'];
		$this->template->set("item",$item);
		
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->build('website/CEDI/pos/descontar');
	}
	
	function descontar(){
	
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
		$item =  $_POST['item'];
		$descuento =  $_POST['descuento'];
		$tipo =  $_POST['tipo'];
		
		
		$almacen  = $this->modelo_cedi->getUsuarioId($id);
	
		$id_temporal = $this->modelo_cedi->setIdTemporal ( $id, $almacen[0]->cedi );
	
		$this->modelo_cedi->setDescuento($id_temporal,$item,$descuento,$tipo);
	
		$pedidos = $this->modelo_cedi->getTemporal ($id_temporal);
		
		$this->printItems($pedidos);
	
	}
	
	function setCosto(){
	
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
		$costo =  $_POST['costo'];	
	
		$almacen  = $this->modelo_cedi->getUsuarioId($id);
	
		$id_temporal = $this->modelo_cedi->setIdTemporal ( $id, $almacen[0]->cedi );
	
		$this->modelo_cedi->updateTemporal($id_temporal,'costo',$costo);
	
		$pedidos = $this->modelo_cedi->getTemporal ($id_temporal);
	
		$this->printItems($pedidos);
	
	}
	
	function existeProducto(){
		
		$id = $_POST['item'];
		$producto = $this->model_mercancia->getProductoBy($id);
		if($producto){
			foreach ($producto as $item){
				echo "<option value='ID:".$item->id." [".$item->sku_2."] ".strtoupper($item->nombre)." # ".$item->codigo_barras."'>";
			}
		}else{
			echo "";exit();
		}
				
		
	}
	
	function cargarProducto(){
		
		$item = $_POST['item'];
		$item = substr($item, 3);
		$item = explode(" ", $item);
		$item = $item[0];
		
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		
		$almacen  = $this->modelo_cedi->getUsuarioId($id);		
		
		$productos = $this->model_inventario->Obtener_Producto_Almacen($almacen[0]->cedi,$item);		
		
		if(($productos) && ($productos[0]->cantidad > $productos[0]->inventario)){
					
					$pedidos = $this->modelo_cedi->setItemPOS($productos[0]->id_mercancia,$id,$almacen[0]->cedi);
					
					$this->printItems($pedidos);
		
		}
		
	}
	
	function setCantidad(){
		
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
		redirect('/auth');
		}
		
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		
		
		$almacen  = $this->modelo_cedi->getUsuarioId($id);
		
		$id_temporal = $this->modelo_cedi->setIdTemporal ( $id, $almacen[0]->cedi );
		
		
		$factor = $_POST['factor'];
		$item =  $_POST['item'];
					
		$temporal = $this->modelo_cedi->getTemporalItem($id_temporal,$item);
		
		$limite =  $temporal[0]->inventario - $temporal[0]->minimo;
		
		$cantidad = $temporal[0]->cantidad;
		($factor == '+') ? $cantidad++ : $cantidad--;
		
		($cantidad>$limite) ? '' : $this->modelo_cedi->updateTemporalItem($item, $id_temporal, 'cantidad', $cantidad);
		($cantidad>0)  ? '' : $this->modelo_cedi->deleteTemporalItem($item, $id_temporal);		
		
		$pedidos = $this->modelo_cedi->getTemporal ($id_temporal);
		
		$this->printItems($pedidos);
		
	}
	
	function setNeto(){
	
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
		$descuento = $_POST['valor'];
	
		$almacen  = $this->modelo_cedi->getUsuarioId($id);
	
		$id_temporal = $this->modelo_cedi->setIdTemporal ( $id, $almacen[0]->cedi );
	
		$neto = $this->modelo_cedi->getTotalNeto($id_temporal);
		
		$neto -= ($neto * $descuento)/100;
		
		echo "Neto: $ ".number_format($neto,2);
	
	}
	
	function setArt(){
	
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
	
		$almacen  = $this->modelo_cedi->getUsuarioId($id);
	
		$id_temporal = $this->modelo_cedi->setIdTemporal ( $id, $almacen[0]->cedi );
		
		$art = $this->modelo_cedi->getTotalArticulos($id_temporal);
		
		echo $art." Articulos en venta";
	
	}
	
	private function printItems($temporal){
	
		foreach ($temporal as $producto){
				
			$existencia = ($producto->inventario > $producto->minimo) ?	($producto->inventario - $producto->minimo) : 0;
			
			$precio = $this->modelo_cedi->calcularPrecio($producto);
			
			echo '<tr id="item'.$producto->item .'">
					<td>'.$producto->codigo_barras .'</td>
					<td>'.$producto->nombre .'</td>
					<td>
						$ '.number_format($precio,2) .'
					</td>
					<td>
						'.$producto->cantidad.'
					</td>
					<td >
						$ '.number_format(($precio*$producto->cantidad),2) .'
					</td>
					<td>'.$existencia.'</td>
					<td>
						<button type="button" class="btn btn-danger" 
							onclick="cantidad('.$producto->item .',`-`)">
							<i class="fa fa-minus"></i>
						</button>
						<button type="button" class="btn btn-success"
							onclick="descuento('.$producto->item .')">
							<i class="fa fa-dollar"></i>
						</button>
						<button type="button" class="btn btn-primary"
							onclick="cantidad('.$producto->item .',`+`)">
							<i class="fa fa-plus"></i>
						</button>
					</td>
				</tr>';
		}
		
	}
	
}