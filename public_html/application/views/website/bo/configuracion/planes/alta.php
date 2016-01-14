<?php 
	$select_bonos="";
	foreach($bonos_plan as $categoria){
		$select_bonos+="<option value=\'".$categoria->id."\'>".$categoria->nombre."</option>";
	}
?>

	<!-- MAIN CONTENT -->
			<div id="content" >
				<div class="row">
					<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
						<h1 class="page-title txt-color-blueDark">
							<a class="backHome" href="/bo"><i class="fa fa-home"></i> Menu</a>
							<span>>
								<a href="/bo/configuracion/">Configuracion</a> > 
								<a href="/bo/configuracion/compensacion/">Plan de compensacion</a> >
								<a href="/bo/planes/">Planes de Bonos</a>
								> Nuevo Plan
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
				<div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false"
          data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-sortable="false"
          data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-collapsed="false">
					<div>

						<!-- widget edit box -->
						<div class="jarviswidget-editbox">
							<!-- This area used as dropdown edit box -->

						</div>
						<!-- end widget edit box -->
						<!-- widget content -->
						<div class="widget-body no-padding smart-form">
<div>
    <fieldset id="pswd">
		<form id="planes" action="/bo/rangos/ingresar_rango/" method="POST" role="form">
			<legend>Nuevo Plan</legend><br>
			
			<label style="margin: 1rem;" class="input"><i class="icon-prepend fa fa-check-circle-o"></i>
				<input id='nombre' class="form-control" name="nombre" style="width:200px; height:30px;" placeholder="Nombre" type="text" required>
	        </label>
			<label style="margin: 1rem;">
				<textarea id='desc' class="form-control" name="desc" size="20" cols="20" rows="10" placeholder="Descripción" type="text" required></textarea>
	        </label>

		<div class="form-group" style="width: 100rem;">
	        <div class="row" id="cross_plan_bonos">
									<header>Bonos</header><br><br>
									<div class="row">
										<div class="col col-lg-3 col-xs-2">
										</div>																	
									</div>

									<div class="row" id="bono">
									<div class="row">
										<div class="col col-lg-3 col-xs-2">
										</div>
										<div class="col col-lg-2 col-xs-2">
											<a style="cursor: pointer;" onclick="add_bono()"> Agregar Bono <i class="fa fa-plus"></i></a>
										</div>
										
									</div>
									<div class="row">
										<div class="col col-lg-2">
										</div>
										<div class="col col-xs-12 col-sm-6 col-lg-3" id="bono_plan">
											<label class="select">Seleccione Bono
											<select name="id_bono_plan[]" >
													<?php	
														foreach($bonos_plan as $categoria){
															echo "<option value='".$categoria->id."'>".$categoria->nombre."</option>";
														}
													?>
											</select>
											</label>
										</div>
										
										
									</div>
									
								</div>
								
								<div id="bono">
								
								</div>

			<button style="margin: 1rem;margin-bottom: 4rem;" type="input" class="btn btn-success">Crear</button>
			
		</form>
    </fieldset>
	</div>
						</div>
						<!-- end widget content -->

					</div>
					<!-- end widget div -->
				</div>
				<!-- end widget -->
			</article>
			<!-- END COL -->
		</div>
	</section>	
				<div class="row">         
			        <!-- a blank row to get started -->
			        <div class="col-sm-12">
			            <br />
			            <br />
			        </div>
		        </div>
			</div>
			<!-- END MAIN CONTENT -->

<script type="text/javascript">
var i=0;

$( "#planes" ).submit(function( event ) {
	event.preventDefault();
	enviar();
});
function validar_bonos_repetidos(){
		var bonos = new Array();
		var bono_repetido=false;
$('select[name="id_bono_plan[]"]').each(function() {	
	bonos.push($(this).val());
});	

   for(i=0;i<(bonos.length-1);i++){
     for(j=i+1;j<(bonos.length);j++){
          if(bonos[i]==bonos[j]){
          	bono_repetido=true;
          }
 
     }
 }
     return bono_repetido;
}
function enviar() {
	var verificar_plan=false;
	verificar_plan=validar_bonos_repetidos();
	if(verificar_plan!=true){
	$.ajax({
						type: "POST",
						url: "/bo/planes/ingresar_plan",
						data: $('#planes').serialize()
						})
						.done(function( msg ) {
							
							bootbox.dialog({
						message: "Se ha creado el rango."+msg,
						title: 'Felicitaciones',
						buttons: {
							success: {
							label: "Aceptar",
							className: "btn-success",
							callback: function() {
							//	location.href="/bo/planes/listar";
								}
							}
						}
					})
						});//fin Done ajax
	}else{
		alert("Ha repetido alguna condición del rango");
	}
}

function add_bono()
{

	var code=	'<div id="'+i+'" class="row">'
	+'<div class="col col-lg-2">'
	+'</div>'
	+'<div class="col col-xs-12 col-sm-6 col-lg-3">'
		+'<label class="select">Seleccione Bono'
		+'<select name="id_bono_plan[]" >'
		+'<?php	echo $select_bonos; ?>'
	+'</select>'
	+'</label>'
	+'</div>'
	+'<div class="col col-xs-12 col-sm-5 col-lg-3">'
		+'<a style="cursor: pointer;" onclick="delete_rango('+i+')">Eliminar Rango <i class="fa fa-minus"></i></a>'
	+'</label>'
	+'</div>'	
	+'</div>';
	$("#bono").append(code);
	i = i + 1
}

function delete_rango(id)
{	
	$("#"+id+"").remove();
	
}


</script>
	


<style>
.link
{
	margin: 0.5rem;
}
.minh
{
	padding: 50px;
}
.link a:hover
{
	text-decoration: none !important;
}
</style>
			
