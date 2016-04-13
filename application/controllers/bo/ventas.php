<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ventas extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
		$this->load->model('bo/modelo_dashboard');
		$this->load->model('ov/general');
		$this->load->model('bo/modelo_comercial');
		$this->load->model('ov/model_perfil_red');
		$this->load->model('model_tipo_red');
		$this->load->model('model_cat_tipo_usuario');
		$this->load->model('model_cat_sexo');
		$this->load->model('model_cat_edo_civil');
		$this->load->model('model_cat_estudios');
		$this->load->model('model_cat_ocupacion');
		$this->load->model('model_cat_estatus_afiliado');
		$this->load->model('model_cat_tiempo_dedicado');
		$this->load->model('model_cat_usuario_fiscal');
		$this->load->model('model_users');
		$this->load->model('model_user_profiles');
		$this->load->model('model_coaplicante');
		$this->load->model('bo/model_admin');
		$this->load->model('bo/model_mercancia');
		$this->load->model('ov/modelo_compras');
		$this->load->model('modelo_cobros');
		$this->load->model('model_excel');
		$this->load->model('cemail');
		$this->load->model('model_servicio');
		$this->load->library('html2pdf');
	}

	function index(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
		$id=$this->tank_auth->get_user_id();
		
		if(!$this->general->isAValidUser($id,"administracion"))
		{
			redirect('/auth/logout');
		}

		$usuario=$this->general->get_username($id);
		
		$style=$this->modelo_dashboard->get_style(1);
	
		$this->template->set("usuario",$usuario);
		$this->template->set("style",$style);
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/administracion/ventas/listar');
	}
	
	function ventasIndex(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
		$id=$this->tank_auth->get_user_id();
	
		if(!$this->general->isAValidUser($id,"administracion"))
		{
			redirect('/auth/logout');
		}
	
		$usuario=$this->general->get_username($id);
	
		$style=$this->modelo_dashboard->get_style(1);
	
		$this->template->set("usuario",$usuario);
		$this->template->set("style",$style);
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/administracion/ventas/index');
	}
	
	function reporte_ventas_oficinas_virtuales()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
	
		if(!$this->general->isAValidUser($id,"comercial"))
		{
			redirect('/auth/logout');
		}
	
	
		$total_venta = 0;
		$total_costo = 0;
		$total_impuesto = 0;
		$total_comision = 0;
		$total_neto = 0;
	
	
		$ventas = $this->model_servicio->listar_todos_por_venta_y_fecha($_POST['startdate'],$_POST['finishdate']);
	
		$id=$this->tank_auth->get_user_id();
		echo
		"<table id='datatable_fixed_column1' class='table table-striped table-bordered table-hover' width='100%'>
				<thead id='tablacabeza'>
					<th data-class='expand'>ID Venta</th>
					<th data-hide='phone,tablet'>Username</th>
					<th data-hide='phone,tablet'>Nombre</th>
					<th data-hide='phone,tablet'>Apellido</th>
					<th data-hide='phone,tablet'>Subtotal</th>
					<th data-hide='phone,tablet'>Impuestos</th>
					<th data-hide='phone,tablet'>Total Venta</th>
					<th data-hide='phone,tablet'>Total Comisiones</th>
					<th data-hide='phone,tablet'>Total Neto</th>
					<th data-hide='phone,tablet'>Accion</th>
				</thead>
				<tbody>";
	
		if ($_POST['startdate']!=""){
			foreach($ventas as $venta)
			{
				echo "<tr>
			<td class='sorting_1'>".$venta->id_venta."</td>
			<td>(".$venta->id_usuario.") ".$venta->username."</td>
			<td>".$venta->name."</td>
			<td>".$venta->lastname."</td>
			<td> $	".number_format(($venta->costo-$venta->impuestos), 2, '.', '')."</td>
			<td> $	".number_format($venta->impuestos, 2, '.', '')."</td>
			<td> $	".number_format($venta->costo, 2, '.', '')."</td>
			<td> $	".number_format($venta->comision, 2, '.', '')."</td>
			<td> $	".number_format((($venta->costo)-($venta->impuestos+$venta->comision)), 2, '.', '')."</td>
			<td>
				<a title='Factura' style='cursor: pointer;' class='txt-color-blue' onclick='factura(".$venta->id_venta.");'>
				<i class='fa fa-eye fa-3x'></i>
				</a>
				<a title='Eliminar' style='cursor: pointer;' class='txt-color-red' onclick='eliminar(".$venta->id_venta.");'>
				<i class='fa fa-trash-o fa-3x'></i>
				</a>
				<a title='Imprimir' style='cursor: pointer;' class='txt-color-green' onclick='imprimir(".$venta->id_venta.");'>
				<i class='fa fa-file-pdf-o fa-3x'></i>
				</a>
			</td>
			</tr>";
					
				$total_costo = $total_costo + ($venta->costo-$venta->impuestos);
				$total_impuesto = $total_impuesto + $venta->impuestos;
				$total_venta = $total_venta  + $venta->costo;
				$total_comision = $total_comision + $venta->comision;
				$total_neto = $total_neto + (($venta->costo)-($venta->impuestos+$venta->comision));
					
			}
	
			echo "<tr>
			<td class='sorting_1'></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			</tr>";
				
			echo "<tr>
			<td class='sorting_1'><b>TOTALES</b></td>
			<td></td>
			<td></td>
			<td></td>
			<td><b> $	".number_format($total_costo, 2, '.', '')."</b></td>
			<td><b> $	".number_format($total_impuesto, 2, '.', '')."</b></td>
			<td><b> $	".number_format($total_venta, 2, '.', '')."</b></td>
			<td><b> $	".number_format($total_comision, 2, '.', '')."</b></td>
			<td><b> $	".number_format($total_neto, 2, '.', '')."</b></td>
			<td></td>
			</tr>";
		}
		echo "</tbody>
		</table><tr class='odd' role='row'>";
	}


	////////////////////////////////////Factura Ventas//////////////////////


public function createFolder()
    {
        if(!is_dir("./files"))
        {
            mkdir("./files", 0777);
            mkdir("./files/pdfs", 0777);
        }
    }

  public function imprimirfactura()
    {

	    //Load the library
	    /*$this->load->library('html2pdf');
	    
	    //Set folder to save PDF to
	    $this->html2pdf->folder('./assets/pdfs/');
	    
	    //Set the filename to save/download as
	    $this->html2pdf->filename('factura.pdf');
	    
	    //Set the paper defaults
	    $this->html2pdf->paper('a4', 'portrait');
	    
	    //$data = array(
	    //	'title' => 'PDF Created',
	    //	'message' => 'Hello World!'
    	    //);
	    $data=$this->facturaImprimir($_POST['id']);
	    //Load html view

    	$this->html2pdf->html(utf8_decode("".(string)$data.""));
 	    
	    if($this->html2pdf->create('save')) {
	    	//PDF was successfully saved or downloaded
	    	echo 'PDF saved';
	    }

	    var_dump("HOla mundo");
	 $this->load->helper(array('dompdf', 'file'));
	 $this->load->helper('file'); 
     // page info here, db calls, etc.     
     $html = $this->facturaImprimir($_POST['id']);
     //pdf_create(utf8_decode("".(string)$html.""), 'filename');
     //or
     $data = pdf_create($html, '', false);
     write_file('factura', $data);
*/


     $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Israel Parra');
        $pdf->SetTitle('Ejemplo de provincías con TCPDF');
        $pdf->SetSubject('Tutorial TCPDF');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
 
// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));
 
// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 
// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
 
// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
 
//relación utilizada para ajustar la conversión de los píxeles
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 
 
// ---------------------------------------------------------
// establecer el modo de fuente por defecto
        $pdf->setFontSubsetting(true);
 
// Establecer el tipo de letra
 
//Si tienes que imprimir carácteres ASCII estándar, puede utilizar las fuentes básicas como
// Helvetica para reducir el tamaño del archivo.
        $pdf->SetFont('freemono', '', 14, '', true);
 
// Añadir una página
// Este método tiene varias opciones, consulta la documentación para más información.
        $pdf->AddPage();
 
//fijar efecto de sombra en el texto
        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
 
 $html='<h1>Hola mundo</h1>';

 $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
 
// ---------------------------------------------------------
// Cerrar el documento PDF y preparamos la salida
// Este método tiene varias opciones, consulte la documentación para más información.
        $nombre_archivo = utf8_decode("Localidades.pdf");
        $pdf->Output($nombre_archivo, 'D');

    }    

        public function show()
    {
        if(is_dir("./files/pdfs"))
        {
            $filename = "factura.pdf"; 
            $route = base_url("files/pdfs/factura.pdf"); 
            if(file_exists("./files/pdfs/".$filename))
            {
                header('Content-type: application/pdf'); 
                readfile($route);
            }
        }
    }

    ///////////////////////////////////Finalizar Factura ventas////////////
	
	function kill_venta()
	{
		$this->model_admin->kill_venta($_POST['id']);
		echo "Se ha eliminado la venta y sus comisiones.";
	}
	
	function factura(){


		$id = $this->modelo_compras->get_datos_venta($_POST['id']);
		$fecha_1=date_create($id[0]->fecha);
		$fecha=date_format($fecha_1,'Y-m-d');
		$id=$id[0]->id_user;

		$datos_afiliado = $this->model_perfil_red->datos_perfil($id);
		$this->template->set("datos_afiliado",$datos_afiliado);
		
		$mercanciaFactura = $this->modelo_compras->get_mercancia_venta($_POST['id']);
		
		$data=array();
		$contador=0;
		$info_compras=Array();
		
		foreach ($mercanciaFactura as $items)
		{
		
			$imagenes=$this->modelo_compras->get_imagenes($items->id_mercancia);
			$id_tipo_mercancia=$this->modelo_compras->get_tipo_mercancia($items->id_mercancia);
			$id_tipo_mercancia=$id_tipo_mercancia[0]->id_tipo_mercancia;
			if($id_tipo_mercancia==1)
				$detalles=$this->modelo_compras->detalles_productos($items->id_mercancia);
			else if($id_tipo_mercancia==2)
				$detalles=$this->modelo_compras->detalles_servicios($items->id_mercancia);
			else if($id_tipo_mercancia==3)
				$detalles=$this->modelo_compras->detalles_combinados($items->id_mercancia);
			else if($id_tipo_mercancia==4)
				$detalles=$this->modelo_compras->detalles_paquete($items->id_mercancia);
			else if($id_tipo_mercancia==5)
				$detalles=$this->modelo_compras->detalles_membresia($items->id_mercancia);

			$info_mercancia[$contador]=Array(
					"imagen" => $imagenes[0]->url,
					"nombre" => $detalles[0]->nombre,
					"descripcion" => $detalles[0]->descripcion
			);
			$contador++;
		
		}

		$this->template->set("mercanciaFactura",$mercanciaFactura);
		$this->template->set("info_mercancia",$info_mercancia);
		
		$pais = $this->general->get_pais($id);
		$this->template->set("pais_afiliado",$pais);
		
		$empresa  = $this->model_admin->val_empresa_multinivel();
		$this->template->set("empresa",$empresa);

		$this->template->set("fecha",$fecha);
		
		$this->template->set_theme('desktop');
		$this->template->build('website/bo/administracion/ventas/factura');
	}

	function facturaImprimir($id_venta){

		$id = $this->modelo_compras->get_datos_venta($id_venta);
		$fecha_1=date_create($id[0]->fecha);
		$fecha=date_format($fecha_1,'Y-m-d');
		$id=$id[0]->id_user;

		$datos_afiliado = $this->model_perfil_red->datos_perfil($id);
		$this->template->set("datos_afiliado",$datos_afiliado);
		
		$mercanciaFactura = $this->modelo_compras->get_mercancia_venta($id_venta);
		
		$data=array();
		$contador=0;
		$info_compras=Array();
		
		foreach ($mercanciaFactura as $items)
		{
		
			$imagenes=$this->modelo_compras->get_imagenes($items->id_mercancia);
			$id_tipo_mercancia=$this->modelo_compras->get_tipo_mercancia($items->id_mercancia);
			$id_tipo_mercancia=$id_tipo_mercancia[0]->id_tipo_mercancia;
			if($id_tipo_mercancia==1)
				$detalles=$this->modelo_compras->detalles_productos($items->id_mercancia);
			else if($id_tipo_mercancia==2)
				$detalles=$this->modelo_compras->detalles_servicios($items->id_mercancia);
			else if($id_tipo_mercancia==3)
				$detalles=$this->modelo_compras->detalles_combinados($items->id_mercancia);
			else if($id_tipo_mercancia==4)
				$detalles=$this->modelo_compras->detalles_paquete($items->id_mercancia);
			else if($id_tipo_mercancia==5)
				$detalles=$this->modelo_compras->detalles_membresia($items->id_mercancia);

			$info_mercancia[$contador]=Array(
					"imagen" => $imagenes[0]->url,
					"nombre" => $detalles[0]->nombre,
					"descripcion" => $detalles[0]->descripcion
			);
			$contador++;
		
		}
/////////////////////////////////////////////////////////////////////////////////

		$this->template->set("id_venta",$id_venta);
		$this->template->set("mercanciaFactura",$mercanciaFactura);
		$this->template->set("info_mercancia",$info_mercancia);
		
		$pais = $this->general->get_pais($id);
		$this->template->set("pais_afiliado",$pais);
		
		$empresa  = $this->model_admin->val_empresa_multinivel();
		$this->template->set("empresa",$empresa);

		$this->template->set("fecha",$fecha);
		
		$this->template->set_theme('desktop');

$html='';
$html.='<div class="padding-10">
											<div class="pull-left">
												<img style="width: 18rem; height: auto; padding: 1rem;" src="" alt="">
				
												<address>
													<h4 class="semi-bold">'.$empresa[0]->nombre.'</h4>
													<abbr title="Phone">Identificador tributario:</abbr>'."\t".$empresa[0]->id_tributaria.'
													<br>
													<abbr title="Phone">Dirección:</abbr>'.$empresa[0]->direccion.'
													<br>
													<abbr title="Phone">Ciudad:</abbr>'.$empresa[0]->ciudad.'
													<br>
													<abbr title="Phone">Tel:</abbr>&nbsp;'.$empresa[0]->fijo.'
												</address>
											</div>
											</br>
											<div class="pull-right">
												<h1 class="font-300">Factura de venta</h1>
											</div>
											<div class="clearfix"></div>
											<br>
											<div class="row">
												<div class="col-sm-9">
													<address>
														<strong>Facturar a:</strong>
														<br>
														<strong>Señor (a). '.$datos_afiliado[0]->nombre." ".$datos_afiliado[0]->apellido.'</strong>
														<br>
														<abbr title="Phone">DNI:</abbr>'.$datos_afiliado[0]->keyword.'
														<br>
														<abbr title="Phone">Dirección:</abbr>'.$pais_afiliado[0]->direccion.'
														<br>
														<abbr title="Phone">País:</abbr>'.$pais_afiliado[0]->nombrePais.' <img class="flag flag-<?=strtolower($pais_afiliado[0]->codigo)?>">
														<br>
														<abbr title="Phone">Email:</abbr>'.$datos_afiliado[0]->email.'
													</address>
												</div>
												<div class="col-sm-3">
													<div>
														<div>
															<strong>FACTURA NO :</strong>
															<span class="pull-right">'.$_POST["id"].'</span>
														</div>
				
													</div>
													<div>
														<div class="">
															<abbr title="Phone"><strong>Fecha de expedición:</strong></abbr><span class="pull-right"> <i ></i> <?php echo $fecha;?> </span>
															<br>
															<br>
															<abbr title="Phone"><strong>Fecha de vencimiento:</strong></abbr><span class="pull-right"> <i ></i> <?php echo $fecha;?> </span>
														</div>
				
													</div>
													<br>

												</div>

											</div>

												<div class="panel panel-default">
  													<div class="panel-body">
														<span class="center"> <?php echo $empresa[0]->resolucion;?> </span>
  													</div>
												</div>
											<table class="table table-hover">
												<thead>
													<tr>
														<th class="text-center">Cantidad</th>
														<th>ITEM</th>
														<th>DESCRIPCION</th>
														<th>PRECIO</th>
														<th>IMPUESTO</th>
														<th>SUBTOTAL</th>
														<th></th>
													</tr>
												</thead>
												<tbody>';
												$contador=0;
												$total=0;
												foreach ($mercanciaFactura as $mercancia){										
															$html .= '<tr> 
																	<td class="text-center"><strong>'.$mercancia->cantidad.'</strong></td>
																	<td class="miniCartProductThumb"><img style="width: 8rem;" src="'.$info_mercancia[$contador]['imagen'].'" alt="img">'.$info_mercancia[$contador]['nombre'].'</td>
																	<td style="max-width: 25rem;"><a href="javascript:void(0);">'.$info_mercancia[$contador]['descripcion'].'</a></td>
																	<td>
												                        <span>$ '.($mercancia->costo_unidad*$mercancia->cantidad).' </span>
																	</td>
																	<td>
																	$ '.$mercancia->impuesto_unidad*$mercancia->cantidad.'
        															<br>'.$mercancia->nombreImpuesto.'
      																<br>
																	</td>
																	<td><strong>$ '.(($mercancia->costo_unidad*$mercancia->cantidad)+($mercancia->impuesto_unidad*$mercancia->cantidad)).'</strong></td>
																</tr>'; 
														$total+=(($mercancia->costo_unidad*$mercancia->cantidad)+($mercancia->impuesto_unidad*$mercancia->cantidad));
														$contador++;
												}
								                  
												$html .= '</tbody>
											</table>
				
											<div class="invoice-footer">
				
												<div class="row">
													<div class="col-sm-12">
														<div class="invoice-sum-total pull-right">
															<h3><strong>Total a Pagar: <span class="text-success">$ <?php echo $total;?></span></strong></h3>
														</div>
													</div>
				
												</div>
			
											</div>
											<div class="panel panel-default">
  												<div class="panel-body">
													<abbr title="Phone">Observaciones:</abbr><span class="center"> <?php echo $empresa[0]->comentarios;?> </span>
  												</div>
											</div>
										</div>
</div>';
/////////////////////////////////////////////////////////////////////////////////



		return $html;
		//return $this->template->build('website/bo/administracion/ventas/factura_2');
	}
}