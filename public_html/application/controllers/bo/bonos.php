<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class bonos extends CI_Controller
{
	private $opciones="";

	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
		$this->load->model('bo/modelo_dashboard');
		$this->load->model('bo/model_admin');
		$this->load->model('bo/general');
		$this->load->model('bo/model_bonos');
		$this->load->model('model_tipo_red');
		$this->load->model('bo/model_admin');
	}
	
	function index()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario = $this->general->get_username($id);
	
		$style=$this->modelo_dashboard->get_style(1);
	
		$this->template->set("style",$style);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/configuracion/Bonos/index');
	}
	
	function alta()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$style=$this->modelo_dashboard->get_style(1);
		
		$rangosActivos=$this->model_bonos->get_rangos();
		$this->template->set("rangosActivos",$rangosActivos);
		
		$this->template->set("style",$style);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/configuracion/Bonos/alta');
	}
	
	function ingresar_bono(){

		$nombre=$_POST['nombre'];
		$descripcion=$_POST['descripcion'];
		$inicio=$_POST['inicio'];
		$fin=$_POST['fin'];
		$mes_desde_afiliacion=$_POST['mesDesdeAfiliacion'];
		$mes_desde_activacion=$_POST['mesDesdeActivacion'];
		$frecuencia=$_POST['frecuencia'];
		$plan = isset($_POST['plan']) && $_POST['plan']  ? "SI" : "NO";
		$estatus="ACT";

	
		$bono = $this->model_bonos->setUp($nombre,$descripcion,$inicio,$fin,$mes_desde_afiliacion,$mes_desde_activacion,$frecuencia,$estatus,$plan);
		$idBono=$this->model_bonos->insert_bono($bono);

		$id_niveles_bonos = $_POST['id_niveles_bonos'];
		$valores = $_POST['valor'];
			
		for ($i=0;$i<sizeof($valores);$i++){
			$valoresBono = $this->model_bonos->setUpValoresBones($idBono,$id_niveles_bonos[$i],$valores[$i]);
			$this->model_bonos->insert_bono_valor_niveles($valoresBono);
		}
		
		$rangos = $_POST['idTipoRango'];
		foreach ($rangos as $rango){
			$this->insertRangosRedesCondiciones($rango,$bono,$idBono);
		}
	}
		
	function set_Rango(){
		
		$rango=$this->model_bonos->get_rangos_id($_POST['idRango']);
		
		foreach ($rango as $tipoRango){
			if($tipoRango->tipo_rango==1)
				$this->set_Rango_Redes($_POST['idRango'],$tipoRango->tipo_rango,'cargar_niveles_red');
			else if($tipoRango->tipo_rango==2)
				$this->set_Rango_Redes($_POST['idRango'],$tipoRango->tipo_rango,'cargar_mercancia_red');
			else if($tipoRango->tipo_rango==3)
				$this->set_Rango_Redes($_POST['idRango'],$tipoRango->tipo_rango,'cargar_mercancia_red');
			
		}

	}
	
	function set_Rango_Redes($idRango,$idTipoRango,$nombreMetodo){
	
		
		$redes = $this->model_tipo_red->listarTodos();
		$todasLasredes="";
		foreach($redes as $red){
			$todasLasredes=$todasLasredes."<option value='".$red->id."'>".$red->nombre."</option>";
		}
	
		$rango=$this->model_bonos->get_rangos_id_tipo($_POST['idRango'],$idTipoRango);
		$idDiv=$idTipoRango;
		foreach ($rango as $tipoRango){
			echo '<div class="widget-body col col-12">
					<div id="divRedes" class="widget-body col col-4">
					<h3 class="semi-bold">Rango <span>( '.$tipoRango->nombre_rango.' )</span></h3>
					<hr class="simple">
						<ul id="myTab'.$_POST['idRango'].$tipoRango->tipo_rango.'" class="nav nav-tabs bordered">
							<li class="active">
								<a href="#s'.$_POST['idRango'].$tipoRango->tipo_rango.'" data-toggle="tab">'.$tipoRango->nombre_tipo_rango.'<span class="badge bg-color-blue txt-color-white">'.$tipoRango->valor.'</span></a>
							</li>
							<li class="">
								<a href="#s'.$_POST['idRango'].$tipoRango->tipo_rango.'2" data-toggle="tab"><i class="fa fa-fw fa-lg fa-gear"></i>Descripcion</a>
							</li>
						</ul>
							<div id="myTabContent'.$_POST['idRango'].$tipoRango->tipo_rango.'" class="tab-content padding-10">
								<div class="tab-pane fade active in" id="s'.$_POST['idRango'].$tipoRango->tipo_rango.'">
									<p>Se cumple cuando el afiliado genera '.$tipoRango->valor.' '.$tipoRango->nombre_tipo_rango.' en su red.</p>
								</div>
								<div class="tab-pane fade" id="s'.$_POST['idRango'].$tipoRango->tipo_rango.'2">
									<p>'.$tipoRango->descripcion.'</p>
									<input type="hidden" name="idTipoRango[]" value="'.$_POST['idRango'].$tipoRango->tipo_rango.'"><br>
								</div>
								</div>
				</div>
											
				<div class="widget-body col col-4">
					<h3 class="semi-bold">Redes</h3>
					<label class="select select-multiple">Seleccione las Redes validas para generar el bono
						<select multiple="" class="custom-scroll" style="max-width: 20rem;" name="id_red'.$idRango.$idTipoRango.'[]" onChange="'.$nombreMetodo.'($(this).val(),'.$tipoRango->id_rango.$idDiv.','.$idRango.$idTipoRango.');">
						<option selected value="0">--- Todas ---</option>
							'.$todasLasredes.'
						</select>
					</label>
					<div class="note">
						<strong>Nota:</strong> Mantenga pulsado el botón ctrl para seleccionar varias opciones.
					</div>
				</div>
									
				<div id="'.$tipoRango->id_rango.$idDiv.'" class="widget-body col col-4">
				</div>
			</div>';
		$idDiv++;
		}
	}

	function set_Frontalidad_Profundidad_Red(){

		if(sizeof($_POST['idRed'])==1){
			foreach ($_POST['idRed'] as $red){
				if($red==0){
					$this->set_todos_los_niveles_red($_POST['idRangoDiv']);
				
				}else {
					$capacidadRed = $this->model_tipo_red->getCapacidadRed($red);
					$this->set_niveles_red($capacidadRed[0]->frontal,$capacidadRed[0]->profundidad,$red,$_POST['idRangoDiv']);
				}
			}
		}else {
				$this->set_todos_los_niveles_red($_POST['idRangoDiv']);
		}
	}
	
	function set_tipos_mercancia(){
		$idRangoDiv=$_POST['idRangoDiv'];
		
		foreach ($_POST['idRed'] as $red){
			if($red==0){
				$this->set_todos_los_niveles_mercancia($idRangoDiv);
				return true;
			}		
		}

		$mercancia=$this->model_bonos->get_mercancia_tipos();
		$idDiv=mt_rand(0,100).$idRangoDiv;
		$opciones="";
		$i=1;
		foreach($mercancia as $merca){
			$opciones=$opciones."<option value='".$i."'>".$merca->descripcion."</option>";
			$i++;
		}
		
		echo '<h3 class="semi-bold">Tipos de Mercancia</h3>
					<label class="select select-multiple">Seleccione los Tipos de Mercancia
						<select multiple="" class="custom-scroll" style="max-width: 20rem;" name="id_condicion_1'.$idRangoDiv.'[]" onChange=\'set_mercancia($(this).val(),'.$idDiv.','.json_encode($_POST["idRed"]).','.$idRangoDiv.');\'>
						<option selected value="0">--- Todas ---</option>
						'.$opciones.'
						</select>
					</label>';
		echo'<div id="'.$idDiv.'"></div>';
	}
	
	function set_mercancia(){
		echo '<h3 class="semi-bold">Mercancias</h3>
						<label class="select select-multiple">Seleccione la mercancia
							<select multiple="" class="custom-scroll" style="max-width: 20rem;" name="id_condicion_2'.$_POST['idRangoDiv'].'[]">
								<option selected value="0">--- Todas ---</option>';
		foreach ($_POST['idRedes'] as $red){
			$this->set_mercancia_por_redes ( $red,$_POST['idTipoMercancia']);
		}
	
		echo'</select>
		</label>';
	}
	
	private function set_todos_los_niveles_red($idRangoDiv){
		echo '<h3 class="semi-bold">Frontalidad</h3>
					<label class="select select-multiple">Seleccione numero de Frontales
						<select multiple="" class="custom-scroll" style="max-width: 20rem;" name="id_condicion_1'.$idRangoDiv.'[]">
						<option selected value="0">--- Todas ---</option>
						</select>
					</label>';
			
		echo '<h3 class="semi-bold">Profundidad</h3>
					<label class="select select-multiple">Seleccione numero de Profundidad
						<select multiple="" class="custom-scroll" style="max-width: 20rem;" name="id_condicion_2'.$idRangoDiv.'[]">
						<option selected value="0">--- Todas ---</option>
						</select>
					</label>';
	}
	
	private function set_todos_los_niveles_mercancia($idRangoDiv){
		echo '<h3 class="semi-bold">Tipos de Mercancia</h3>
					<label class="select select-multiple">Seleccione los Tipos de Mercancia
						<select multiple="" class="custom-scroll" style="max-width: 20rem;" name="id_condicion_1'.$idRangoDiv.'[]">
						<option selected value="0">--- Todas ---</option>
						</select>
					</label>';
			
		echo '<h3 class="semi-bold">Mercancias</h3>
					<label class="select select-multiple">Seleccione la mercancia
						<select multiple="" class="custom-scroll" style="max-width: 20rem;" name="id_condicion_2'.$idRangoDiv.'[]">
						<option selected value="0">--- Todas ---</option>
						</select>
					</label>';
	}
	
	private function set_niveles_red($frontal,$profundidad,$idRed,$idRangoDiv){

		$opciones="";
		for($i=1;$i<=$frontal;$i++){
			$opciones=$opciones."<option value=\'".$i."\'>".$i."</option>";
		}
		echo '<h3 class="semi-bold">Frontalidad</h3>
					<label class="select select-multiple">Seleccione numero de Frontales
						<select multiple="" class="custom-scroll" style="max-width: 20rem;" name="id_condicion_1'.$idRangoDiv.'[]">
						<option selected value="0">--- Todas ---</option>
						'.$opciones.'
						</select>
					</label>';
			
		$opciones="";
		for($i=1;$i<=$profundidad;$i++){
			$opciones=$opciones."<option value='".$i."'>".$i."</option>";
		}
		echo '<h3 class="semi-bold">Profundidad</h3>
					<label class="select select-multiple">Seleccione numero de Profundidad
						<select multiple="" class="custom-scroll" style="max-width: 20rem;" name="id_condicion_2'.$idRangoDiv.'[]">
						<option selected value="0">--- Todas ---</option>
						'.$opciones.'
						</select>
					</label>';
	}
	
	private function set_mercancia_por_redes($red,$idTipoMercancia) {
		
		foreach ($idTipoMercancia as $idTipoMercancia){
		
			if($idTipoMercancia==1){
				$mercancias=$this->model_bonos->get_productos_red($red);
			}elseif($idTipoMercancia==2){
				$mercancias=$this->model_bonos->get_servicios_red($red);
			}elseif($idTipoMercancia==3){
				$mercancias=$this->model_bonos->get_combinados_red($red);
			}elseif($idTipoMercancia==4){
				$mercancias=$this->model_bonos->get_paquetes_red($red);
			}elseif($idTipoMercancia==5){
				
			}

			foreach ($mercancias as $mercancia){
				$opciones=$opciones."<option value='".$mercancia->id."'>".$mercancia->nombre."( ".$mercancia->Name." )</option>";
			}
			
			echo $opciones;
		}
	}
	
	private function insertRangosRedesCondiciones($rango,$bono,$idBono){
		$idRango=substr_replace($rango,"", -1);
		$idTipoRango=substr($rango, -1);
	
		foreach ($_POST['id_red'.$rango] as $red){
			$this->getCondicionesInsertBonos($rango,$idRango,$idTipoRango,$red,$bono,$idBono);
		}
	}
	
	private function getCondicionesInsertBonos($rango,$idRango,$idTipoRango,$red,$bono,$idBono) {
		$condiciones1=$this->getCondicionRango1Bono("id_condicion_1".$rango);
		$this->getCondiciones2InsertBonos("id_condicion_2".$rango,$condiciones1,$idRango,$idTipoRango,$red,$bono,$idBono);
	}
	
	private function getCondicionRango1Bono($tipoCondicion){
		$condiciones1=array();
	
		if(isset($_POST[$tipoCondicion])){
			foreach ($_POST[$tipoCondicion] as $condicion1){
	
				array_push($condiciones1,array($condicion1));
			}
			return $condiciones1;
		}
		return $condiciones1=array('0');
	}
	
	private function getCondiciones2InsertBonos($tipoCondicion,$condiciones1,$idRango,$idTipoRango,$red,$bono,$idBono){
	
		foreach ($condiciones1 as $condicion1){
			if(isset($_POST[$tipoCondicion])){
				foreach ($_POST[$tipoCondicion] as $condicion2){
					$condiciones=$this->model_bonos->setUpCondicion($idBono,$idRango,$idTipoRango,$red,$condicion1[0],$condicion2);
					$this->model_bonos->insert_condicion_bono($condiciones);
				}
			}else {
				    $condiciones=$this->model_bonos->setUpCondicion($idBono,$idRango,$idTipoRango,$red,$condicion1[0],0);
				    $this->model_bonos->insert_condicion_bono($condiciones);
			}
					
		}

	}
	/*
	
	function ValidarDatos($banco,$pais,$cuenta, $clabe){
		if (!isset($banco) && !isset($pais) && !isset($cuenta)){
			echo "Por favor llena el formulario";
			return false;
		}else{
			return true;
		}
	}
	
	function listar()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario = $this->general->get_username($id);
	
		$style=$this->modelo_dashboard->get_style(1);
		$bancos = $this->modelo_bancos->Bancos();
		
		$this->template->set("style",$style);
		$this->template->set("bancos",$bancos);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/configuracion/Bancos/listar');
	}
	
	function eliminar_banco(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
		redirect('/auth');
		}
		
		$id=$this->tank_auth->get_user_id();
		$usuario = $this->general->get_username($id);
		
		if(isset($_POST['id'])){
			$ventas = $this->modelo_bancos->ConsultarTransacionBanco($_POST['id']);
			
			if(isset($ventas[0]->id_banco)){
				echo "El Banco no se puede eliminar debido a que ya se han realizado pagos por medio del banco";
			}else{
				$this->modelo_bancos->EliminarBanco($_POST['id']);
				echo "El banco con id ".$_POST['id']." ha sido eliminado";
			}
		}
	}
	
	function cambiar_estado_banco(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
		redirect('/auth');
		}
		
		$id=$this->tank_auth->get_user_id();
		$usuario = $this->general->get_username($id);
		
		
		if(isset($_POST['id'])){
			$this->modelo_bancos->CambiarEstadoBanco($_POST['id'], $_POST['estado']);
		}
	}
	
	function editar_banco(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario = $this->general->get_username($id);
		$paises            = $this->model_admin->get_pais_activo();
		
		$style=$this->modelo_dashboard->get_style(1);
		$banco = $this->modelo_bancos->Banco($_POST['id']);
		
		$this->template->set("style",$style);
		$this->template->set("banco",$banco);
		$this->template->set("paices",$paises);
		
		$this->template->build('website/bo/configuracion/Bancos/editar');
	}
	
	function actualizar_banco(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id = $this->tank_auth->get_user_id();
	
		if(isset($_POST)){
			$id_banco = $_POST['id'];
			$banco = $_POST['banco'];
			$pais = $_POST['pais'];
			$cuenta = $_POST['cuenta'];
			$clabe = $_POST['clabe'];
				
			if($this->ValidarDatos2($banco, $pais, $cuenta, $clabe)){
					
				$this->ValidarDatos2($banco,$pais,$cuenta, $clabe);
			
				$this->modelo_bancos->actualizar_banco($id_banco, $banco, $cuenta, $pais, $clabe);
				echo "El Banco a sido actualizado.";
					
					
			}
		}
	}
	
	function ValidarDatos2($banco,$pais,$cuenta, $clabe){
		if (!isset($banco) && !isset($pais) && !isset($cuenta)){
			
			echo "Por favor llena el formulario.";
			return false;
		}else{
			return true;
		}
	}
*/
}