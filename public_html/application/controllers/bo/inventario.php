<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class inventario extends CI_Controller
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
		$this->load->model('bo/general');
		$this->load->model('bo/modelo_cedi');
		$this->load->model('bo/model_inventario');
	}

	function index()
	{
		if (!$this->tank_auth->is_logged_in()) 
		{																		// logged in
			redirect('/auth');
		}
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		
	 if($this->general->isAValidUser($id,"comercial")||$this->general->isAValidUser($id,"logistica"))
		{
		}else{
			redirect('/auth/logout');
		}
		$style=$this->modelo_dashboard->get_style(1);
		$this->template->set("type",$usuario[0]->id_tipo_usuario);
		$this->template->set("usuario",$usuario);
		$this->template->set("style",$style);

		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/bo/header');
        $this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/logistico2/inventario/index');
	}
///Documento///	
	function documento()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
		if($this->general->isAValidUser($id,"comercial")||$this->general->isAValidUser($id,"logistica"))
		{
		}else{
			redirect('/auth/logout');
		}
		$style=$this->modelo_dashboard->get_style(1);
		$this->template->set("type",$usuario[0]->id_tipo_usuario);
		$this->template->set("usuario",$usuario);
		$this->template->set("style",$style);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/logistico2/documento/index');
	}
	
	function documentoAlta(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
		redirect('/auth');
		}
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		
		if($this->general->isAValidUser($id,"comercial")||$this->general->isAValidUser($id,"logistica"))
		{
		}else{
			redirect('/auth/logout');
		}
		$style=$this->modelo_dashboard->get_style(1);
		$this->template->set("type",$usuario[0]->id_tipo_usuario);
		$this->template->set("usuario",$usuario);
		$this->template->set("style",$style);
		
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/logistico2/documento/altadocumento');
	}
	
	function nuevoDocumento(){
		if($_POST['nombre']!=null){
			$this->model_inventario->setDocumento();
			redirect('/bo/inventario/listarDocumento');
		}else{
			$error = "Digite el nombre de documento";
			$this->session->set_flashdata('error', $error);
			redirect('/bo/inventario/documentoAlta');
		}
	
	}
	
	function listarDocumento(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
		redirect('/auth');
		}
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		
		if($this->general->isAValidUser($id,"comercial")||$this->general->isAValidUser($id,"logistica"))
		{
		}else{
			redirect('/auth/logout');
		}
		$documento=$this->model_inventario->getAlldocumento();
		$style=$this->modelo_dashboard->get_style(1);
		$this->template->set("type",$usuario[0]->id_tipo_usuario);
		$this->template->set("usuario",$usuario);
		$this->template->set("style",$style);
		
		$this->template->set("documento",$documento);
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/logistico2/documento/listardocumento');
	}
	
	function cambiar_estado_documento(){
		$this->model_inventario->updateEstatusdocumento();
	}
	
	function killDocumento() {
		
		$this->model_inventario->kill_Documento();
		echo "Documento eliminado con Exito";
	}
	function editar_documento(){
		$datosDocumento=$this->model_inventario->getDocumento($_POST['id']);
		$id              = $this->tank_auth->get_user_id();
		$style           = $this->general->get_style(1);
		
		$this->template->set("datosDocumento",$datosDocumento);
		$this->template->build('website/bo/logistico2/documento/editardocumento');
	}
	
	function update_documento(){
			
		if($_POST['nombre']!=null){
			$this->model_inventario->update_Documento();
		  redirect('/bo/inventario/listarDocumento');
		}else{
			$error = "Digite el nombre de documento";
			$this->session->set_flashdata('error', $error);
			redirect('/bo/inventario/listarDocumento');
		}
	}
	////Inventario///
    function entradaInventario(){
    	if (!$this->tank_auth->is_logged_in())
    	{																		// logged in
    	redirect('/auth');
    	}
    	$id=$this->tank_auth->get_user_id();
    	$usuario=$this->general->get_username($id);
    	
    	if($this->general->isAValidUser($id,"comercial")||$this->general->isAValidUser($id,"logistica"))
    	{
    	}else{
    		redirect('/auth/logout');
    	}
    	$style=$this->modelo_dashboard->get_style(1);
    	$this->template->set("type",$usuario[0]->id_tipo_usuario);
    	
    	$this->template->set("usuario",$usuario);
    	$this->template->set("style",$style);
    	
    	$this->template->set_theme('desktop');
    	$this->template->set_layout('website/main');
    	$this->template->set_partial('header', 'website/bo/header');
    	$this->template->set_partial('footer', 'website/bo/footer');
    	$this->template->build('website/bo/logistico2/inventario/indexentrada');
   }
   
	function bloqueo(){
    	if (!$this->tank_auth->is_logged_in())
    	{																		// logged in
    	redirect('/auth');
    	}
    	$id=$this->tank_auth->get_user_id();
    	$usuario=$this->general->get_username($id);
    	
    	if($this->general->isAValidUser($id,"comercial")||$this->general->isAValidUser($id,"logistica"))
    	{
    	}else{
    		redirect('/auth/logout');
    	}
    	$style=$this->modelo_dashboard->get_style(1);
    	$this->template->set("type",$usuario[0]->id_tipo_usuario);
    	
    	$cedis = $this->modelo_cedi->all();
    	$this->template->set("usuario",$usuario);
    	$this->template->set("style",$style);
    	$this->template->set("cedis",$cedis);
    	
    	$this->template->set_theme('desktop');
    	$this->template->set_layout('website/main');
    	$this->template->set_partial('header', 'website/bo/header');
    	$this->template->set_partial('footer', 'website/bo/footer');
    	$this->template->build('website/bo/logistico2/inventario/bloqueo');
   }
   
	function mercanciaDeCedis() {
		$cedis = $this->modelo_cedi->get_mercancia_cedi($_POST['id_cedi']);
		echo json_encode($cedis);
	}
	
	function cant_disp_y_bloq_cedi() {
		$cedis = $this->modelo_cedi->get_cant_disp_y_bloq_cedi( $_POST['id_prod'], $_POST['id_cedi']);
		echo json_encode($cedis);
	}
	
	function bloquear() {
		
		if ($_POST['bloqueados'] < $_POST['disponible']){
			$this->model_inventario->update_bloqueados();
			
			$success = "Se ha actualizado el bloqueo del producto en el inventario.";
			$this->session->set_flashdata('success', $success);
			redirect('/bo/inventario/bloqueo');		
		}
		else{
			$error = "La cantidad de productos que vaya ha bloquear debe ser menor que la disponible.";
			$this->session->set_flashdata('error', $error);
			redirect('/bo/inventario/bloqueo');
		}
	}
   
   function inventarioEntradaAlta(){
   	if (!$this->tank_auth->is_logged_in())
   	{																		// logged in
   	redirect('/auth');
   	}
   	$id=$this->tank_auth->get_user_id();
   	$usuario=$this->general->get_username($id);
   	 
   	if($this->general->isAValidUser($id,"comercial")||$this->general->isAValidUser($id,"logistica"))
   	{
   	}else{
   		redirect('/auth/logout');
   	}
   	$style=$this->modelo_dashboard->get_style(1);
   	$this->template->set("type",$usuario[0]->id_tipo_usuario);
   	$this->template->set("usuario",$usuario);
   	$this->template->set("style",$style);
   	$productos=$this->model_inventario->getProductos();
   	$documento=$this->model_inventario->getAlldocumento();
   	$almacenesCedi=$this->model_inventario->getAlmacenesCedi();
   	
   	$this->template->set("productos",$productos);
   	$this->template->set("documento",$documento);
   	$this->template->set("almacenesCedi",	$almacenesCedi);
   	$this->template->set_theme('desktop');
   	$this->template->set_layout('website/main');
   	$this->template->set_partial('header', 'website/bo/header');
   	$this->template->set_partial('footer', 'website/bo/footer');
   	$this->template->build('website/bo/logistico2/inventario/entrada_alta');
   }
   
   function tipoAlmacen(){
   	$almacen = $this->model_inventario->Obtener_Almacen($_POST['tipo']);
   	echo json_encode($almacen);
   }
   
   function productos_en_Almacen(){
   	$productos = $this->model_inventario->Obtener_Productos_Almacen($_POST['almacen']);
   	echo json_encode($productos);
   }
 
   
   
   
   
   function new_entrada(){
   	
   	if(!($_POST['origen_in']==null) || !($_POST['origen']==null) ){
   	$id_inventario=0;
   	
   	$existe_en_inventario=$this->model_inventario->consultar_en_inventario($_POST['mercancia_in'],$_POST['destino_in']);
   
   	if($existe_en_inventario!=null)
   				{
				   		$datos_inventario_update=array(
				   				"cantidad"     => $_POST['cantidad_in']+$existe_en_inventario[0]->cantidad,
				   				
				   		);
				   		$this->db->where('id_inventario', $existe_en_inventario[0]->id_inventario);
				   		$this->db->update('inventario', $datos_inventario_update);
				   		$id_inventario=$existe_en_inventario[0]->id_inventario;
   				}
   	else{
   	
   	
   	$datos_inventario=array(
   			 
   			
   			"id_almacen"     => $_POST['destino_in'],
   			"id_mercancia"     => $_POST['mercancia_in'],
   			"cantidad"     => $_POST['cantidad_in'],
   			"bloqueados"   => "0",
   			"estatus" => 'ACT',
   	);
   	$id_inventario=$this->model_inventario->ingresar_inventario($datos_inventario);
   
   	}
   	
   	
   	if ($_POST['origen_in']!=null){
   		$datos=array(
   		
   				"id_origen"     => '0',
   				"id_destino"     => $_POST['destino_in'],
   				"id_documento"     => $_POST['documento'],
   				"cantidad"     => $_POST['cantidad_in'],
   				"id_mercancia"   => $_POST['mercancia_in'],
   				"otro_origen" => $_POST['origen_in'],
   				"n_documento" => $_POST['n_documento'],
   				"id_inventario" => $id_inventario,
   				"tipo" => 'E',
   		);
   		
   	}else{
   		$datos=array(
   		
   				"id_origen"     => $_POST['origen'],
   				"id_destino"     => $_POST['destino_in'],
   				"id_documento"     => $_POST['documento'],
   				"cantidad"     => $_POST['cantidad_in'],
   				"id_mercancia"   => $_POST['mercancia_in'],
   				"otro_origen" => '0',
   				"n_documento" => $_POST['n_documento'],
   				"id_inventario" => $id_inventario,
   				"tipo" => 'E',
   		);
   	}
  
   	$this->model_inventario->ingresar_inventario_historial($datos);
   	
   	
   }else{
   	
   	$error = "Complete los datos de formualrio";
   	$this->session->set_flashdata('error', $error);
   	redirect('/bo/inventario/inventarioEntradaAlta');
   }
   redirect('/bo/inventario/index');
   }
   
   
   function inventarioSalidaAlta(){
   	if (!$this->tank_auth->is_logged_in())
   	{																		// logged in
   	redirect('/auth');
   	}
   	$id=$this->tank_auth->get_user_id();
   	$usuario=$this->general->get_username($id);
   	 
   	if($this->general->isAValidUser($id,"comercial")||$this->general->isAValidUser($id,"logistica"))
   	{
   	}else{
   		redirect('/auth/logout');
   	}
   	$style=$this->modelo_dashboard->get_style(1);
   	$this->template->set("type",$usuario[0]->id_tipo_usuario);
   	$this->template->set("usuario",$usuario);
   	$this->template->set("style",$style);
   	$productos=$this->model_inventario->getProductos_en_inventario();
   	$documento=$this->model_inventario->getAlldocumento();
   	$almacenesCedi=$this->model_inventario->getAlmacen_en_inventario();
   	
   	$this->template->set("productos",$productos);
   	$this->template->set("documento",$documento);
   	$this->template->set("almacenesCedi",	$almacenesCedi);
   	$this->template->set_theme('desktop');
   	$this->template->set_layout('website/main');
   	$this->template->set_partial('header', 'website/bo/header');
   	$this->template->set_partial('footer', 'website/bo/footer');
   	$this->template->build('website/bo/logistico2/inventario/salida_alta');
   }
   
   
   function new_salida(){
   	if(!($_POST['destino_in']==null) || !($_POST['destino']==null) && (!($_POST['documento']==null) && !($_POST['mercancia_in']==null) && !($_POST['cantidad_in']==null) && !($_POST['n_documento']==null))){
   		$id_inventario=0;
   	
   		$existe_en_inventario=$this->model_inventario->consultar_en_inventario($_POST['mercancia_in'],$_POST['origen_in']);
   		 
   		if($existe_en_inventario!=null)
   		{
   			if ($_POST['cantidad_in']<=$existe_en_inventario[0]->cantidad){
	   			$datos_inventario_update=array(
	   					"cantidad"     => $existe_en_inventario[0]->cantidad-$_POST['cantidad_in'],
	   					 
	   			);
	   			$this->db->where('id_inventario', $existe_en_inventario[0]->id_inventario);
	   			$this->db->update('inventario', $datos_inventario_update);
	   			$id_inventario=$existe_en_inventario[0]->id_inventario;
   			}
   		}
   		else{
    	}
   	
   	
   		if ($_POST['destino_in']!=null){
   			$datos=array(
   					 
   					"id_origen"     =>  $_POST['origen_in'],
   					"id_destino"     => '0',
   					"id_documento"     => $_POST['documento'],
   					"cantidad"     => $_POST['cantidad_in'],
   					"id_mercancia"   => $_POST['mercancia_in'],
   					"otro_origen" => $_POST['destino_in'],
   					"n_documento" => $_POST['n_documento'],
   					"id_inventario" => $id_inventario,
   					"tipo" => 'S',
   			);
   			 
   		}else{
   			$datos=array(
   					 
   					"id_origen"     => $_POST['origen_in'],
   					"id_destino"     => $_POST['destino'],
   					"id_documento"     => $_POST['documento'],
   					"cantidad"     => $_POST['cantidad_in'],
   					"id_mercancia"   => $_POST['mercancia_in'],
   					"otro_origen" => '0',
   					"n_documento" => $_POST['n_documento'],
   					"id_inventario" => $id_inventario,
   					"tipo" => 'S',
   			);
   		}
   	
   		$this->model_inventario->ingresar_inventario_historial($datos);
   	
   		
   	}else{
   	
   		$error = "Complete los datos de formualrio";
   		$this->session->set_flashdata('error', $error);
   		redirect('/bo/inventario/inventarioEntradaAlta');
   	}
   		
   	redirect('/bo/inventario/index');
   }
   
   function historial_Inventario(){
   	if (!$this->tank_auth->is_logged_in())
   	{																		// logged in
   	redirect('/auth');
   	}
   	
   	$id=$this->tank_auth->get_user_id();
   	$usuario=$this->general->get_username($id);
   	$style=$this->general->get_style($id);
   	$this->template->set("style",$style);
   	$this->template->set("usuario",$usuario);
   	
   	$this->template->set_theme('desktop');
   	$this->template->set_layout('website/main');
   	$this->template->set_partial('header', 'website/ov/header');
   	$this->template->set_partial('footer', 'website/ov/footer');
   	$this->template->build('website/bo/logistico2/inventario/historial_inventario');
   }
   function historial_entrada(){
  	
   	$id=$this->tank_auth->get_user_id();
   	$data=$_GET["info"];
   	$data=json_decode($data,true);
   	$Entradas=$this->model_inventario->historial_entradas($data['inicio'],$data['fin'],'E');
   	$Cedis=$this->model_inventario->getAlmacenesCedi();
   	$Documento=$this->model_inventario->getAlldocumento();
   	$Producto=$this->model_inventario->getProductos();
  
   	$this->template->set("Entradas",$Entradas);
   	$this->template->set("Documento",$Documento);
   	$this->template->set("Producto",$Producto);
   	$this->template->set("Cedis",$Cedis);
   	$this->template->set_theme('desktop');
   	$this->template->build('website/bo/logistico2/inventario/historial_detalles_entrada');
}

function historial_salida(){
	 
	$id=$this->tank_auth->get_user_id();
	$data=$_GET["info"];
	$data=json_decode($data,true);
	$Entradas=$this->model_inventario->historial_entradas($data['inicio'],$data['fin'],'S');
	$Cedis=$this->model_inventario->getAlmacenesCedi();
	$Documento=$this->model_inventario->getAlldocumento();
	$Producto=$this->model_inventario->getProductos();

	$this->template->set("Entradas",$Entradas);
	$this->template->set("Documento",$Documento);
	$this->template->set("Producto",$Producto);
	$this->template->set("Cedis",$Cedis);
	$this->template->set_theme('desktop');
	$this->template->build('website/bo/logistico2/inventario/historial_detalles_entrada');
}

function historial_entrada_salida(){
	$id=$this->tank_auth->get_user_id();
	$data=$_GET["info"];
	$data=json_decode($data,true);
	$Entradas=$this->model_inventario->historial_entradas_salida($data['inicio'],$data['fin']);
	$Cedis=$this->model_inventario->getAlmacenesCedi();
	$Documento=$this->model_inventario->getAlldocumento();
	$Producto=$this->model_inventario->getProductos();
	
	$this->template->set("Entradas",$Entradas);
	$this->template->set("Documento",$Documento);
	$this->template->set("Producto",$Producto);
	$this->template->set("Cedis",$Cedis);
	$this->template->set_theme('desktop');
	$this->template->build('website/bo/logistico2/inventario/historial_entrada_salida');

}

}