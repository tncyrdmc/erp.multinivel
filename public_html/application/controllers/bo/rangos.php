<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Rangos extends CI_Controller
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
		$this->load->model('bo/model_rangos');
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
		$this->template->build('website/bo/rangos/index');

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

		$tipo_rango=$this->model_rangos->get_tipo_rango();
		$this->template->set("tipo_rango",$tipo_rango);

		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/bo/header');
        $this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/rangos/alta');


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

		$style=$this->modelo_dashboard->get_style($id);

		$this->template->set("style",$style);

		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/bo/header');
        $this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/rangos/listar');



	}
	function set_tipo_rango(){
$code="";
		if(isset($_POST['id'])){
			$ids=$_POST['id'];
			$tipo_rango=$this->model_rangos->get_tipo_rango_not_in($ids);
			foreach ($tipo_rango as $tipo) {
				$code=+"<option value='".$tipo->id."'>".$tipo->descripcion."</option>";
				

			}
			
		
			echo $code;

		}
	}
	function ingresar_rango(){
		$name=$_POST['nombre'];
		$desc=$_POST['desc'];
		$q=$this->model_rangos->ingresar_rango($name,$desc);

echo json_decode($q);
	}
	function ingresar_tipo_rango(){
		
		$id_tipos=$_POST['id_tipos'];
		$valores=$_POST['valores'];
		$this->model_rangos->ingresar_tipo_rango($id_tipos,$valores);


	}

	/*function ingresar_rango_prueba(){
			$datos_rango=array(
				"name"=>$_POST['nombre'],
				"descripcion"=>$_POST['desc']
				);


			$q=$this->model_rangos->prueba_tipo_rango($datos_rango);


				$datos_cross=array(
					"id_rango"=>$q,
				"id_tipo_rango"=>$_POST['t0'],
				"valor"=>$_POST['valor_tipo']

				);

				$this->model_rangos->prueba_tipo_rango2($datos_cross);	
	}*/
}