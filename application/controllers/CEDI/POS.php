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
	
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->build('website/CEDI/pos/verContado');
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
		
		if($productos){
			foreach ($productos as $producto){
				if($producto->cantidad > $producto->inventario){
					$existencia = $producto->cantidad - $producto->inventario;
					echo '<tr id="item'.$producto->id_mercancia .'">
														<td>'.$producto->id_mercancia .'</td>
														<td>'.$producto->nombre .'</td>
														<td><div align="right">
																<a onclick="descuento('.$producto->id_mercancia .')">$ '.$producto->costo_publico .'</a>
															</div></td>
														<td><a onclick="cantidad('.$producto->id_mercancia .')">'.$producto->min_venta.'</a></td>
														<td bgcolor="#D9EDF7"><div align="right">$ '.$producto->costo_publico*$producto->min_venta .'</div></td>
														<td>'.$existencia.'</td>
														<td>
															<button type="button" class="btn btn-danger"
																onclick="eliminar('.$producto->id_mercancia .')">
																<i class="fa fa-minus"></i> Remover
															</button>
														</td>
													</tr>';
				}				
			}
		}else{
			echo "";exit();
		}
		
		
		
	}
	
}