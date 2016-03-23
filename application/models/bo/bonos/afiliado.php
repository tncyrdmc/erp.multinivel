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

	private $totalAfiliados=0;
	private $totalCompras=0;
	private $totalVentas=0;
	private $totalPuntosComisionables=0;

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

	function getAfiliados($id_afiliado,$red,$tipo,$nivel){
		
		$this->getAfiliadosDebajoDe($id_afiliado,$red,$tipo,$nivel);

		return $this->getTotalAfiliados();
	}
	
	function getAfiliadosIntervaloDeTiempo($id_afiliado,$red,$tipo,$nivel,$fechaInicio,$fechaFin){
			$q=$this->db->query("SELECT count(*) as directos FROM users u,afiliar a
								where u.id=a.id_afiliado and a.directo = ".$id_afiliado." and a.id_red = ".$red." and (u.created BETWEEN '".$fechaInicio."' AND '".$fechaFin."')");
			$datos= $q->result();

			$this->setTotalAfiliados($datos[0]->directos);

			return $this->getTotalAfiliados();
	}
	
	function getAfiliadosDebajoDe($id_afiliado,$red,$tipo,$nivel){
		
		if($tipo=='DIRECTOS'){
			$q=$this->db->query("select count(*) as directos
							from afiliar A
							where A.directo = ".$id_afiliado." and A.id_red = ".$red);
			$datos= $q->result();
			$this->setTotalAfiliados($datos[0]->directos);
			return true;
		}
		
		
		$q=$this->db->query("select A.id_afiliado
							from afiliar A
							where A.debajo_de = ".$id_afiliado." and A.id_red = ".$red);

		$datos= $q->result();
		
		foreach ($datos as $dato){
		
			if ($dato!=NULL){
				$this->setTotalAfiliados($this->totalAfiliados+1);
				$this->getAfiliadosDebajoDe($dato->id_afiliado,$red,$tipo,$nivel);
			}
		}
	}
	
	function getComprasPersonales($id_afiliado,$id_red){
		$q=$this->db->query("SELECT sum(costo_total) as total FROM venta v,cross_venta_mercancia cvm,items i
							 where (v.id_venta=cvm.id_venta)
							 and  (i.id=cvm.id_mercancia)
							 and(v.id_user=".$id_afiliado.")
							 and (i.red=".$id_red.")");
		$datos= $q->result();
		
		if($datos[0]->total==null)
			$this->setTotalCompras(0);
		else
			$this->setTotalCompras($datos[0]->total);
		
		return $this->getTotalCompras();
	}
	
	function getComprasPersonalesIntervaloDeTiempo($id_afiliado,$id_red,$fechaInicio,$fechaFin){
		$q=$this->db->query("SELECT sum(costo_total) as total FROM venta v,cross_venta_mercancia cvm,items i
							 where (v.id_venta=cvm.id_venta)
							 and  (i.id=cvm.id_mercancia)
							 and(v.id_user=".$id_afiliado.")
							 and (i.red=".$id_red.") and (v.fecha BETWEEN '".$fechaInicio."' AND '".$fechaFin."')");
		$datos= $q->result();
	
		if($datos[0]->total==null)
			$this->setTotalCompras(0);
		else
			$this->setTotalCompras($datos[0]->total);
	
		return $this->getTotalCompras();
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
	public function getTotalAfiliados() {
		return $this->totalAfiliados;
	}
	public function setTotalAfiliados($totalAfiliados) {
		$this->totalAfiliados = $totalAfiliados;
		return $this;
	}
	public function getTotalCompras() {
		return $this->totalCompras;
	}
	public function setTotalCompras($totalCompras) {
		$this->totalCompras = $totalCompras;
		return $this;
	}
	public function getTotalVentas() {
		return $this->totalVentas;
	}
	public function setTotalVentas($totalVentas) {
		$this->totalVentas = $totalVentas;
		return $this;
	}
	public function getTotalPuntosComisionables() {
		return $this->totalPuntosComisionables;
	}
	public function setTotalPuntosComisionables($totalPuntosComisionables) {
		$this->totalPuntosComisionables = $totalPuntosComisionables;
		return $this;
	}
	
	
}