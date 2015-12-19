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
		$cat_rangos=$this->model_rangos->get_cat_rangos();
		$style=$this->modelo_dashboard->get_style($id);
		$this->template->set("cat_rangos",$cat_rangos);
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

		$condiciones = $_POST['id_tipo_condicion'];
		$valores = $_POST['valor_rango'];

		$id_rango=$this->model_rangos->ingresar_rango();

		$this->model_rangos->ingresar_condicion_rango($id_rango,$condiciones,$valores);
	/*
		$name=$_POST['nombre'];
		$desc=$_POST['desc'];


		$q=$this->model_rangos->ingresar_rango($name,$desc);

			$this->IngTipRango($q,$_POST['venta']);
			//$this->model_rangos->IngTipRangoAfil($q,$_POST['afiliado'],'2');
			//$this->model_rangos->IngTipRangoPun($q,$_POST['punto'],'3');
		
		
       x*/
	}

	function IngTipRango($q,$valor){
		$this->model_rangos->IngTipRango($q,$valor,'1');

	}
	function ingresar_tipo_rango(){
		
		$id_tipos=$_POST['id_tipos'];
		$valores=$_POST['valores'];
		$this->model_rangos->IngTipRango($id_tipos,$valores,'');


	}

	function editar_rangos(){
		$id= $this->tank_auth->get_user_id();
		$style= $this->general->get_style($id);
		$rangos= $this->model_rangos->get_rangos_id($_POST['id']);
		$RangoVentas=$this->model_rangos->get_cross_rango($_POST['id']);
		$tipo_rango=$this->model_rangos->get_tipo_rango();
		$this->template->set("RangoVentas",$RangoVentas);
		$this->template->set("tipo_rango",$tipo_rango);
		//var_dump($RangoVentas[1]);
		$this->template->set("rangos",$rangos);
		$this->template->build('website/bo/rangos/editar_rangos');

	}
	function actualizar_rangos(){

		$correcto = $this->model_rangos->actualizar_rangos();
		if($correcto){
			echo "Rango Actualizado";
		}
		else{
			echo "No se logro actualizar el rango";
		}
	}

	function kill_rangos(){

		$kill_rangos=$this->model_rangos->kill_rangos();
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


	function cambiar_estado_rangos(){

		$correcto=$this->model_rangos->cambiar_estado_rangos();
		echo "";

	}
}