<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class palindromo extends CI_Model
{

	private $frase=array();
	private $fraseInvertida=array();
	
	function __construct()
	{
		parent::__construct();
	}
	
	function invertirFrase($fraseAInvertir){
		$sizeFrase = $this->getSizeFrase ($fraseAInvertir);

		$fraseDevulenta='';
		
		for($i=count($sizeFrase)-1;$i>=0;$i--){
				$fraseDevulenta.=$fraseAInvertir[$i];
		}
		return $fraseDevulenta;
	}
	
	function esPalindromo($fraseInicial){
		$fraseInvertida=$this->invertirFrase($fraseInicial);
		
		$fraseInvertida=$this->limpiarFrase($fraseInvertida);
		$fraseInicial=$this->limpiarFrase($fraseInicial);

		if($fraseInvertida==$fraseInicial)
			return true;
		
		return false;
	}
	
	private function getSizeFrase($fraseAInvertir) {
		$this->setFrase($fraseAInvertir);
		$sizeFrase=$this->getFrase();
		return $sizeFrase;
	}

	private function limpiarFrase($frase){
		return str_replace(' ', '', strtolower($frase));
	}
	
	public function getFrase() {
		return $this->frase;
	}
	public function setFrase($frase) {
		$this->frase = str_split($frase);
		return $this->frase;
	}
	public function getFraseInvertida() {
		return $this->fraseInvertida;
	}
	public function setFraseInvertida($fraseInvertida) {
		$this->fraseInvertida = $fraseInvertida;
		return $this;
	}
	
	
	
}