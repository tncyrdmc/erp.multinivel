<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cemail extends CI_Model
{
	
	
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
		$this->load->model('general');
		$this->load->model('model_admin');
		$this->load->model('model_emails_departamentos');
		
		$this->load->library('email');		
		
	}
	
	function _send_email($type, $email, &$data)
	{
		$tema = $this->model_emails_departamentos->get_tema($type);
		$message = $this->setMessage($type,$data);
		$this->email->from($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->to($email);
		$this->email->subject(sprintf($this->lang->line('auth_subject_'.$tema), $this->config->item('website_name', 'tank_auth')));
		$this->email->message($this->load->view('email/template-html', $message, TRUE));
		$this->email->set_alt_message($this->load->view('email/template-txt', $message, TRUE));
		$this->email->send();
	}
	
	function setMessage($type,$data){
		
		$empresa = $this->model_admin->val_empresa_multinivel();		
		$cuerpo = $this->get_cuerpo_mensaje($type,$data);		
		$tema = $this->model_emails_departamentos->get_tema($type);
		$email = $this->model_emails_departamentos->get_departamento_email($type);		
		
		$message = array (
				'tema' => $tema,
				'asunto' => $cuerpo['asunto'],
				'contenido' => $cuerpo['contenido'],
				'sumario' => $cuerpo['sumario'],
				'nota' => $cuerpo['nota'],
				'fijo' => $empresa[0]->fijo,
				'movil' => $empresa[0]->movil,
				'email' => $email,
				'web' => $empresa[0]->web
		);
		
		return $message;
	}
	
	function get_cuerpo_mensaje($type,$data){		
		
		
		$asunto = $this->Asuntos($type,$data);
		
		$cuerpo = array(
				'asunto' => $asunto,
				'contenido' => $contenido,
				'sumario' => $sumario,
				'nota' => $nota
		);
		
		return $cuerpo;
	}
	
	function Asuntos ($type){
		
		$q = array(
				"TE DAMOS LA BIENVENIDA", //activate
				"ACTIVACION", //activate
				"CONFIRMACIÓN NUEVO EMAIL", //change-email
				"PAGO DE SOLICITUD DE DINERO", //cobros
				"CONFIRMACION DE PAGO POR BANCO", //cuentas-cobrar
				"RECUPERAR CONTRASEÑA", //forgot password
				"CONFIRMACIÓN DE NUEVA CONTRASEÑA" //reset password
		);
		
		return $q[$type]; 
		
	}
}