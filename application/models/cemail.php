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
		$this->load->model('bo/model_admin');
		$this->load->model('model_emails_departamentos');
		
		$this->load->library('email');		
		
	}
	
	function send_email($type, $email, $data)
	{
		$type--;
		$message = $this->setMessage($type,$data);
		$tema = $message['tema'];
		$this->email->from($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
		$this->email->to($email);
		$this->email->subject($tema);
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
				'fijo' => $empresa[0]->fijo,
				'movil' => $empresa[0]->movil,
				'email' => $email,
				'web' => $empresa[0]->web
		);
		
		return $message;
	}
	
	function get_cuerpo_mensaje($type,$data){		
		
		
		$asunto = $this->Asuntos($type);
		$contenido = $this->Contenidos($type,$data);
		$sumario = $this->Sumarios($type,$data);
		
		$cuerpo = array(
				'asunto' => $asunto,
				'contenido' => $contenido,
				'sumario' => $sumario
		);
		
		return $cuerpo;
	}
	
	function Asuntos ($type){		
		$q = array(
				"TE DAMOS LA BIENVENIDA", //welcome
				"ACTIVACION", //activate
				"CONFIRMACIÓN NUEVO EMAIL", //change-email
				"PAGO DE SOLICITUD DE DINERO", //cobros
				"CONFIRMACION DE PAGO POR BANCO", //cuentas-cobrar
				"RECUPERAR CONTRASEÑA", //forgot password
				"CONFIRMACIÓN DE NUEVA CONTRASEÑA" //reset password
		);
		
		return $q[$type]; 		
	}
	
	function Sumarios ($type,$data){
		$q = array(
				"Hola ".$data['username'].", te damos la bienvenida a tu oficina virtual de ".$data['site_name'].".", //welcome
				"Bienvenido, ".$data['username']." Ha sido registrado en nuestro sistema.", //activate
				"Your new email address on ".$data['site_name'].".", //change-email
				"Hola ".$data['username'].", Su peticion de pago esta siendo procesada.", //cobros
				"Hola ".$data['username'].", Su pago se ha recibido.", //cuentas-cobrar
				"Hi, ".$data['username'].".", //forgot password
				"Tu nueva contraseña en ".$data['site_name']."." //reset password
		);
	
		return $q[$type];
	}
	
	function Contenidos ($type,$data){
		
		$sitios = array(
				site_url(''),
				site_url('/auth/login/'),
				site_url('/auth/activate/'.$data['user_id'].'/'.$data['new_email_key']),
				site_url('/auth/reset_email/'.$data['user_id'].'/'.$data['new_email_key']),
				site_url('/auth/reset_password/'.$data['user_id'].'/'.$data['new_pass_key'])
		);
		
		$validar = array (
				'username' 	=>(strlen($data['username']) > 0) ? "Nombre de usuario: ".$data['username'] : "",
				'password' 	=>($data['password']) ? "Contraseña: ".$data['password'] : "",
				'id_cobro'	=>($data['id_cobro']) ? "ID de Cobro: ".$data['id_cobro'] : "",
				'id_venta'	=>($data['id_venta']) ? "ID venta: ".$data['id_venta'] : "",
				'fecha'		=>($data['fecha']) ? "Fecha de Solicitud: ".$data['fecha'] : "",
				'nombres'	=>($data['nombre']) &&  ($data['apellido'])  ? "Nombre y apellido: ".$data['nombre']." ".$data['apellido'] : "",
				'banco'		=>($data['banco']) ? "Banco: ".$data['banco'] : "",
				'cuenta'	=>($data['cuenta']) ? "Numero de Cuenta: ".$data['cuenta'] : "",
				'titular'	=>($data['titular']) ? "Titular de cuenta: ".$data['titular'] : "",
				'clave'		=>($data['clave']) ? "CLABE: ".$data['clave'] : "",
				'monto'		=>($data['monto']) ? "Valor de Cobro: $ ".$data['monto'] : "",
				'valor'		=>($data['valor']) ? "Valor de pago: $ ".$data['valor'] : ""
		);
		
		$welcome = '<p class="callout">
								Para ingresar al sitio de clic <a class="btn" href="'.$sitios[1].'">Aqui!</a>
						</p><!-- /Callout Panel -->						
						<p>Si el link no funciona copie y pegue la siguiente direccion en su navegador 
						<a href="'.$sitios[1].'"></a>'.$sitios[1].'</p>						
						<p>'.$validar['username'].'<br /></p>
						<p>Correo: '.$data['email'].'</p>
						<p>'.$validar['password'].'<br /></p>
						<p>Id del Usuario: '.$data['lst_id'][0]->id.'</p>';
		
		$activate = '<p class="callout">
							Para completar tu registro ingresa a este link 
						<a class="btn" href="'.$sitios[2].'"><h3>Aqui!</h3></a>
						</p><!-- /Callout Panel -->						
						<p>Si el link no funciona copie y pegue la siguiente direccion en su navegador 
							<a href="'.$sitios[2].'"></a>
						'.$sitios[2].'</p>						
						<p class="callout">El link funcionara durante '.$data['activation_period'].' horas, 
						de no ser activada su cuenta tu registro sera invalido y deberas ser afiliado por otro usuario nuevamente.</p>
						<p>'.$validar['username'].'<br/></p>
						<p>Correo: '.$data['email'].'</p><br />
						<p>'.$validar['password'].'<br/></p>';
		
		$change_email = 'You have changed your email address for '.$data['site_name'].'<br />
						Follow this link to confirm your new email address:<br />
						<br />
						<big style="font: 16px/18px Arial, Helvetica, sans-serif;"><b>
						<a href="'.$sitios[3].'" >
						Confirm your new email</a></b></big><br />
						<br />
						Link doesn`t work? Copy the following link to your browser address bar:<br />
						<nobr><a href="'.$sitios[3].'">
						'.$sitios[3].'</a></nobr><br />
						<br />
						<br />
						Your email address: '.$data['new_email'].'<br />
						<br />
						<br />
						You received this email, because it was requested by a <a href="'.$sitios[0].'" >'.$data['site_name'].'
						</a> user. If you have received this by mistake, please DO NOT click the confirmation link, and simply delete this email. 
						After a short time,the request will be removed from the system.<br />';
		
		$cobros = '<p class="callout">
							El pago se realizara en las proximas 24 horas con los siguientes datos:
						</p><!-- /Callout Panel -->						
						<p>'. $validar['id_cobro'].'<br /></p>
						<p>'. $validar['fecha'].'<br /></p>
						<p>'. $validar['username'].'<br /></p>
						<p>Correo: '.$data['email'].'</p><br/>
						<p>'. $validar['nombres'].'<br /></p>	
						<p>'. $validar['banco'].'<br /></p>
						<p>'. $validar['cuenta'].'<br /></p>
						<p>'. $validar['titular'].'<br /></p>
						<p>'. $validar['clave'].'<br /></p><br/>
						<p>'. $validar['monto'].'<br /></p>';
		
		$cuentas_cobrar = '<p class="callout">
							Recibimos su confirmacion sobre la transacion con los siguientes datos:
						</p><!-- /Callout Panel -->						
						<p>'. $validar['id_venta'].'<br /></p>
						<p>'. $validar['fecha'].'<br /></p>
						<p>'. $validar['username'].'<br /></p>
						<p>Correo: '.$data['email'].'</p><br/>
						<p>'. $validar['nombres'].'<br /></p>	
						<p>'. $validar['banco'].'<br /></p>
						<p>'. $validar['cuenta'].'<br /></p>
						<p>'. $validar['valor'].'<br /></p> ';
		
		$forgot_password = '<a href="'.$sitios[4].'" >
						<h5>Da click aquí para recuperar tu contraseña</h5></a><br />
						<br />
						¿El link no funciona? Copia y pega en la barra de direcciones de tu navegador el siguiente link.<br />
						El link solo funciona una sola vez.<br />
						<nobr><a href="'.$sitios[4].'">
						'.$sitios[4].'></a></nobr><br />
						Has recibido este correo desde <a href="'.$sitios[0].'" >
						'.$data['site_name'].'</a> como solicitud de una recuperación de contraseña, si no has sido tú, puedes ignorarlo.<br />';
		
		$reset_password = '<p>Has cambiado tu contraseña.<br />
						Por favor , mantenga en sus registros para que no se olvide.<br />
						<br />
						'.$validar['username'].'
						Tu correo: '.$data['email'].'<br />
						Tu nueva contraseña: '.$data['new_pasword'].'<br /></p>';
		
		$q = array(			//welcome
						$welcome, 
							//activate
						$activate,
							//change-email
						$change_email, 
							//cobros
						$cobros, 
							//cuentas-cobrar
						$cuentas_cobrar,
							//forgot password 
						$forgot_password, 
							//reset password
						$reset_password
		);
	
		return $q[$type];
	}
}