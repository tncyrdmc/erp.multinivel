<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class reportes_logistico extends CI_Controller
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
		$this->load->model('model_tipo_red');
		$this->load->model('model_servicio');
		$this->load->model('bo/modelo_reportes_logistico');
		$this->load->model('general');
		$this->load->model('modelo_cobros');
	}

	function index()
	{
		if (!$this->tank_auth->is_logged_in()) 
		{																		// logged in
			redirect('/auth');
		}

		$id=$this->tank_auth->get_user_id();
		
		if(!$this->general->isAValidUser($id,"logistica"))
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
		$this->template->build('website/bo/logistico2/reportes/reportes');
	}
	
	function reporte_inventario()
	{
		$id=$this->tank_auth->get_user_id();
	
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
	
		if(!$this->general->isAValidUser($id,"logistica"))
		{
			redirect('/auth/logout');
		}
	
		$usuario=$this->general->get_username($id);
		
		$inventario = $this->modelo_reportes_logistico->inventario();
		
		echo
		"<table id='datatable_fixed_column1' class='table table-striped table-bordered table-hover' width='100%'>
				<thead id='tablacabeza'>
					<th>ID</th>
					<th>Almacen / CEDI</th>
					<th>Producto</th>
					<th>Cantidad</th>
					<th>Bloqueo</th>
				</thead>
				<tbody>";
		foreach ($inventario as $producto){
			echo "<tr>
					<td class='sorting_1'>".$producto->id_inventario."</td>
					<td>".$producto->almacen."</td>
					<td>".$producto->producto."</td>
					<td>".$producto->cantidad."</td>
					<td>".$producto->bloqueados."</td>
				</tr>";
		}
			
		echo "</tbody>
			</table><tr class='odd' role='row'>";
	
	
	}
	
	function reporte_inventario_excel()
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
	
		$usuario=$this->general->get_username($id);
		$inventario = $this->modelo_reportes_logistico->inventario();
		
		$this->load->library('excel');
		$this->excel=PHPExcel_IOFactory::load(FCPATH."/application/third_party/templates/reporte_inventario.xls");
		foreach ($inventario as $producto)
		{
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, ($i+8), $producto->id_inventario);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, ($i+8), $producto->almacen);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, ($i+8), $producto->producto);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, ($i+8), $producto->cantidad);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, ($i+8), $producto->bloqueados);
		}
	
		$filename='inventario.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
	
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		//force user to download the Excel file without writing it to server's HD
		//$objWriter->save(getcwd()."/media/reportes/".$filename);
		$objWriter->save('php://output');
	}
}