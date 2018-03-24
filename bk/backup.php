#!/usr/bin/php
<?php

echo "Leyendo datos..."; 
	
	#function setDir($base="/var/www"){	
	function setDir($base="/home/startupns/www/"){	
		$project="erp.networksoft"; #"erp.clientes" 
		$project.="/rtm";#"erp.multinivel" 
		return $base.$project;
	}
	
	function setCommand ($db,$file,$data = ""){
		$hostname = $db['default']['hostname'];
		$username = $db['default']['username'];
		$password = $db['default']['password'];
		$database = $db['default']['database'];
        #echo setDir()."/bk/".$file." ".$hostname." ".$username." ".$password." ".$database." \"$data\"";
		return setDir()."/bk/".$file." ".$hostname." ".$username." ".$password." ".$database." \"$data\"";
	}
	
	function newQuery($db,$data = "")
	{
		$command = setCommand($db, "query.sh", $data);
		$query = shell_exec($command);
		
		$datos = explode("\n", $query);
		
		if (! $datos)
			return false;
			
			$atributos = explode("	", $datos[0]);
			$result = setArray($datos, $atributos);
			return $result;
	}	
	
	function setArray( $datos, $atributos) {
		
		unset($datos[sizeof($datos)-1]);
		unset($datos[0]);
		
		for ($i = 1 ; $i <= sizeof($datos) ; $i++){
			$valores = explode("	", $datos[$i]);
			$datos[$i] =  array();
			$k = 0;
			foreach ($valores as $valor) {
				
				if($valor=="NULL")
					$valor = "";
					
					$datos[$i][$atributos[$k]] = $valor;
					$k++;
			}
		}
		
		return $datos;
	}
	
	function isPeriodo(){
		
		$Quincena = (date('d') == '16')||(date('d') == '01');
		
		if(!$Quincena)
			exit();
			
	}
	
	
echo "
>OK
Cargando base de datos...";
		
	$db_config=setDir()."/application/config/database.php";
	$linea="";
	$file = fopen($db_config, "r");
	while(!feof($file)){
		$linea.=fgets($file)."\n";
	}
	fclose($file);
			
	$val="<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');";
	$texto=str_replace($val, "<?php ", $linea);
		  
	$fp2 = fopen(setDir()."/bk/db_access.php", "w"); 
	fputs($fp2, $texto);
	fclose($fp2);
		
	include(setDir()."/bk/db_access.php");
echo "
>OK
Creando dump...";
	$command = setCommand($db,"bk_daily.sh");
	exec($command);
echo "
>OK
!Dump creado con exito!
";

echo "\n\n>PROCESOS 1> AUTOBONO DIARIO\n";
#include(setDir()."/bk/autobono.php");
echo "\n\nCargando Datos\n";
#$autobono = new autobono($db);
echo "\n>OK\nProcesando Datos\n";
#$afiliados = $autobono->calcular();
echo "\n>OK\n\n!PROCESO COMPLETADO!\n";	

echo "

PROCESOS 2> Compresion dinamica:
";
#include(setDir()."/bk/autored.php");

echo "
>OK
Procesando Datos
";
#$autored = new autored($db);
echo "
>OK
Realizando Acciones
";
#$autored->procesar();	
echo "
>OK
!Proceso realizado con exito
";
	
