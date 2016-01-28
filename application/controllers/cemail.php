<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cemail extends CI_Controller
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
		
		$this->load->library('email');
	}
	
	function _send_email($type, $email, &$data)
	{
		$message = $this->setMessage($type,$data);
		$this->email->from($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->to($email);
		$this->email->subject(sprintf($this->lang->line('auth_subject_'.$type), $this->config->item('website_name', 'tank_auth')));
		$this->email->message($this->load->view('email/template-html', $message, TRUE));
		$this->email->set_alt_message($this->load->view('email/template-txt', $message, TRUE));
		$this->email->send();
	}
	
	
}