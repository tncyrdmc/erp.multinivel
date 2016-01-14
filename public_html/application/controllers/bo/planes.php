<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Planes extends CI_Controller
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
		$this->load->model('bo/general');
		$this->load->model('bo/model_planes');
	}
	
	function index(){
	
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		}
	
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/configuracion/planes/index');
	
	}
	
	function alta(){
		
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		}
	
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
	
		$bonos_plan=$this->model_planes->get_bonos_plan();
		$this->template->set("bonos_plan",$bonos_plan);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/configuracion/planes/alta');
	
	
	}
	
	function listar(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		}
		$planes=$this->model_planes->get_planes();
		$cross_plan_bonos=$this->model_planes->get_cross_plan_bonos();
		$bonos=$this->model_planes->get_bonos_plan();
		$style=$this->modelo_dashboard->get_style($id);
		$this->template->set("planes",$planes);
		$this->template->set("cross_plan_bonos",$cross_plan_bonos);
		$this->template->set("bonos",$bonos);
		$this->template->set("style",$style);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/configuracion/planes/listar');	
	
	}
	
	function ingresar_plan(){
		$bonos = $_POST['id_bono_plan'];
	
		if(count($bonos)<2){
			echo "Se Necesita añadir mínimo 2 bonos para Crear el plan";
		}else{
			$id_plan=$this->model_planes->ingresar_plan();
			$this->model_planes->ingresar_plan_bonos($id_plan,$bonos);
			echo "Se Ha creado el Plan = ".$_POST['nombre'];
		}		
		
	}
	
}