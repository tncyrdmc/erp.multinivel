<form id="nueva" class="smart-form"  novalidate="novalidate" >
							<fieldset>
								<input type="text" class="hide" name="id" value="<?php echo $_POST['id']; ?>" name="id">
								<label class="input"> Nombre
								<input type="text" name="nombre" required placeholder="Nombre" style="width: 50%;" class="form-control" value="<?php echo $rangos[0]->name; ?>" required>
								<label class="input"> Descripcion
								<input type="text" name="descripcion" required placeholder="Nombre" style="width: 50%;" class="form-control" value="<?php echo $rangos[0]->descripcion; ?>" required>
								<label class="input"> Condiciones
								<input type="text" name="name" required placeholder="Nombre" style="width: 50%;" class="form-control" value="" required>
								<input type="number" name="porcentaje" required placeholder="valor" style="width: 50%;" class="form-control" value="" required>
								<br>

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