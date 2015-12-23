
<?php 
	$j=0;
	$j=count($RangoVentas);
	$rangos1="";
	foreach($tipo_rango as $categoria){
		$rangos1=$rangos1."<option value=\'".$categoria->id."\'>".$categoria->nombre."</option>";
	}
?>
<form id="nueva" class="smart-form" action="/bo/rangos/actualizar_rangos" method="POST" novalidate="novalidate" >
							<fieldset>
								<input type="text" class="hide" name="id" value="<?php echo $_POST['id']; ?>" id="id">
								<label class="input"> Nombre
								<input type="text" name="nombre" required placeholder="Nombre" id="nombre" style="width: 50%;" class="form-control" value="<?php echo $rangos[0]->nombre; ?>" required>
								<label class="input"> Descripcion
								<textarea type="text" name="descripcion" required placeholder="Descripción" id="descripcion" style="width: 50%;" class="form-control" value="" required><?php echo $rangos[0]->descripcion; ?></textarea>
								<label class="input"> Condiciones
								<br>
								</label>

								<div class="row" id="rango">
										<div class="row">
										<div class="col col-lg-3 col-xs-2">
										</div>
										<div class="col col-lg-2 col-xs-2">
											<a style="cursor: pointer;" onclick="add_rango('.<?php echo $j ?>.')"> Agregar Condición <i class="fa fa-plus"></i></a>
										</div>
									</div>
		
								<?php
								$i=1;
									foreach ($RangoVentas as $rangoventas) {
										echo '<div class="row">';
										echo '<div id="'.$i.'" class="row">
										<div class="col col-lg-2">
										</div>';
											echo '<div class="col col-xs-12 col-sm-6 col-lg-3" id="id_tipo_condicion[]">'.
											'<label class="select">Tipo Condicion</label>'.
											'<label class="select">'.
											'<select id="id_tipo_condicion[]" name="id_tipo_condicion[]" >';
										foreach ($tipo_rango as $categoria) {

											if($rangoventas->id_tipo_rango==$categoria->id){
												echo '<option value="'.$categoria->id.'" selected>'.$categoria->nombre.'</option>';
											}else{
												echo '<option value="'.$categoria->id.'">'.$categoria->nombre.'</option>';
											}

											
										}

												echo '</select>'.'</label>'.'</div>';
												echo '<div class="col col-xs-12 col-sm-5 col-lg-3">Tarifa<label for="" class="input">'.'<i class="icon-prepend fa fa-sort"></i>'.'<input id="valor_rango[]" type="number" class="form-control" name="valor_rango[]" placeholder=""class="form-control" value="'.$rangoventas->valor.'" required />';
										if($i>1){
											echo '<a style="cursor: pointer; color: red;" onclick="delete_rango('.$i.')">Eliminar Rango <i class="fa fa-minus"></i></a>';
										}
										$i++;
										echo ''.'</label>'.'</div>'.'</div>';

										echo '</div>';

									}
								?>
									
								</div>
							</fieldset>
							<footer>
<button style="margin: 1rem;margin-bottom: 4rem;" type="input" class="btn btn-success">Guardar</button>

								<!--<a class="btn btn-success" onclick="enviar()">
									Guardar
								</a>-->
							</footer>


						</form>

<script src="/template/js/plugin/jquery-form/jquery-form.min.js"></script>
<script src="/template/js/validacion.js"></script>
<script src="/template/js/plugin/fuelux/wizard/wizard.min.js"></script>
<script type="text/javascript">
	$( "#nueva" ).submit(function( event ) {
	event.preventDefault();
	enviar();
});
function enviar() {

	 $.ajax({
							type: "POST",
							url: "/bo/rangos/actualizar_rangos",
							data: $('#nueva').serialize()
						})
						.done(function( msg ) {
							
									bootbox.dialog({
										message: msg,
										title: "Atención",
										buttons: {
											success: {
											label: "Ok!",
											className: "btn-success",
											callback: function() {
												location.href="/bo/rangos/listar";
												}
											}
										}
									});
						});//fin Done ajax
		
}
var i=0;
function add_rango(id)
{

	var code=	'<div class="row">'
	+'<div id="A'+i+'" class="row">'
	+'<div class="col col-lg-2">'
	+'</div>'
	+'<div class="col col-xs-12 col-sm-6 col-lg-3">'
		+'<label class="select">Tipo Condición'
		+'<select name="id_tipo_condicionAgregar[]" >'
		+'<?php	echo $rangos1; ?>'
	+'</select>'
	+'</label>'
	+'</div>'
	+'<div class="col col-xs-12 col-sm-5 col-lg-3">'
		+'Tarifa<label for="" class="input">'
			+'<i class="icon-prepend fa fa-sort"></i>'
			+'<input type="number" class="form-control" name="valor_rangoAgregar[]" placeholder=""class="form-control" required />'
			+'<a style="cursor: pointer; color:red;" onclick="delete_rango1('+i+')">Eliminar Rango <i class="fa fa-minus"></i></a>'
		+'</label>'
	+'</div>'
	+'</div>'
	+'</div>';
	$("#rango").append(code);
	i = i + 1
}
function delete_rango(id)
{	
	$("#"+id+"").remove();
	
}
function delete_rango1(id)
{	
	$("#A"+id+"").remove();
	
}

</script>