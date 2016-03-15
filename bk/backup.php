#!/usr/bin/php
<?php
echo "Leyendo datos...";
	//$base="/var/www";
	//$project="/erp.multinivel";
	$base="/home/content/57/11569157/html"; 
	$project="/test";
	$db_config=$base.$project."/application/config/database.php";
echo "\n>OK\nCargando base de datos...";
	include($db_config);
echo "\n>OK\nCreando dump...";
	exec($base.$project."/bk/bk_daily.sh ".$db['default']['hostname']." ".$db['default']['username']." ".$db['default']['password']." ".$db['default']['database']);
echo "\n>OK\n\n!Dump creado con exito!\n";