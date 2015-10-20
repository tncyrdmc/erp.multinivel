<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class general extends CI_Model
{
	function IsActivedPago($id){
		$q = $this->db->query('select estatus from user_profiles where user_id = '.$id);
		$estado = $q->result();
	
		if($estado[0]->estatus == 'ACT'){
			return true;
		}else{
			if($this->VerificarCompraPaquete($id)){
				$this->actualizarEstadoAfiliado($id);
				return true;
			}else{
				return false;
			}
		}
	}
	
	function actualizarEstadoAfiliado($id){
		$q = $this->db->query("UPDATE user_profiles SET estatus = 'ACT' WHERE user_id = ".$id);
	}
	
	function VerificarCompraPaquete($id){
		$q = $this->db->query("SELECT m.id FROM cross_venta_mercancia cvm, venta v, mercancia m
		where v.id_estatus = 2 and cvm.id_venta = v.id_venta and cvm.id_mercancia = m.id and m.id_tipo_mercancia = 4 and v.id_user = ".$id);
	
		$mercnacias_id = $q->result();
	
		if(isset($mercnacias_id[0]->id)){
			return true;
		}else{
			return false;
		}
	}
	
	function isAValidUser($id,$modulo){
	
		$q=$this->db->query('SELECT cu.id_tipo_usuario as tipoId
							FROM users u , user_profiles up ,cat_tipo_usuario cu
							where(u.id=up.user_id)
							and (up.id_tipo_usuario=cu.id_tipo_usuario)
							and(u.id='.$id.')');
		$tipo=$q->result();
	
		$idTipoUsuario=$tipo[0]->tipoId;
		
		if($modulo=="OV"){
			return $this->IsActivedPago($id);
			
		}else if($modulo=="comercial"){
			if($idTipoUsuario==4||$idTipoUsuario==1)
				return true;
			return false;
		}else if($modulo=="soporte"){
			if($idTipoUsuario==3||$idTipoUsuario==1)
				return true;
			return false;
		}else if($modulo=="logistica"){
			if($idTipoUsuario==5||$idTipoUsuario==1)
				return true;
			return false;
		}else if($modulo=="oficina"){
			if($idTipoUsuario==6||$idTipoUsuario==1)
				return true;
			return false;
		}else if($modulo=="administracion"){
			if($idTipoUsuario==7||$idTipoUsuario==1)
				return true;
			return false;
		}
		return false;
	}
	function get_username($id)
	{
		$q=$this->db->query('select * from user_profiles where user_id = '.$id);
		return $q->result();
	}
	function get_style($id)
	{
	  	$q=$this->db->query('select * from estilo_usuario where id_usuario = '.$id);
	 	return $q->result();
	}

	function get_email($id)
	{
		$q=$this->db->query('select email from users where id = '.$id);
		return $q->result();
	}
	
	function get_pais($id)
	{
		$q=$this->db->query('select pais from cross_dir_user where id_user = '.$id);
		return $q->result();
	}
	
	function username($id)
	{
		$q=$this->db->query('select username from users where id = '.$id);
		return $q->result();
	}
}
