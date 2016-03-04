<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class modelo_pagosonline extends CI_Model
{
	function val_payulatam()
	{
		$payulatam=$this->get_datos_payulatam();
		if(!$payulatam){
			$dato=array(
					"apykey" =>	"6u39nqhq8ftd0hlvnjfs66eh8c"
			);
			$this->db->insert("payulatam",$dato);
			$payulatam=$this->get_datos_payulatam();
		}
		return $payulatam;
	}
	
	function val_paypal()
	{
		$payulatam=$this->get_datos_paypal();
		if(!$payulatam){
			$dato=array(
					"email" =>	"seonetworksoft-facilitator@gmail.com"
			);
			$this->db->insert("paypal",$dato);
			$payulatam=$this->get_datos_payulatam();
		}
		return $payulatam;
	}
	
	function get_datos_payulatam()
	{
		$q=$this->db->query("select * from payulatam");
		$payulatam = $q->result();
		return $payulatam;
	}
	
	function get_datos_paypal()
	{
		$q=$this->db->query("select * from paypal");
		$paypal = $q->result();
		return $paypal;
	}
	
	function actualizar_payulatam()
	{
		
		$test=0;
		$estado='DES';

		if(isset($_POST['test']))
			$test=1;
		
		if(isset($_POST['estatus']))
			$estado='ACT';
		
		$dato=array(
				"apykey"     => $_POST['apykey'],
				"id_comercio"   		=> $_POST['id_comercio'],
				"id_cuenta"     		=> $_POST['id_cuenta'],
				"moneda"       			=> $_POST['moneda'],
				"test"       			=> $test,
				"estatus"       		=> $estado
		);
	
		$this->db->where('apykey', $_POST['id']);
		$this->db->update('payulatam', $dato);
	
		return true;
	}
	
	function actualizar_paypal()
	{
	
		$test=0;
		$estado='DES';

		if(isset($_POST['test']))
			$test=1;
		
		if(isset($_POST['estatus']))
			$estado='ACT';
	
		$dato=array(
				"email"     => $_POST['email'],
				"moneda"       		=> $_POST['moneda'],
				"test"       		=> $test,
				"estatus"       		=> $estado
		);
	
		$this->db->where('email', $_POST['id']);
		$this->db->update('paypal', $dato);
	
		return true;
	}
}

?>