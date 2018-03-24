<?php

include(setDir()."/bk/calculo.php");

class autobono
{
	
	public $fechaInicio = '';
	public $fechaFin = '';
	public $afiliados = array();
	
	public $db = array();
	
	function __construct($db){
		$this->db = $db;
	}

	function setFechaInicio($value = '')
	{
		if (! $value)
			$value = date('Y-m-d');
			
			$this->fechaInicio = $value;
	}
	
	function setFechaFin($value = '')
	{
		if (! $value)
			$value = date('Y-m-d');
			
			$this->fechaFin = $value . " 23:59:59";
	}
	
	function getAfiliados() {
		$val = $this->afiliados;
		$this->afiliados = array();
		return $val;
	}
	
	function setAfiliados($afiliados) {
		
		array_push($this->afiliados,$afiliados);
		
	}
	
	/** principal **/
	
	public function calcular(){
		
		isPeriodo();
		
		$usuario= new calculo($this->db);
		$afiliados = $usuario->getUsuariosRed();
		
		$reparticion= array();
		
		foreach ($afiliados as $afiliado){
			
			$afiliado = $afiliado["id"];
			
			$calcular = $this->calcularBonos($afiliado);
			
			$reparticion[$afiliado] = $calcular;
			
			$this->activos_procedure($afiliado);
		}
		
		return $reparticion;
		
	}
	
	private function getIDBonos()
	{
		$data = "SELECT
                    	   id
                        FROM
                            bono
                        WHERE
                            estatus = 'ACT'";
		
		$result = newQuery($this->db,$data);
		return $result;
	}
	
	
	private function getAfiliadosTodos()
	{
		$data = "SELECT
                    	   id
                        FROM
                            users
                        WHERE
                            id > 1";
		
		$result = newQuery($this->db,$data);
		return $result;
	}
	
	private function calcularBonos($id_usuario){
		
		$bonos = $this->getIDBonos();
		
		$parametro = array("id_usuario" => $id_usuario, "fecha" => $this->getLastDay());
		
		$repartido = array();
		
		foreach ($bonos as $bono){
			$id_bono = $bono["id"];
			$isActived = $this->isActived($id_usuario,$id_bono);
			
			if($isActived){
				$monto = $this->getValorBonoBy($id_bono, $parametro);
				$repartir = $this->repartirBono($id_bono,$id_usuario,$monto);
				$repartido[$id_bono] = $monto;
				
			}
			
		}
		
		return $repartido;
		
	}
	
	private function repartirBono($id_bono, $id_usuario, $valor) {
		$fechaInicio = $this->getPeriodoFecha ( "QUI", "INI", '' );
		$fechaFin = $this->getPeriodoFecha ( "QUI", "FIN", '' );
		
		$historial = $this->getHistorialBono ( $id_bono, $fechaInicio, $fechaFin );
		
		if (! $historial)
			$historial = $this->newHistorialBono ( $id_bono, $fechaInicio, $fechaFin );
		
		if ($valor > 0)
			echo "PAGO $id_usuario : $ $valor | OK! \n\n";
		
		$data = "INSERT INTO comision_bono
				(id_usuario,id_bono,id_bono_historial,valor)
				VALUES
				($id_usuario,$id_bono,$historial,$valor)";
		
		newQuery ( $this->db, $data );
		
		// $this->cobrar($id_usuario, $valor, $fechaFin);
		
		return true;
	}
	
	private function cobrar($id_usuario, $monto, $fecha)
	{
		$cuenta_cobro = $this->get_cuenta_banco($id_usuario);
		
		if (! $cuenta_cobro)
			return false;
			
			$cuenta = $cuenta_cobro["cuenta"];
			$titular = $cuenta_cobro["titular"];
			$pais = $cuenta_cobro["pais"];
			$banco = $cuenta_cobro["banco"];
			
			$data = "INSERT INTO cobro
			(id_user,id_metodo,id_estatus,monto,fecha,cuenta,titular,banco,pais)
			VALUES
			($id_usuario,1,3,$monto,'$fecha','$cuenta','$titular','$banco','$pais')";
			
			newQuery($this->db, $data);
			
			return true;
	}
	
	private function get_cuenta_banco($id_usuario)
	{
		$data = "SELECT
		c.*,
		CONCAT(u.nombre, ' ', u.apellido) titular
		FROM
		cross_user_banco c,
		user_profiles u
		WHERE
		c.id_user = u.user_id
		AND u.user_id = $id_usuario
		AND c.estatus = 'ACT'";
		
		$result = newQuery($this->db, $data);
		
		if (! $result)
			return false;
			
			$valid = $result[1];
			
			return $valid;
	}
	
	private function newHistorialBono($id_bono, $fechaInicio, $fechaFin)
	{
		$dia = date('d', strtotime($fechaInicio));
		$mes = date('m', strtotime($fechaInicio));
		$anio = date('Y', strtotime($fechaInicio));
		
		$data = "INSERT INTO comision_bono_historial
		(id_bono,dia,mes,ano,fecha)
		VALUES
		($id_bono,$dia,$mes,$anio,'$fechaFin')";
		
		newQuery($this->db, $data);
		
		$result = $this->getHistorialBono($id_bono, $fechaInicio, $fechaFin);
		
		return $result;
	}
	
	private function getHistorialBono($id_bono, $fechaInicio, $fechaFin)
	{
		$data = "SELECT
		*
		FROM
		comision_bono_historial
		WHERE
		fecha  between '$fechaInicio' and '$fechaFin'
		AND id_bono = $id_bono";
		
		$result = newQuery($this->db, $data);
		
		if (! $result)
			return false;
			
			$historial = $result[1]["id"];
			
			return $historial;
	}
	
	/** preproceso **/

	function isActived ( $id_usuario,$id_bono = 0,$red = 1,$fecha = '' ){
		
		$this->setFechaInicio($this->getPeriodoFecha("QUI", "INI", $fecha));
		$this->setFechaFin($this->getPeriodoFecha("QUI", "FIN", $fecha));
		
		#if($id_bono==1)
		#    $fecha = $this->setFechaQuincena($fecha);
		$isPaid = $this->isPaid($id_usuario,$id_bono);
		
		if($isPaid){
			return false;
		}		
		
		$isActived = $this->isActivedAfiliado($id_usuario,$red,$fecha,$id_bono);
		
		$isScheduled = ($id_bono > 2)
		? $this->isScheduled($id_usuario,$id_bono,$this->fechaFin) : true;
		
		echo "ID : $id_usuario -[$id_bono] PAGADO >> ".intval($isPaid)." | ACTIVO !! ".intval($isActived)." | AGENDADO :: ".intval($isScheduled)."\n";
		
		if(!$isActived||!$isScheduled){
			return false;
		}
		
		return true;
		
	}
	
	function isActivedAfiliado($id_usuario,$red = 1,$fecha = false,$bono = false){
		
		if (! $fecha)
			$fecha = date ( 'Y-m-d' );
		
		$isRecent = date ( 'Y-m', strtotime ( $fecha ) ) == date ( 'Y-m' );
		if (! $isRecent)
			return $this->isActivedAfiliado_bk ( $id_usuario, $red, $fecha, $bono );
		
		$q = newQuery($this->db, "select * from red where id_usuario = $id_usuario and estatus = 'ACT'" );
				
		if (! $q)
			return false;
		
		return true;
					
	}
	
	function activos_procedure($id_usuario = 2)
	{	    
	    
	    $fechainicio = $this->getPeriodoFecha("QUI", "INI", '');
	    $fechafin = $this->getPeriodoFecha("QUI", "FIN", '');
	    
	    $condicion = $this->getEmpresa ("puntos_personales");
	    
	    $puntos =  $this->getValoresby($id_usuario, $fechainicio, $fechafin);
	    $this->setCalculoDatos($id_usuario, $puntos, $fechainicio, $fechafin);
	    
	    if($puntos<$condicion){
	        $condicion*=2;
	        $fechainicio = $this->getPeriodoFecha("MES", "INI", '');
	        $fechafin = $this->getPeriodoFecha("MES", "FIN", '');
	        $puntos =  $this->getValoresby($id_usuario, $fechainicio, $fechafin);
	    }
	    
	    $activo = $puntos<$condicion;
	    
	    $this->setRedActivo($id_usuario,$activo); 
	    $this->setCalculoBonos($id_usuario, $fechainicio, $fechafin);
	    
	}
	
	private function setCalculoBonos($id_usuario, $fechainicio, $fechafin)
	{
	    $default = array("tipo"=>1,"item"=>0,"condicion"=>"PUNTOS");
	    $bonos=array($default);
	    
	    foreach ($bonos as $bono){
	        $valor =  $this->getValoresby($id_usuario, $fechainicio, $fechafin,$bono["tipo"],$bono["item"],$bono["condicion"]);
	        $this->setCalculoDatos($id_usuario, $valor, $fechainicio, $fechafin,$bono["tipo"],$bono["item"],$bono["condicion"]);
	    }
	    
	}
	
	private function setCalculoDatos($id_usuario,$valor,$fechainicio, $fechafin,$tipo = 0,$item = 0,$set = "PUNTOS"){
	    
	    newQuery($this->db,"DELETE FROM calculo_bonos
                        where id_afiliado = $id_usuario
                        and tipo = '$tipo' and item = '$item'
                        AND fecha BETWEEN $fechainicio AND CONCAT('$fechafin', ' 23:59:59')
                        AND condicion = '$set'");
	    
	    newQuery($this->db,"INSERT INTO calculo_bonos (id_afiliado,valor,condicion,tipo,item) 
			VALUES ($id_usuario,$valor,'$set','$tipo','$item');");
	    
	}
	
	private function setRedActivo($id_usuario,$estatus = false){
	    
	    $estatus = ($estatus) ? "ACT": "DES";
	    
	    $q = newQuery($this->db," update red set estatus = '$estatus' where id_usuario = $id_usuario");
	    
	}
	
	private function getValoresby($id_usuario, $fechainicio, $fechafin,$tipo = 0,$mercancia = 0,$set = "PUNTOS")
	{
	    $set = ($set == "COSTO") ? "m.costo" : "m.puntos_comisionables";
	    
	    if(!$fechainicio||!$fechafin){
	        $fechainicio = $this->getPeriodoFecha("QUI", "INI", '');
	        $fechafin = $this->getPeriodoFecha("QUI", "FIN", '');
	    }
	    
	    $where = "";
	    
	    if($tipo!=0){
	        $in = (gettype($tipo)=="array") ? implode(",", $tipo) : $tipo;
	        $where.=" AND m.id_tipo_mercancia in ($in)";
	    }
	    
	    if($mercancia!=0){
	        $in = (gettype($mercancia)=="array") ? implode(",", $mercancia) : $mercancia;
	        $where.=" AND m.id in ($in)";
	    }
	    
	    $query = "SELECT ( SELECT
						(CASE WHEN SUM($set * cvm.cantidad)
        				 THEN SUM($set * cvm.cantidad)
        				 ELSE 0 END) cart_val
        				FROM
        				    venta v,
        				    cross_venta_mercancia cvm,
                            mercancia m
        				WHERE
							m.id = cvm.id_mercancia
        				    AND v.id_venta = cvm.id_venta
        				    AND v.id_user in ($id_usuario)
        				    AND v.id_estatus = 'ACT'
        				    AND v.fecha BETWEEN '$fechainicio' AND concat('$fechafin',' 23:59:59') $where)
                            +
                            (SELECT
								 (CASE WHEN SUM($set * p.cantidad)
									THEN SUM($set * p.cantidad) ELSE 0 END)
                                 cedi_val
							FROM
								pos_venta o,
								venta v,
							    pos_venta_item p,
                                mercancia m
							WHERE
								p.id_venta = o.id_venta AND m.id = p.item
								AND o.id_venta = v.id_venta
								AND v.id_user in ($id_usuario)
								AND v.id_estatus = 'ACT'
								AND v.fecha BETWEEN '$fechainicio' AND concat('$fechafin',' 23:59:59') $where)
                                total ";
	    
	    $q = newQuery($this->db,$query);	    	    
	    
	    if(!$q)
	        return 0;
	        
	        return $q[1]["total"];
	}
	
	
	private function isRedActivo($id_usuario = 2)
	{
	    $q = newQuery($this->db,"select * from red where id_usuario = $id_usuario");	   
	    
	    if(!$q)
	        newQuery($this->db,"insert into red values (1,$id_usuario,0,'DES',0)");
	        
	        return true;
	}
	
	function isActivedAfiliado_bk($id_usuario,$red = 1,$fecha = '',$bono = false){
		
		if($id_usuario==2)
			return true;
			
			$puntos = $this->getEmpresa ("puntos_personales");
			$usuario= new calculo($this->db);
			
			#$productos=$this->getComprasUnidades($id_usuario,$this->fechaInicio,$this->fechaFin,1);
			#$lider=$this->getComprasUnidades($id_usuario,$this->fechaInicio,$this->fechaFin,5,8);
			#$intermedia=$this->getComprasUnidades($id_usuario,$this->fechaInicio,$this->fechaFin,5,7);
			
			$fechaInicio= ($this->fechaInicio) ? $this->fechaInicio :$this->getPeriodoFecha("QUI","INI", $fecha);
			$fechaFin= ($this->fechaFin) ? $this->fechaFin : $this->getPeriodoFecha("QUI", "FIN", $fecha );
			$fechaInicio2=$this->getPeriodoFecha("MES", "INI", $fechaFin);
			
			$bonoFecha = ($bono)&&($this->fechaInicio)&&($this->fechaFin) ? true : false;
			
			/*if($bonoFecha){
			 $valor = $usuario->getPuntosTotalesPersonalesView($id_usuario,$red,$fechaInicio,$fechaFin,"0","0","vb_activo");
			 $valorMes = $usuario->getPuntosTotalesPersonalesView($id_usuario,$red,$fechaInicio2,$fechaFin,"0","0","vb_activo_2");
			 }else{ 	*/
			$valor = $usuario->getComprasPersonalesIntervaloDeTiempo($id_usuario,$red,$fechaInicio,$fechaFin,"0","0","PUNTOS");
			$valorMes = $usuario->getComprasPersonalesIntervaloDeTiempo($id_usuario,$red,$fechaInicio2,$fechaFin,"0","0","PUNTOS");
			//}
			
			if(!$bonoFecha){
				$log_act = $fechaInicio." - ".$fechaFin;
				$log_act = "ID : $id_usuario -> ACTIVO { $log_act } : $puntos | $valor | $valorMes ";
				echo $log_act;
			}
			
			$pasaMes = ($puntos*2)<=$valorMes;
			
			$Pasa = ($puntos<=$valor||$pasaMes) ? true : false;
			
			return $Pasa;
	}
	
	private function getComprasUnidades($id_usuario = 2,$fechaInicio,$fechaFin,$tipo = 0,$mercancia = 0,$red = 1){
		
		if(!$fechaInicio||!$fechaFin){
			$fechaInicio = $this->getPeriodoFecha("QUI", "INI", '');
			$fechaFin = $this->getPeriodoFecha("QUI", "FIN", '');
		}
		
		$where = "";
		
		if($tipo!=0){
			$in = (gettype($tipo)=="array") ? implode(",", $tipo) : $tipo;
			$where.=" AND i.id_tipo_mercancia in ($in)";
		}
		
		if($mercancia!=0){
			$in = (gettype($mercancia)=="array") ? implode(",", $mercancia) : $mercancia;
			$where.=" AND i.id in ($in)";
		}
		
		$cart = "SELECT
		(CASE WHEN (cvm.cantidad) THEN SUM(cvm.cantidad) ELSE 0 END) unidades
		FROM
		venta v,
		cross_venta_mercancia cvm,
		items i
		WHERE
		i.id = cvm.id_mercancia
		AND cvm.id_venta = v.id_venta
		AND v.id_user = $id_usuario
		AND i.red = $red
		$where
		AND v.id_estatus = 'ACT'
		AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin 23:59:59'";
		
		$cedi = "SELECT
		(CASE WHEN (cvm.cantidad) THEN SUM(cvm.cantidad) ELSE 0 END) unidades
		FROM
		venta v,
		pos_venta_item cvm,
		items i
		WHERE
		i.id = cvm.item
		AND cvm.id_venta = v.id_venta
		AND v.id_user = $id_usuario
		AND i.red = $red
		$where
		AND v.id_estatus = 'ACT'
		AND v.fecha BETWEEN '$fechaInicio' AND '$fechaFin 23:59:59'";
		
		$query = "SELECT ($cart)+($cedi) unidades";
		
		$q = newQuery($this->db, $query);
		
		
		if(!$q)
			return 0;
			
			return intval($q[1]["unidades"]);
			
	}
	
	private function isPaid($id_usuario,$id_bono){
		
		$query = "SELECT
		*
		FROM
		comision_bono c,
		comision_bono_historial h
		WHERE
		c.id_bono_historial = h.id
		AND c.id_bono = h.id_bono
		AND h.id_bono = $id_bono
		AND c.id_usuario = $id_usuario
		AND h.fecha BETWEEN '$this->fechaInicio' AND '$this->fechaFin'
		#AND c.valor > 0";
		
		$q = newQuery($this->db, $query);
		
		
		if(!$q)
			return false;
			
			$valid = (sizeof($q)>0) ? true : false;
			
			return $valid;
			
	}
	
	private function isPaidHistorial($id_usuario,$historial){
		
		$query = "SELECT
		*
		FROM
		comision_bono c,
		comision_bono_historial h
		WHERE
		c.id_bono_historial = h.id
		AND c.id_bono = h.id_bono
		AND h.id = $historial
		AND c.id_usuario = $id_usuario
		#AND c.valor > 0";
		
		$q = newQuery($this->db, $query);
		
		
		if(!$q)
			return false;
			
			$valid = (sizeof($q)>0) ? true : false;
			
			return $valid;
			
	}
	
	private function isValidDate($id_usuario,$id_bono,$fecha = false,$dia = false){
		
		$bono = $this->getBono($id_bono);
		
		$mes_inicio = $bono[1]["mes_desde_afiliacion"];
		$mes_fin = $bono[1]["mes_desde_activacion"];
		
		if($mes_inicio<=0){
			return true;
		}
		
		if($fecha)
			$fecha = "'".$fecha."'";
			else
				$fecha = "NOW()";
				
				$mes_inicio*=2;
				
				$select = "DATE_FORMAT(created, '%Y-%m') < DATE_FORMAT(DATE_SUB($fecha, INTERVAL $mes_inicio WEEK),'%Y-%m')";
				
				if($dia){
					$select = "created < DATE_SUB(NOW(), INTERVAL $mes_inicio MONTH)";
				}
				
				$query = "SELECT
				$select 'valid'
				FROM
				users
				WHERE
				id = ".$id_usuario;
				
				$q = newQuery($this->db, $query);
				
				
				if(!$q)
					return false;
					
					$valid = ($q[1]["valid"]==1) ? true : false;
					
					return $valid;
					
	}
	
	private function isScheduled($id_usuario,$id_bono,$fecha = ""){
		
		$bono = $this->getBono($id_bono);
		
		$mes_inicio = $bono[1]["mes_desde_afiliacion"];
		$mes_fin = $bono[1]["mes_desde_activacion"];
		$where = "";
		
		if(strlen($fecha)>2){
			$fecha = "'".$fecha."'";
		}else{
			$fecha = "NOW()";
		}
		
		$limiteInicio = "(CASE WHEN (DATE_FORMAT(fecha,'%d')<16) THEN CONCAT(DATE_FORMAT(fecha,'%Y-%m'),'-15') ELSE LAST_DAY(fecha) END)";
		
		if($mes_inicio>0){
			$where .= "DATE_FORMAT($fecha, '%Y-%m-%d') > ".$limiteInicio;
		}
		
		if($mes_fin>0){
			$mes_fin+=$mes_inicio;
			$where .= "DATE_FORMAT($fecha, '%Y-%m-%d') <= ".$limiteInicio;
		}
		
		$query = "SELECT
		$where 'valid'
		FROM
		venta
		WHERE
		id_estatus = 'ACT'
		AND id_user = ".$id_usuario
		." ORDER BY fecha asc
                    LIMIT 1";
		
		$q = newQuery($this->db, $query);
		
		
		if(!$q)
			return false;
			
			$valid = ($q[1]["valid"]==1) ? true : false;
			
			return $valid;
			
	}
	
	/** calculo **/
	
	function getValorBonoBy($id_bono,$parametro){
		switch ($id_bono){
			
			case 1 :
				
				return $this->getValorBonoInicioRapido($parametro);
				
				break;
				
			case 2 :
				
				return $this->getValorBonoInicial($parametro);
				
				break;
				
			case 3 :
				
				return $this->getValorBonoMatriz($parametro);
				
				break;
				
			case 4 :
				
				return $this->getValorBonoIgualacion($parametro);
				
				break;
				
			case 5 :
				
				return 0;#TODO:$this->getValorBonoDuplicado($parametro);
				
				break;
				
			default:
				return 0;
				break;
				
		}
		
	}
	
	private function getValorBonoInicioRapido($parametro){
		
		$valores = $this->getBonoValorNiveles(1);
		
		$bono = $this->getBono(1);
		$periodo = isset($bono[1]["frecuencia"]) ? $bono[1]["frecuencia"] : "UNI";
		
		$fechaInicio=$this->getPeriodoFecha($periodo, "INI", $parametro["fecha"]);
		$fechaFin=$this->getPeriodoFecha($periodo, "FIN", $parametro["fecha"]);
		
		$id_usuario = $parametro["id_usuario"];
		
		echo "between: $fechaInicio - $fechaFin";
		
		$afiliados = $this->getAfiliadosInicioRapido($id_usuario,1,$fechaInicio,$fechaFin);
		
		$monto = $this->getMontoInicioRapido ($id_usuario,$afiliados,$valores,$fechaInicio,$fechaFin);
		
		return $monto;
	}
	
	private function getAfiliadosInicioRapido($id,$nivel,$fechaInicio,$fechaFin) {
		
		
		$where = "";#" AND u.created BETWEEN '$fechaInicio' AND '$fechaFin 23:59:59'";
		
		$afiliados = array();
		for ($i=1; $i <= $nivel; $i++) {
			
			$this->getDirectosBy($id,  $i, $where);
			$directos = $this->getAfiliados();
			#echo ">> ".json_encode($directos));
			array_push($afiliados, implode(",", $directos));
		}
		
		$afiliados = implode(",", $afiliados);
		$afiliados = explode(",", $afiliados);
		
		#echo ">>> ".json_encode($afiliados));
		return $afiliados;
	}
	
	private function getMontoInicioRapido($id_usuario,$afiliados,$valores,$fechaInicio,$fechaFin,$red = 1) {
		
		$inscritos=array();
		
		#echo "afiliados: ".json_encode($afiliados));
		
		foreach ($afiliados as $afiliado){
			$valor=0;
			if($afiliado>0)
				$valor=$this->getComprasUnidades($afiliado,$fechaInicio,$fechaFin,5);
				#echo ">> $afiliado :  ".$valor);
				if($valor>0)
					#if($afiliado>0)
						array_push($inscritos, $afiliado);
		}
		
		$monto = 0;
		$cantidad = sizeof($inscritos);
		
		/*$trio = 0;
		foreach ($valores as $valor){
			$tri = ($valor["nivel"]*3);
			if($tri<=$cantidad){
				$monto = $valor["valor"];
				$trio = $tri;
			}
		}
		
		$fechaInicio=$this->getPeriodoFecha("ANO", "INI", '');
		$fechaFin=$this->getPeriodoFecha("ANO", "FIN", '');
		
		$membresia = array(7,8);
		$valor=$this->getComprasUnidades($id_usuario,$fechaInicio,$fechaFin,5,$membresia);
		
		if($trio>=9&&$valor>0){
			$monto*=2;
		}*/
		
		$monto = $valores[1]["valor"];
		
		echo "->> ".json_encode($inscritos)." : $monto X $cantidad ";
		
		$monto *= $cantidad;
		
		return $monto;
	}
	
	private function getValorBonoInicial($parametro){
		
		$valores = $this->getBonoValorNiveles(2);
		
		$bono = $this->getBono(2);
		$periodo = isset($bono[1]["frecuencia"]) ? $bono[1]["frecuencia"] : "UNI";
		
		$fechaInicio=$this->getPeriodoFecha($periodo, "INI", $parametro["fecha"]);
		$fechaFin=$this->getPeriodoFecha($periodo, "FIN", $parametro["fecha"]);
		
		$id_usuario = $parametro["id_usuario"];
		
		echo "between: $fechaInicio - $fechaFin";
		
		$afiliados = $this->getAfiliadosInicial($valores,$id_usuario,$fechaInicio,$fechaFin);
		
		$monto = $this->getMontoInicial ( $valores,$afiliados,$fechaInicio,$fechaFin);
		
		return $monto;
		
	}
	
	private function getAfiliadosInicial($valores,$id,$fechaInicio,$fechaFin) {
		
		
		$where = "";#" AND u.created BETWEEN '$fechaInicio' AND '$fechaFin 23:59:59'";
		
		$afiliados = array();
		
		foreach ($valores as $nivel){
			
			if($nivel["nivel"]>0){
				
				$this->getDirectosBy($id,  $nivel["nivel"], $where);
				array_push($afiliados, $this->getAfiliados());
			}
		}
		
		return $afiliados;
	}
	
	private function getMontoInicial($valores, $afiliados,$fechaInicio,$fechaFin,$red = 1) {
		$monto = 0;$lvl=0;
		$usuario= new calculo($this->db);
		$afiliados = $this->setScheduled($valores,$afiliados, $fechaInicio,2);
		for($i = 1;$i<=sizeof($valores);$i++){
			$Corre = ($i>1)&&isset($afiliados[$lvl]);
			if($Corre){
				$per = $valores[$i]["valor"]/100;
				#foreach ($afiliados[$lvl] as $afiliado){
				$afiliado = implode(",", $afiliados[$lvl]);
				$valor=$usuario->getCalculoPersonal($afiliado,$fechaInicio,$fechaFin,"0","0","PUNTOS");
				$valor*=$per;
				#$activoAfiliado = $this->isActivedAfiliado($afiliado);
				echo "->> $afiliado [2]: $i | ".($per*100)." % | ".$valor." | ".$monto;
				$monto+= $valor;
				#TODO:}
				$lvl++;
			}
		}
		return $monto;
	}
	
	private function setScheduled($valores,$afiliados,$fechaInicio,$id_bono=1){
		
		for ($i = 0; $i < sizeof($valores); $i ++) {
			$afiliados_scheduled = array();
			$Corre = isset($afiliados[$i]);
			if ($Corre) {
				foreach ($afiliados[$i] as $afiliado) {
					$isScheduled = $this->isScheduled($afiliado, $id_bono, $fechaInicio);
					if ($isScheduled) {
						#echo  " >>-> isScheduled [$afiliado]  :: " . intval($isScheduled));
						array_push($afiliados_scheduled, $afiliado);
					}
				}
				$afiliados[$i] = $afiliados_scheduled;
			}
		}
		
		return $afiliados;
		
	}
	
	private function setActivedAfiliados($valores,$afiliados,$fecha,$id_bono=1){
		
		for($i = 0;$i<sizeof($valores);$i++){
			$afiliados_actived = array();
			$Corre = isset($afiliados[$i]);
			if ($Corre) {
				foreach ($afiliados[$i] as $afiliado) {
					$activoAfiliado = $this->isActivedAfiliado($afiliado, 1, $fecha, $id_bono);
					if ($activoAfiliado) {
						#echo  " >->> isActived [$afiliado]  :: " . intval($activoAfiliado));
						array_push($afiliados_actived, $afiliado);
					}
				}
				$afiliados[$i] = $afiliados_actived;
			}
		}
		
		return $afiliados;
		
	}
	
	private function getValorBonoMatriz($parametro){
		
		$valores = $this->getBonoValorNiveles(3);
		
		$bono = $this->getBono(3);
		$periodo = isset($bono[1]["frecuencia"]) ? $bono[1]["frecuencia"] : "UNI";
		
		$fechaInicio=$this->getPeriodoFecha($periodo, "INI", $parametro["fecha"]);
		$fechaFin=$this->getPeriodoFecha($periodo, "FIN", $parametro["fecha"]);
		
		$id_usuario = $parametro["id_usuario"];
		
		echo "between: $fechaInicio - $fechaFin";
		
		$valores = $this->getValoresMatriz($id_usuario,$valores,$fechaInicio,$fechaFin);
		
		$afiliados = $this->getAfiliadosMatriz($valores,$id_usuario);
		
		$monto = $this->getMontoMatriz ( $valores,$afiliados,$fechaInicio,$fechaFin);
		
		return $monto;
		
	}
	
	private function getValoresMatriz($id,$valores,$fechaInicio,$fechaFin){
		
		$isActivoMatriz = $this->isActivoMatriz($id,$fechaInicio,$fechaFin);
		
		if(!$isActivoMatriz){
			for ($i=(sizeof($valores)); $i > 3; $i--) {
				unset($valores[$i]);
			}
		}
		
		return $valores;
		
	}
	
	private function isActivoMatriz($id,$fechaInicio,$fechaFin)
	{
		$this->getDirectosBy($id, 1);
		$afiliados = $this->getAfiliados();
		
		$puntos = $this->getEmpresa ("puntos_personales");
		$usuario= new calculo($this->db);
		$inscritos = array();
		
		foreach ($afiliados as $afiliado){
			$valor=0;
			if($afiliado>0)
				$valor=$this->isActivedAfiliado($afiliado,1,$fechaFin,3);
				#$valor=$this->getComprasUnidades($afiliado,$fechaInicio,$fechaFin,1);
				if($valor>=$puntos)
					#if($valor>0)
						array_push($inscritos, $afiliado);
		}
		
		$afiliados = $inscritos;
		#echo json_encode($afiliados));
		
		$isActivoMatriz = (sizeof($afiliados)<3) ? false : true;
		return $isActivoMatriz;
	}
	
	
	private function getAfiliadosMatriz($valores,$id) {
		
		$where = "";
		
		$afiliados = array();
		
		foreach ($valores as $nivel){
			
			if($nivel["nivel"]>0){
				$this->getAfiliadosBy($id,  $nivel["nivel"], $nivel["condicion_red"], $where,$id);
				
				array_push($afiliados, $this->getAfiliados());
			}
		}
		return $afiliados;
	}
	
	private function getMontoMatriz($valores, $afiliados,$fechaInicio,$fechaFin,$red = 1) {
		$monto = 0;$lvl=0;
		$usuario= new calculo($this->db);
		$afiliados = $this->setScheduled($valores,$afiliados, $fechaInicio,3);	
		
		for($i = 1;$i<=sizeof($valores);$i++){
			$Corre = ($i>1)&&isset($afiliados[$lvl]);
			if($Corre){
				$per = $valores[$i]["valor"]/100;
				#foreach ($afiliados[$lvl] as $afiliado){
				$afiliado = implode(",", $afiliados[$lvl]);
				$valor=$usuario->getCalculoPersonal($afiliado,$fechaInicio,$fechaFin,1,"0","PUNTOS");
				$valor*=$per;
				#$activoAfiliado = $this->isActivedAfiliado($afiliado);
				echo "->> $afiliado [3]: $i | ".($per*100)." % | ".$valor." | ".$monto;
				$monto+= $valor;
				#TODO:}
				$lvl++;
			}
		}
		return $monto;
	}
	
	private function getValorBonoIgualacion($parametro) {
		
		$valores = $this->getBonoValorNiveles(4);
		
		$bono = $this->getBono(4);
		$periodo = isset($bono[1]["frecuencia"]) ? $bono[1]["frecuencia"] : "UNI";
		
		$fechaInicio=$this->getPeriodoFecha($periodo, "INI", $parametro["fecha"]);
		$fechaFin=$this->getPeriodoFecha($periodo, "FIN", $parametro["fecha"]);
		
		$id_usuario = $parametro["id_usuario"];
		
		echo "between: $fechaInicio - $fechaFin";
		
		$isActivoMatriz = $this->isActivoMatriz($id_usuario,$fechaInicio,$fechaFin);
		
		if(!$isActivoMatriz)
			return 0;
			
			$afiliados = $this->getAfiliadosMatriz($valores,$id_usuario);
			
			$monto = $this->getMontoIgualacion ( $valores,$afiliados,$fechaInicio,$fechaFin);
			
			return $monto;
	}
	
	private function getMontoIgualacion($valores, $afiliados,$fechaInicio,$fechaFin,$red = 1) {
		$monto = 0;$lvl=0;
		$afiliados = $this->setScheduled($valores,$afiliados, $fechaInicio,3);
		$afiliados = $this->setActivedAfiliados($valores,$afiliados, $fechaInicio,3);
		for($i = 1;$i<=sizeof($valores);$i++){
			$Corre = ($i>1)&&isset($afiliados[$lvl]);
			if($Corre){
				$per = $valores[$i]["valor"]/100;
				foreach ($afiliados[$lvl] as $afiliado){
					$valor=$this->getMontoBono($afiliado,3,$fechaInicio,$fechaFin);
					$valor*=$per;
					echo "->> $afiliado [4]: $i | ".($per*100)." % | ".$valor;
					$monto+= $valor;
				}
				$lvl++;
			}
		}
		return $monto;
	}
	
	private function getValorBonoDuplicado($parametro) {
		
		$valores = $this->getBonoValorNiveles(5);
		
		$bono = $this->getBono(5);
		$periodo = isset($bono[1]["frecuencia"]) ? $bono[1]["frecuencia"] : "UNI";
		
		$fechaInicio=$this->getPeriodoFecha("ANO", "INI", $parametro["fecha"]);
		$fechaFin=$this->getPeriodoFecha("ANO", "FIN", $parametro["fecha"]);
		
		$id_usuario = $parametro["id_usuario"];
		
		$opcion_monto = $valores[1]["valor"];
		
		$afiliados = $this->getAfiliadosMatriz($valores,$id_usuario);
		
		$isLlenado = $this->isLlenadoRed($valores, $afiliados);
		
		$monto = $this->getMontoCompras ( $valores,$afiliados,$fechaInicio,$fechaFin);
		
		$noAplica = (($monto<$opcion_monto)||!$isLlenado) ? true : false;
		
		if($noAplica)
			return 0;
			
			$Duplica = $this->duplicarRed($id_usuario) ? 1 : 0;
			
			return $Duplica;
			
	}
	
	private function duplicarRed($id_usuario,$red=1){
		
		$query = "UPDATE afiliar SET duplicado = 'ACT' WHERE id_red = $red AND id_afiliado = $id_usuario";
		$q = newQuery($this->db, $query);
		return true;
		
	}
	
	private function getMontoCompras($valores, $afiliados,$fechaInicio,$fechaFin,$red = 1) {
		$monto = 0;$lvl=0;
		$usuario= new calculo($this->db);
		$afiliados = $this->setActivedAfiliados($valores, $afiliados, $fechaInicio,3);
		for($i = 1;$i<=sizeof($valores);$i++){
			$Corre = ($i>1)&&isset($afiliados[$lvl]);
			if($Corre){
				#foreach ($afiliados[$lvl] as $afiliado){
				$afiliado = ($afiliados[$lvl]) ? implode(",", $afiliados[$lvl]) : 0;
					$valor=$usuario->getComprasPersonalesIntervaloDeTiempo($afiliado,$red,$fechaInicio,$fechaFin,"0","0","COSTO");
					$monto+= $valor;
				#TODO:}
				$lvl++;
			}
		}
		return $monto;
	}
	
	private function isLlenadoRed($opcion_red, $afiliados)
	{
		unset($opcion_red[0]);
		
		$lvl=0;
		foreach ($opcion_red as $red){
			$frontales = sizeof($afiliados[$lvl]);
			if($frontales<$red["valor"]){
				$lvl = 0;
				break;
			}
			$lvl++;
		}
		
		if($lvl>0)
			return true;
			
			return false;
	}
	
	
	private function getMontoBono($id_usuario,$id_bono,$fechaInicio,$fechaFin){
		$query = "SELECT
		max(c.valor) valor
		FROM
		comision_bono c,
		comision_bono_historial h
		WHERE
		c.id_usuario = $id_usuario
		AND h.id_bono = c.id_bono
		AND c.id_bono = $id_bono
		AND c.id_bono_historial = h.id
		AND h.fecha between '$fechaInicio' and '$fechaFin'";
		
		$q = newQuery($this->db, $query);
		
		
		if(!$q)
			return 0;
			
			return $q[1]["valor"];
	}
	
	private function getBonoValorNiveles($id) {
		$q = newQuery($this->db, "SELECT * FROM cat_bono_valor_nivel WHERE id_bono = $id ORDER BY nivel asc");
		
		return $q;
	}
	
	private function getBono($id) {
		$q = newQuery($this->db, "SELECT * FROM bono WHERE id = $id");
		
		return $q;
	}
	
	private function getDirectosBy($id,$nivel,$where = "",$red = 1){
		
		$query = "SELECT
		a.id_afiliado id,
		a.directo
		FROM
		afiliar a,
		users u
		WHERE
		u.id = a.id_afiliado
		AND a.id_red = $red
		AND a.directo = $id
		$where";
		
		$q = newQuery($this->db, $query);
		
		$datos= $q;
		
		if(!$q){
			return;
		}
		
		$nivel--;
		foreach ($datos as $dato){
			
			if ($nivel <= 0){
				
				$this->setAfiliados ($dato["id"]);
				
			}else{
				$this->getDirectosBy($dato["id"], $nivel, $where,$red);
			}
		}
		
		
	}
	
	private function getAfiliadosBy ($id,$nivel,$tipo,$where,$padre = 2,$red = 1){
		
		$is = array("DIRECTOS" =>"a.directo","RED"=>"a.debajo_de");
		
		$query = "SELECT
		a.id_afiliado id,
		a.directo
		FROM
		afiliar a,
		users u
		WHERE
		u.id = a.id_afiliado
		AND a.id_red = $red
		AND a.debajo_de = $id
		$where";
		
		$q = newQuery($this->db, $query);
		
		$datos= $q;
		
		if(!$q){
			return;
		}
		
		$nivel--;
		foreach ($datos as $dato){
			
			if ($nivel <= 0){
				
				if($tipo != "DIRECTOS" || $padre == $dato["directo"]){
					$this->setAfiliados ($dato["id"]);
				}
				
			}else{
				$this->getAfiliadosBy($dato["id"], $nivel, $tipo, $where,$padre, $red);
			}
		}
		
		
	}
	
	private function getEmpresa($attrib = 0) {
		
		$q = newQuery($this->db, "SELECT * FROM empresa_multinivel GROUP BY id_tributaria");
		
		
		if(!$q){
			return 0;
		}
		
		if($attrib === 0){
			return $q;
		}
		
		return $q[1][$attrib];
		
	}
	
	
	/** complemento **/
	
	private function getLastDay() {
	    
	    $query = "SELECT
					    DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 DAY),
					            '%Y-%m-%d') fecha";
	    $q = newQuery($this->db,$query);
	    $fecha = $q[1]["fecha"]." 23:59:59";
	    return $fecha;
	    
	}
	
	private function getPeriodoFecha ($frecuencia,$tipo,$fecha = ''){
		
		if(!$fecha)
			$fecha= $this->getLastDay();
			
			$periodoFecha = array(
					"SEM" => "Semana",
					"QUI" => "Quincena",
					"MES" => "Mes",
					"ANO" => "Ano"
			);
			
			$tipoFecha= array(
					"INI" => "Inicio",
					"FIN" => "Fin"
			);
			
			if($frecuencia=="UNI"){
				return  ($tipo == "INI") ? $this->getInicioFecha() : date('Y-m-d');
			}
			
			if(!isset($periodoFecha[$frecuencia])||!isset($tipoFecha[$tipo])){
				return $fecha;
			}
			
			$functionFecha = "get".$tipoFecha[$tipo].$periodoFecha[$frecuencia];
			
			return $this->$functionFecha($fecha);
			
	}
	
	private function getInicioFecha() {
		
		$query = "SELECT
                        date_format(MIN(created),'%Y-%m-%d') fecha
                    FROM
                        users";
		
		$q = newQuery($this->db, $query);
		
		
		$year = new DateTime();
		$year->setDate($year->format('Y'), 1, 1);
		
		if(!$q)
			date_format($year, 'Y-m-d');
			
			return $q[1]["fecha"];
			
	}
	
	private function getFinSemana($date) {
		$offset = strtotime($date);
		
		$dayofweek = date('w',$offset);
		
		if($dayofweek == 6){
			return $date;
		}
		else{
			return date("Y-m-d", strtotime('last Saturday', strtotime($date)));
		}
	}
	
	private function getInicioSemana($date) {
		
		$fecha_sub = new DateTime($date);
		date_sub($fecha_sub, date_interval_create_from_date_string('6 days'));
		$date = date_format($fecha_sub, 'Y-m-d');
		
		$offset = strtotime($date);
		
		$dayofweek = date('w',$offset);
		
		if($dayofweek == 0)
		{
			return $date;
		}
		else{
			return date("Y-m-d", strtotime('last Sunday', strtotime($date)));
		}
	}
	
	private function getInicioQuincena($date) {
		$dateAux = new DateTime();
		
		if(date('d',strtotime($date))<=15){
			$dateAux->setDate(date('Y',strtotime($date)),date('m',strtotime($date)), 1);
			return date_format($dateAux, 'Y-m-d');
		}else {
			$dateAux->setDate(date('Y',strtotime($date)),date('m',strtotime($date)), 16);
			return date_format($dateAux, 'Y-m-d');
		}
	}
	
	private function getFinQuincena($date) {
		
		$dateAux = new DateTime();
		
		if(date('d',strtotime($date))<=15){
			$dateAux->setDate(date('Y',strtotime($date)),date('m',strtotime($date)), 15);
			return date_format($dateAux, 'Y-m-d');
		}else {
			return date('Y-m-t',strtotime($date));
		}
	}
	
	private function getInicioMes($date) {
		$dateAux = new DateTime();
		$dateAux->setDate(date('Y',strtotime($date)),date('m',strtotime($date)), 1);
		return date_format($dateAux, 'Y-m-d');
	}
	
	private function getFinMes($date) {
		return date('Y-m-t',strtotime($date));
	}
	
	private function getInicioAno($date) {
		$year = new DateTime($date);
		$year->setDate($year->format('Y'), 1, 1);
		return date_format($year, 'Y-m-d');
	}
	
	private function getFinAno($date) {
		$year = new DateTime($date);
		$year->setDate($year->format('Y'), 12, 31);
		return date_format($year, 'Y-m-d');
	}
	
	
}