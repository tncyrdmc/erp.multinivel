<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class afiliado extends CI_Model
{


	//Usuario
	private $id_usuario;
	private $username;
	private $created;

	//Afiliacion
	private $id_afiliacion;
	private $id_red;
	private $id_padre;
	private $id_sponsor;
	private $lado_red;


	function setUpAfiliado($id_afiliado){
		$q=$this->db->query("SELECT id as id_afiliado,username,created FROM users where id=".$id_afiliado);
		$datosAfiliado=$q->result();
		
		$this->setIdUsuario(intval($datosAfiliado[0]->id_afiliado));
		$this->setUsername($datosAfiliado[0]->username);
		$this->setCreated($datosAfiliado[0]->created);
		
		$q=$this->db->query("SELECT id as id_afiliacion,id_red,id_afiliado,
							debajo_de as id_padre,directo as id_sponsor,lado as lado_red 
							FROM afiliar where id_afiliado=".$id_afiliado);
		
		$datosAfiliacion=$q->result();
		$this->setIdAfiliacion(intval($datosAfiliacion[0]->id_afiliacion));
		$this->setIdRed(intval($datosAfiliacion[0]->id_red));
		$this->setIdPadre(intval($datosAfiliacion[0]->id_padre));
		$this->setIdSponsor(intval($datosAfiliacion[0]->id_sponsor));
		$this->setLadoRed(intval($datosAfiliacion[0]->lado_red));
	}
	
	function  nuevoAfiliado($datosUsuario){

		$this->setIdUsuario($datosUsuario["id_usuario"]);
		$this->setUsername($datosUsuario["username"]);
		$this->setCreated($datosUsuario["created"]);
		$this->setIdAfiliacion($datosUsuario["id_afiliacion"]);
		$this->setIdRed($datosUsuario["id_red"]);
		$this->setIdPadre($datosUsuario["id_padre"]);
		$this->setIdSponsor($datosUsuario["id_sponsor"]);
		$this->setLadoRed($datosUsuario["lado_red"]);

	}
	
	function ingresarUsuario() {
		$this->insertarUsuario($this->id_usuario,$this->username,
										  $this->created,$this->id_afiliacion,$this->id_red,
										  $this->id_padre,$this->id_sponsor,$this->lado_red);
	}
	
	function limpiarUsuarios() {
		$this->modelo_bono->eliminarUsuarios();
	}
	
	function insertarUsuario($id_usuario,$username,$created,$id_afiliacion,$id_red,$id_padre,$id_sponsor,$lado_red){
		$datos = array(
				'id' => $id_usuario,
				'username'   => $username,
				'created'    => $created
		);
		$this->db->insert('users',$datos);
		
		$datos = array(
				'id' => $id_afiliacion,
				'id_red'   => $id_red,
				'debajo_de'    => $id_padre,
				'id_afiliado'    => $id_usuario,
				'directo' => $id_sponsor,
				'lado' => $lado_red
		);
		$this->db->insert('afiliar',$datos);

	}

	function eliminarUsuarios(){
		$this->db->query('delete from users where id >= 10000');
		$this->db->query('delete from afiliar where id >= 20000');
	}

	public function getIdUsuario() {
		return $this->id_usuario;
	}
	public function setIdUsuario($id_usuario) {
		$this->id_usuario = $id_usuario;
		return $this;
	}
	public function getUsername() {
		return $this->username;
	}
	public function setUsername($username) {
		$this->username = $username;
		return $this;
	}
	public function getCreated() {
		return $this->created;
	}
	public function setCreated($created) {
		$this->created = $created;
		return $this;
	}
	public function getIdAfiliacion() {
		return $this->id_afiliacion;
	}
	public function setIdAfiliacion($id_afiliacion) {
		$this->id_afiliacion = $id_afiliacion;
		return $this;
	}
	public function getIdRed() {
		return $this->id_red;
	}
	public function setIdRed($id_red) {
		$this->id_red = $id_red;
		return $this;
	}
	public function getIdPadre() {
		return $this->id_padre;
	}
	public function setIdPadre($id_padre) {
		$this->id_padre = $id_padre;
		return $this;
	}
	public function getIdSponsor() {
		return $this->id_sponsor;
	}
	public function setIdSponsor($id_sponsor) {
		$this->id_sponsor = $id_sponsor;
		return $this;
	}
	public function getLadoRed() {
		return $this->lado_red;
	}
	public function setLadoRed($lado_red) {
		$this->lado_red = $lado_red;
		return $this;
	}
	
}