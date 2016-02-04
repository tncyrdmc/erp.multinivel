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
	
	function get_datos_payulatam()
	{
		$q=$this->db->query("select * from payulatam");
		$payulatam = $q->result();
		return $payulatam;
	}
	
	function actualizar_payulatam()
	{
		
		$estado=0;

		if(isset($_POST['test']))
			$estado=1;
		
		$dato=array(
				"apykey"     => $_POST['apykey'],
				"id_comercio"   		=> $_POST['id_comercio'],
				"id_cuenta"     		=> $_POST['id_cuenta'],
				"moneda"       		=> $_POST['moneda'],
				"test"       		=> $estado
		);
	
		$this->db->where('apykey', $_POST['id']);
		$this->db->update('payulatam', $dato);
	
		return true;
	}
}

?>

