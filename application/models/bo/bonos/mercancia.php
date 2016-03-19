<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class mercancia extends CI_Model
{


	private $id_mercancia;
	private $id_tipo_mercancia;
	private $costo;
	private $puntos_comisionables;

	function setUpMercancia($id_Mercancia){
		$q=$this->db->query("SELECT id as id_mercancia,id_tipo_mercancia,costo,puntos_comisionables  FROM mercancia where id=".$id_Mercancia);
		$datosMercancia=$q->result();
		
		$this->setIdMercancia($datosMercancia[0]->id_mercancia);
		$this->setIdTipoMercancia($datosMercancia[0]->id_tipo_mercancia);
		$this->setCosto($datosMercancia[0]->costo);
		$this->setPuntosComisionables($datosMercancia[0]->puntos_comisionables);

	}
	
	function  nuevaMercancia($datosMercancia){

		$this->setIdMercancia($datosMercancia["id_mercancia"]);
		$this->setIdTipoMercancia($datosMercancia["id_tipo_mercancia"]);
		$this->setCosto($datosMercancia["costo"]);
		$this->setPuntosComisionables($datosMercancia["puntos_comisionables"]);
	}
	
	function ingresarMercancia() {
		$this->insertarMercancia($this->id_mercancia,$this->id_tipo_mercancia,
										  $this->costo,$this->puntos_comisionables);
	}
	
	function limpiarMercancia() {
		$this->eliminarMercancia();
	}
	
	function insertarMercancia($id_mercancia,$id_tipo_mercancia,$costo,$puntos_comisionables){
		$datos = array(
				'id' => $id_mercancia,
				'id_tipo_mercancia'   => $id_tipo_mercancia,
				'costo'    => $costo,
				'puntos_comisionables'=>$puntos_comisionables
				
		);
		$this->db->insert('mercancia',$datos);
	}

	function eliminarMercancias(){
		$this->db->query('delete from mercancia where id >= 500');
	}
	public function getIdMercancia() {
		return $this->id_mercancia;
	}
	public function setIdMercancia($id_mercancia) {
		$this->id_mercancia = $id_mercancia;
		return $this;
	}
	public function getIdTipoMercancia() {
		return $this->id_tipo_mercancia;
	}
	public function setIdTipoMercancia($id_tipo_mercancia) {
		$this->id_tipo_mercancia = $id_tipo_mercancia;
		return $this;
	}
	public function getCosto() {
		return $this->costo;
	}
	public function setCosto($costo) {
		$this->costo = $costo;
		return $this;
	}
	public function getPuntosComisionables() {
		return $this->puntos_comisionables;
	}
	public function setPuntosComisionables($puntos_comisionables) {
		$this->puntos_comisionables = $puntos_comisionables;
		return $this;
	}
	

}