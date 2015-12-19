<form id="nueva" class="smart-form"  novalidate="novalidate" >
							<fieldset>
								<input type="text" class="hide" name="id" value="<?php echo $_POST['id']; ?>" name="id">
								<label class="input"> Nombre
								<input type="text" name="nombre" required placeholder="Nombre" style="width: 50%;" class="form-control" value="<?php echo $rangos[0]->nombre; ?>" required>
								<label class="input"> Descripcion
								<input type="text" name="descripcion" required placeholder="Nombre" style="width: 50%;" class="form-control" value="<?php echo $rangos[0]->descripcion; ?>" required>
								<label class="input"> Condiciones
								<br>

													<?php
													$Valor_Rango="";	
														foreach($RangoVentas as $rangoventa ){

															echo '<div class="row">
																		<div class="col col-lg-2">
																		</div>
																		<div class="col col-xs-12 col-sm-6 col-lg-3" id="tipo_condicion">
																	<label class="select">Tipo Condicion
																	<select name="id_tipo_condicion[]" >';
														foreach($tipo_rango as $categoria){
																if($categoria->id==$rangoventa->$rangoventa->id_tipo_rango){
															echo "<option selected>".$categoria->nombre."";
															$Valor_Rango=$rangoventa->valor;
																			}
																echo "<option value='".$categoria->id."'>".$categoria->nombre."</option>";
																
														}
															
														echo "</select>
																</label>
																</div>";
/*
															foreach($tipo_rango as $categoria){
																		if($categoria->id==$rangoventa->$rangoventa->id_tipo_rango){
																				echo '<div class="col col-xs-12 col-sm-5 col-lg-3">'.
																						'Valor<label for="" class="input">'.
																						'<i class="icon-prepend fa fa-sort"></i>'.
																						'<input id="valor_rango[]" type="number" class="form-control" name="valor_rango[]" placeholder=""class="form-control" value="'.echo $Valor_Rango;.'"'.
																						"</label>div></div>";}


															}*/											

			
														}
													?>

										
										
											
												
												
											</label>		
										</div>
									</div>


							</fieldset>
							<footer>
								<a class="btn btn-success" onclick="enviar()">
									Guardar
								</a>
							</footer>
						</form>

<script src="/template/js/plugin/jquery-form/jquery-form.min.js"></script>
<script src="/template/js/validacion.js"></script>
<script src="/template/js/plugin/fuelux/wizard/wizard.min.js"></script>
<script type="text/javascript">
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
</script>