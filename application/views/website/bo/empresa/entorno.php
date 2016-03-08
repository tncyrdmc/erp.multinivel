
<!-- MAIN CONTENT -->
<div id="content">
	<div class="row">
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
			<h1 class="page-title txt-color-blueDark">
			
			
						<a class="backHome" href="/bo"><i class="fa fa-home"></i> Menu</a>
							<span>>
							<a href="/bo/configuracion">Configuración</a>
							</span>
							<span>>
							<a href="/bo/configuracion/empresa">Empresa</a>
							</span>
							<span>
							>Configurar Entorno
							</span>
							</h1>
		</div>
	</div>
	<section id="widget-grid" class="">
		<!-- START ROW -->
		<div class="row">

			<!-- NEW COL START -->
			<article class="col-sm-12 col-md-12 col-lg-12">
				<!-- Widget ID (each widget will need unique ID)-->
				<div class="jarviswidget" id="wid-id-1"
					data-widget-editbutton="false" data-widget-custombutton="false"
					data-widget-colorbutton="false">
					<!-- widget options:
						usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
						
						data-widget-colorbutton="false"	
						data-widget-editbutton="false"
						data-widget-togglebutton="false"
						data-widget-deletebutton="false"
						data-widget-fullscreenbutton="false"
						data-widget-custombutton="false"
						data-widget-collapsed="true" 
						data-widget-sortable="false"
						
					-->
					<header>
						<span class="widget-icon"> <i class="fa fa-wrench "></i> 						
						</span>
						<h2>Configurar Entorno</h2>
					</header>

					<!-- widget div-->
					<div>
						<form id="form_empresa" method="post" action="/bo/admin/entorno_empresa" role="form" class="smart-form">
					 <fieldset>
						 <legend>Compras obligatorias</legend>
						 <input type="hidden" value="<?=$empresa[0]->id_tributaria;?>" name="id" >
						 <section id="usuario" class="col col-3">
							 <label class="input">Membresia
								 <input type="checkbox" name="membresia" <?=$empresa[0]->membresia == 'ACT' ? "checked" : "";?> > 
							 </label>
						 </section>
						 <section id="usuario" class="col col-3">
							 <label class="input">Paquete
								 <input type="checkbox" name="paquete" <?=$empresa[0]->paquete == 'ACT' ? "checked" : "";?>>
							 </label> 
						 </section>
						 <section id="usuario" class="col col-3">
							 <label class="input">Producto / Servicio / Combinado
								 <input type="checkbox" name="item" <?=$empresa[0]->item == 'ACT' ? "checked" : "";?> >
							 </label>
						 </section>
					 </fieldset>
					 
						<footer>
<button style="margin: 1rem;margin-bottom: 4rem;" type="input" class="btn btn-success">Guardar</button>
							</footer>
				</form>
					</div>
					<!-- end widget div -->
				</div>
				<!-- end widget -->
			</article>
			<!-- END COL -->
		</div>
		<div class="row">
			<!-- a blank row to get started -->
			<div class="col-sm-12">
				<br /> <br />
			</div>
		</div>
		<!-- END ROW -->
	</section>
</div>

<script src="/template/js/plugin/jquery-form/jquery-form.min.js"></script>
<script src="/template/js/validacion.js"></script>
<script src="/template/js/plugin/fuelux/wizard/wizard.min.js"></script>
<script type="text/javascript">

$( "#form_empresa" ).submit(function( event ) {
	event.preventDefault();	
	iniciarSpinner();
	enviar();
});

function enviar()
{
	

					$.ajax({
						type: "POST",
						url: "/bo/admin/entorno_empresa",
						data: $("#form_empresa").serialize()
					})
					.done(function( msg )
					{
						bootbox.dialog({
						message: msg,
						title: 'Empresa',
						buttons: {
							success: {
							label: "Aceptar",
							className: "btn-success",
							callback: function() {
								location.href="/bo/configuracion/entorno";
								FinalizarSpinner();
							}
						}
					}
				})//fin done ajax

					});//Fin callback bootbox
}


</script>