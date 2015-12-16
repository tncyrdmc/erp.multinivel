	<!-- MAIN CONTENT -->
			<div id="content" >
				<div class="row">
					<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
						<h1 class="page-title txt-color-blueDark">
							<a class="backHome" href="/bo"><i class="fa fa-home"></i> Menu</a>
							<span>>
								<a href="/bo/configuracion/">Configuracion</a> > 
								<a href="/bo/configuracion/compensacion/">Plan de compensacion</a> >
								<a href="/bo/rangos/">Rangos</a>
								> Nuevo rango
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
		<form class="smart-form" action="/bo/rangos/ingresar_rango/" method="POST" role="form">
			<legend>Nuevo Rango</legend><br>
			
			<label style="margin: 1rem;" class="input"><i class="icon-prepend fa fa-check-circle-o"></i>
				<input id='nombre' class="form-control" name="nombre" style="width:200px; height:30px;" placeholder="Nombre" type="text" required>
	        </label>
			<label style="margin: 1rem;">
				<textarea id='desc' class="form-control" name="desc" size="20" cols="20" rows="10" placeholder="Descripción" type="text" required></textarea>
	        </label>

		<div class="form-group" style="width: 100rem;">
	        <div class="row" id="cross_tipo_rango">
									<header>Condiciones</header><br><br>
									<div class="row">
										<div class="col col-lg-3 col-xs-2">
										</div>																	
									</div>


									<div class="row">
										<div class="col col-lg-2">
										</div>
										<div class="col col-xs-12 col-sm-6 col-lg-3" id="tipo">

											<header>Venta</header>
										</div>
										
										<div class="col col-xs-12 col-sm-5 col-lg-3">
											Valor<label for="" class="input">
												<i class="icon-prepend fa fa-money"></i>

												<input type="text" id="venta" class="form-control"  name="valor_tipo" placeholder=""class="form-control" required />
											</label>		
										</div>
									</div>	


										<div class="row">
										<div class="col col-lg-2">
										</div>
										<div class="col col-xs-12 col-sm-6 col-lg-3" id="tipo">
											<header>Afiliados</header>
										</div>
										
										<div class="col col-xs-12 col-sm-5 col-lg-3">
											Valor<label for="" class="input">
												<i class="icon-prepend fa fa-sort"></i>

												<input type="text"  id="afiliados" class="form-control"  name="valor_tipo" placeholder=""class="form-control" required />
											</label>		
										</div>
									</div>	

									<div class="row">
										<div class="col col-lg-2">
										</div>
										<div class="col col-xs-12 col-sm-6 col-lg-3" id="tipo">
											<header>Puntos</header>
										</div>
										
										<div class="col col-xs-12 col-sm-5 col-lg-3">
											Valor<label for="" class="input">
												<i class="icon-prepend fa fa-sort"></i>

												<input type="text" id="puntos" class="form-control"  name="puntos" placeholder=""class="form-control" required />
											</label>		
										</div>
									</div>

			</div>
		</div>


								<div id="tipos">
								
								</div>

			<button style="margin: 1rem;margin-bottom: 4rem;" type="button" onclick="enviar()" class="btn btn-success">Crear</button>
			
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

var name="";
var descr="";
var venta="";
var afiliados="";
var puntos="";
//var mensaje="Hola";



function enviar() {
	var name=$("#nombre").val();
	descr=$("#desc").val();
	venta=$("#venta").val();
	afiliados=$("#afiliados").val();
	puntos=$("#puntos").val();
	alert(venta);
	alert(afiliados);
	alert(puntos);
	$.ajax({
							type: "POST",
							url: "/bo/rangos/ingresar_rango",
							data: {
								nombre:name,
								desc:descr,
								venta:venta,
								afiliado:afiliados,
								punto:puntos
							}
						})
						.done(function( msg ) {
							

						});//fin Done ajax
	
}


	function add_condicion()
{

	id_tipo+=$('#t0').val();
	alert(id_tipo);
	$.ajax({
		type: "POST",
		url: "/bo/rangos/set_tipo_rango",
		data: {id: id_tipo}
	})
	.done(function( msg )
	{

	var code=	'<div id="'+(i)+'" class="row">'
	+'<div class="col col-lg-2">'
	+'</div>'
	+'<div class="col col-xs-12 col-sm-6 col-lg-3" id="tipo">'
		+'<label class="select">Tipo de Condicion'
		+'<select name="tipo_rango" id="t'+(i)+'"">'
		+ msg
		+'</select>'
	+'</label>'
	+'</div>'
	+'<div class="col col-xs-12 col-sm-5 col-lg-3">'
		+'Valor<label for="" class="input">'
			+'<i class="icon-prepend fa fa-sort"></i>'
			+'<input type="number" class="form-control" name="valor_tipo" placeholder=""class="form-control" required />'
			+'<a style="cursor: pointer;" onclick="delete_condicion('+i+')">Eliminar Condicion <i class="fa fa-minus"></i></a>'
		+'</label>'
	+'</div>'
	+'</div>';
	$("#cross_tipo_rango").append(code);
	id_tipo+=',';
	id_tipo+=$('#t"+i"').val();
	alert(d_tipo);
	i = i + 1;	
	
	});


}

function delete_condicion(id)
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
			
