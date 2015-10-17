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
}