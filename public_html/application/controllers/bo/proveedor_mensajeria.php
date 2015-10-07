<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class proveedor_mensajeria extends CI_Controller
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
		$this->load->model('bo/model_admin');
		$this->load->model('bo/modelo_proveedor_mensajeria');
	}
	
	function index(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
		redirect('/auth');
		}
		
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		
		if(!$this->general->isAValidUser($id,"logistica"))
		{
			redirect('/auth/logout');
		}
		
		$style=$this->modelo_dashboard->get_style(1);
		
		$this->template->set("usuario",$usuario);
		$this->template->set("style",$style);
		
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/logistico2/mensajeria/index');
	}
	
	function alta(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
		if(!$this->general->isAValidUser($id,"logistica"))
		{
			redirect('/auth/logout');
		}
	
		$style=$this->modelo_dashboard->get_style(1);
		$pais = $this->model_admin->get_pais_activo();
		
		
		$this->template->set("usuario",$usuario);
		$this->template->set("style",$style);
		$this->template->set("paises",$pais);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/logistico2/mensajeria/alta');
	}
	
	function crear_proveedor() {
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
		redirect('/auth');
		}
		
		$id=$this->tank_auth->get_user_id();
		
		if(!$this->general->isAValidUser($id,"logistica"))
		{
			redirect('/auth/logout');
		}
		
		$proveedor = array(
				'numero_empresa' => $_POST['numero'],
				'razon_social' => $_POST['razon_social'],
				'nombre_empresa' => $_POST['nombre'],
				'idioma' => $_POST['idioma'],
				'id_pais' => $_POST['pais'],
				'direccion' => $_POST['direccion'],
				'colonia' => $_POST['colonia'],
				'municipio' => $_POST['municipio'],
				'estado' => $_POST['estado'],
				'codigo_postal' => $_POST['codigo_postal'],
				'estatus' => 'ACT',
		);
		
		if($this->validarProveedor($proveedor)){
			$this->modelo_proveedor_mensajeria->crear_proveedor_mensajeria($proveedor);
		}
		$contactos = array(
				
		);
		
		$tarifas = $_POST['tarifas'];
		
	}
	
	private function validarProveedor($proveedor){
		
		$error = '';
		if($proveedor['nombre'] == ''){
			$error = "El nombre de la empresa proveedora es obligatorio";
		}elseif ($proveedor['razon_social'] == ''){
			$error = "La Razon Social de la empresa proveedora es obligatoria";
		}elseif ($proveedor['direccion'] == ''){
			$error = "La direccion de la empresa proveedora es obligatoria";
		}elseif ($proveedor['codigo_postal'] == ''){
			$error = "El Codigo Postal  de la empresa proveedora es obligatorio";
		}elseif ($proveedor['idioma'] == ''){
			$error = "El idioma de la empresa proveedora es obligatoria";
		}
		
		if($error == ''){
			return true;
		}else{
			echo $error;
			return false;
		}
	}
}