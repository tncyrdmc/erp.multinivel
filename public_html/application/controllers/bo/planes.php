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
		$this->load->model('bo/model_bonos');
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
	
	function get_list_rangos($list_rangos){	
		
		$html_rangos = "";
		
			foreach ($list_rangos as $list_rango){
				$rango = $this->model_rangos->get_rangos_id($list_rango->id_rango);
				$html_rangos.="<li>".$rango[0]->nombre."</li>";
			}
			$html_rangos = "<ul>".$html_rangos."</ul>";		
		
		return $html_rangos;
		
	}  
	
	function set_bono(){
	
		$bono=$this->model_bonos->get_bono_by_id($_POST['idBono']);
		$rangos_bono = $this->model_bonos->get_rangos_bono($_POST['idBono']);		
		$output_rangos = $this->get_list_rangos($rangos_bono);
		
	echo ($_POST['idBono']<>0) ?
		 '<div class="widget-body col col-12">
					<div id="divRedes" class="widget-body col col-12">
						<h3 class="semi-bold">Bono <span>( '.$bono[0]->nombre.' )</span></h3>
						<hr class="simple">
						<ul id="myTab'.$_POST['idBono'].'_'.$bono[0]->id.'" class="nav nav-tabs bordered">
							<li class="active">
								<a href="#s'.$_POST['idBono'].'" data-toggle="tab">'.$bono[0]->nombre.'</a>
							</li>
							<li class="">
								<a href="#s'.$_POST['idBono'].'2" data-toggle="tab"><i class="fa fa-fw fa-lg fa-gear"></i>Rangos
								<span class="badge bg-color-blue txt-color-white">'.count($rangos_bono).'</span></a>
							</li>
						</ul>
						<div id="myTabContent'.$_POST['idBono'].$bono[0]->id.'" class="tab-content padding-10">
							<div class="tab-pane fade active in" id="s'.$_POST['idBono'].'">
								<p>'.$bono[0]->descripcion.'</p>
							</div>
							<div class="tab-pane fade" id="s'.$_POST['idBono'].'2">
								<div class="padding-10">'.$output_rangos.'</div>
								<input type="hidden" name="idTipoRango[]" value="'.$_POST['idBono'].$bono[0]->id.'"><br>
							</div>
						</div>
					</div>
			</div>' : '';
	
	}
	
}