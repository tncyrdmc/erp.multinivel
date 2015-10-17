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
   	$this->template->build('website/bo/logistico2/inventario/salida_alta');
   }
   
   
   function new_salida(){
   	
   }
}