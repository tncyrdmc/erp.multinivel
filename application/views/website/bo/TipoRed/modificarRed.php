<div id="spinner-div"></div>
<div style="background: rgb(255, 255, 255) none repeat scroll 0% 0%; margin-right: 0px; margin-left: 0px; padding-bottom: 3rem;" class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<form action="/bo/tipo_red/actualizar_red" method="POST" id="redes" role="form">
	
		<div class="form-group">
			
			<input type="text" class="hide" name="id" value = '<?= $id_red;?>' >
			
			<label for="">Nombre</label>
			<input type="text" class="form-control" required name="nombre" value = '<?= $datosDeRed[0]->nombre;?>'>

			<label for="">Descripcion</label>
			<textarea class="form-control" required name="descripcion" ><?= $datosDeRed[0]->descripcion;?></textarea>
		</div>
		<button type="submit" class="btn btn-success"  >Actualizar</button>
	</form>
</div>
</div>

<script src="/template/js/plugin/jquery-form/jquery-form.min.js"></script>
<script src="/template/js/validacion.js"></script>
<script src="/template/js/plugin/fuelux/wizard/wizard.min.js"></script>
<script type="text/javascript">
$( "#redes" ).submit(function( event ) {
	event.preventDefault();
	setiniciarSpinner();
	enviar_datos();
});

function enviar_datos(){
	$.ajax({
		type: "POST",
		url: "/bo/tipo_red/actualizar_red",
		data: $('#redes').serialize()
	}).done(function( msg ) {				
		bootbox.dialog({
			message: msg,
			title: 'ATENCION',
			buttons: {
				success: {
					label: "Aceptar",
					className: "btn-success",
					callback: function() {
							location.href="/bo/tipo_red/mostrar_redes";
							FinalizarSpinner();
					}
				}
			}
		})
	});//fin Done ajax
}

</script>