<?php

class autored{
	
	public $db = array();
	
	function __construct($db){
		$this->db = $db;
	}
	
	function setPuntosActivo(){
		$query = "SELECT puntos_personales FROM empresa_multinivel GROUP BY id_tributaria;";
		
		$q = newQuery($this->db, $query);
		
		if (! $q)
			return false;
			
		return $q[1]["puntos_personales"];
	}
	
	function setAfiliados($fecha){
		
		$query = "SELECT
		u.id,
		u.created,
		datediff(DATE_SUB('$fecha', INTERVAL 1 MONTH),u.created) dife,
		concat(p.nombre,' ',p.apellido) usuario,
		(SELECT
		(CASE
		WHEN SUM(p.puntos) THEN SUM(p.puntos)
		ELSE 0
		END) valor
		FROM
		pos_venta o,
		venta v,
		pos_venta_item p,
		items i
		WHERE
		i.id = p.item AND i.red = 1
		AND p.id_venta = o.id_venta
		AND o.id_venta = v.id_venta
		AND v.id_user = 31
		AND v.id_estatus = 'ACT'
		AND v.fecha BETWEEN (CASE WHEN (DATE_FORMAT('$fecha','%d')>15)
		THEN CONCAT(DATE_FORMAT('$fecha','%Y-%m'),'-15')
		ELSE CONCAT(DATE_FORMAT('$fecha','%Y-%m'),'-01') END) AND '$fecha')
		+
		(SELECT
		(CASE
		WHEN SUM(i.puntos_comisionables * cvm.cantidad)
		THEN SUM(i.puntos_comisionables * cvm.cantidad)
		ELSE 0
		END) valor
		FROM
		venta v,
		cross_venta_mercancia cvm,
		items i
		WHERE
		v.id_venta = cvm.id_venta
		AND i.id = cvm.id_mercancia
		AND v.id_user = 31
		AND i.red = 1
		AND v.id_estatus = 'ACT'
		AND v.fecha BETWEEN (CASE WHEN (DATE_FORMAT('$fecha','%d')>15)
		THEN CONCAT(DATE_FORMAT('$fecha','%Y-%m'),'-15')
		ELSE CONCAT(DATE_FORMAT('$fecha','%Y-%m'),'-01') END) AND '$fecha') mes1,
		(SELECT
		(CASE
		WHEN SUM(p.puntos) THEN SUM(p.puntos)
		ELSE 0
		END)
		FROM
		pos_venta o,
		venta v,
		pos_venta_item p,
		items i
		WHERE
		i.id = p.item AND i.red = 1
		AND p.id_venta = o.id_venta
		AND o.id_venta = v.id_venta
		AND v.id_user = u.id
		AND v.id_estatus = 'ACT'
		AND v.fecha BETWEEN DATE_SUB('$fecha', INTERVAL 1 MONTH) AND
		(CASE WHEN (DATE_FORMAT('$fecha','%d')>15)
		THEN CONCAT(DATE_FORMAT('$fecha','%Y-%m'),'-15')
		ELSE CONCAT(DATE_FORMAT('$fecha','%Y-%m'),'-01') END) )
		+ (SELECT
		(CASE WHEN SUM(i.puntos_comisionables * cvm.cantidad)
		THEN SUM(i.puntos_comisionables * cvm.cantidad)
		ELSE 0
		END)
		FROM
		venta v,
		cross_venta_mercancia cvm,
		items i
		WHERE
		v.id_venta = cvm.id_venta
		AND i.id = cvm.id_mercancia
		AND v.id_user = u.id
		AND i.red = 1
		AND v.id_estatus = 'ACT'
		AND v.fecha BETWEEN DATE_SUB('$fecha', INTERVAL 1 MONTH) AND
		(CASE WHEN (DATE_FORMAT('$fecha','%d')>15)
		THEN CONCAT(DATE_FORMAT('$fecha','%Y-%m'),'-15')
		ELSE CONCAT(DATE_FORMAT('$fecha','%Y-%m'),'-01') END) )mes2,
		(SELECT
		(CASE
		WHEN SUM(p.puntos) THEN SUM(p.puntos)
		ELSE 0
		END)
		FROM
		pos_venta o,
		venta v,
		pos_venta_item p,
		items i
		WHERE
		i.id = p.item AND i.red = 1
		AND p.id_venta = o.id_venta
		AND o.id_venta = v.id_venta
		AND v.id_user = u.id
		AND v.id_estatus = 'ACT'
		AND v.fecha BETWEEN (CASE WHEN (DATE_FORMAT(DATE_SUB('$fecha', INTERVAL 1 MONTH),'%d')>15)
		THEN CONCAT(DATE_SUB('$fecha', INTERVAL 1 MONTH),'-15')
		ELSE CONCAT(DATE_FORMAT(DATE_SUB('$fecha', INTERVAL 1 MONTH),'%Y-%m'),'-01') END)
		AND DATE_SUB('$fecha', INTERVAL 1 MONTH) )
		+ (SELECT
		(CASE WHEN SUM(i.puntos_comisionables * cvm.cantidad)
		THEN SUM(i.puntos_comisionables * cvm.cantidad)
		ELSE 0
		END)
		FROM
		venta v,
		cross_venta_mercancia cvm,
		items i
		WHERE
		v.id_venta = cvm.id_venta
		AND i.id = cvm.id_mercancia
		AND v.id_user = u.id
		AND i.red = 1
		AND v.id_estatus = 'ACT'
		AND v.fecha BETWEEN (CASE WHEN (DATE_FORMAT(DATE_SUB('$fecha', INTERVAL 1 MONTH),'%d')>15)
		THEN CONCAT(DATE_SUB('$fecha', INTERVAL 1 MONTH),'-15')
		ELSE CONCAT(DATE_FORMAT(DATE_SUB('$fecha', INTERVAL 1 MONTH),'%Y-%m'),'-01') END)
		AND DATE_SUB('$fecha', INTERVAL 1 MONTH) ) mes3
		FROM
		users u,user_profiles p
		WHERE
		p.user_id = u.id
		AND u.id > 2
		GROUP BY u.id;";
		
		$q = newQuery($this->db, $query);
		
		if (! $q)
			return false;
			
		return $q;
		
	}
	
	function setBlockUser($id){
		$date_notify = date_format(date_add(date_create(),date_interval_create_from_date_string("30 days")), 'Y-m-d');
		
		$query = "INSERT INTO notificacion
					(fecha_fin,nombre,descripcion,link,estatus)
				VALUES
					('".$date_notify."',
					'ALERTA DE INACTIVIDAD',
					'Señor usuario.
					Realice la activación correspondiente de su cuenta
					mediante la compra de producto durante este mes.
					De lo Contrario, su cuenta sera desvinculada de nuestro sistema
					pasado el plazo indicado.
					
					Gracias.',
					'id=$id',
					'ACT');";
		
		newQuery($this->db, $query);
		
		return true;
	}
	
	function setfecha(){
		$query = "SELECT date_format(DATE_SUB(now(), INTERVAL 1 DAY),'%Y-%m-%d') fecha ";
		
		$q = newQuery($this->db, $query);
		
		if (! $q)
			return false;
			
		return $q[1]["fecha"];
	}
	
	function setCompresion($id){
		
		$query = "SELECT a.id_afiliado ,a.directo
		FROM afiliar a,users u
		WHERE u.id = a.id_afiliado
		AND a.debajo_de = $id
		GROUP BY a.debajo_de
		ORDER BY u.created asc;";
		
		$q = newQuery($this->db, $query);
		
		if (! $q)
			return false;
			
		return $q[1];
	}
	
	function setDeleteUser($id,$valores){
		
		$comprime = $valores["id_afiliado"];
		$directo = $valores["directo"];
		
		if(!$comprime||!$directo)
			return false;
		
		$query = "UPDATE afiliar SET id_afiliado = 0, directo = $directo WHERE id_afiliado = $id;
		DELETE FROM afiliar WHERE id_afiliado = $comprime;
		UPDATE afiliar SET id_afiliado = $comprime WHERE id_afiliado = 0;
		UPDATE afiliar SET debajo_de = $comprime WHERE debajo_de = $id;
		DELETE FROM users WHERE id = $id;
		DELETE FROM user_profiles WHERE user_id NOT IN (SELECT id FROM users);
		DELETE FROM afiliar WHERE id_afiliado NOT IN (SELECT id FROM users);
		DELETE FROM cross_perfil_usuario WHERE id_user NOT IN (SELECT id FROM users);
		DELETE FROM estilo_usuario WHERE id_usuario NOT IN (SELECT id FROM users);
		DELETE FROM coaplicante WHERE id_user NOT IN (SELECT id FROM users);
		DELETE FROM cross_tel_user WHERE id_user NOT IN (SELECT id FROM users);
		DELETE FROM cross_dir_user WHERE id_user NOT IN (SELECT id FROM users);
		DELETE FROM billetera WHERE id_user NOT IN (SELECT id FROM users);
		DELETE FROM cross_rango_user WHERE id_user NOT IN (SELECT id FROM users);
		DELETE FROM cross_img_user WHERE id_user NOT IN (SELECT id FROM users);
		DELETE FROM cat_img WHERE id_img NOT IN (SELECT id_img FROM cross_img_user);";
		
		newQuery($this->db, $query);
			
		return true;
		
	}		
	
	function procesar(){
		
		isPeriodo();
		
		$afiliados = $this->setAfiliados($fecha);
		$puntos = $this->setPuntosActivo();
		$this->comprimir($afiliados);
		
	}
	
	function evalPuntos($afiliado,$puntos){
		
		$result = false;
		
		$estados = array (
				"banned",
				"dropped" 
		);
		$periodos = array (
				"mes1" => true,
				"mes2" => $estados [0],
				"mes3" => $estados [1] 
		);
		$dife = array (
				"banned" => 0,
				"dropped" => 15 
		);
		
		foreach ($periodos as $key => $value){
			if($afiliado[$key]<$puntos)
				$result = $value;
			if(!$result)
				break;
		}
		
		foreach ($estados as $estado){
			if($result==$estado)
				if($afiliado["dife"]>=$dife[$estado])
					return $estado;
		}
		
		return false;
		
	}
	
	function comprimir($afiliados){
		
		foreach ($afiliados as $afiliado){
			
			$estado = $this->evalPuntos($afiliado, $puntos);			
			
				echo json_encode($afiliado)."
";
				if($estado == "dropped"){
					$cambio = $this->setCompresion($afiliado["id"]);
					$data = $this->setDeleteUser($afiliado["id"],$cambio);
					if($data)" : Dropped
";
				}else if($estado == "banned"){
					$data = setBlockUser($afiliado["id"]);
					if($data)echo " : Banned
";
				}else{
					echo " : OK
";
				}
			
		}
		
	}
	
}