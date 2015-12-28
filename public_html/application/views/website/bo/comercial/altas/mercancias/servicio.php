
<!-- MAIN CONTENT -->
<div id="content">
	<div class="row">
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
			<h1 class="page-title txt-color-blueDark">
			
				<?php  if($type=='5'){?>
				<a class="backHome" href="/bo"><i class="fa fa-home"></i> Menu</a>
				<span>&gt;
								 <a href="/bo/comercial/carrito_de_compras"> Mercancia</a>
								> <a href="/bo/mercancia/index" >Alta</a> > Servicio
				</span>
				<?php }else{?>	
				<a class="backHome" href="/bo"><i class="fa fa-home"></i> Menu</a>
				<span>&gt;
								<a href="/bo/comercial">Comercial</a> > <a href="/bo/comercial/carrito_de_compras"> Carrito de Compras </a>
								> <a href="/bo/mercancia/index" >Alta</a> > Servicio
				</span>
				
				<?php }?>
			</h1>
		</div>
	</div>
	<?php if($this->session->flashdata('error')) {
		echo '<div class="alert alert-danger fade in">
								<button class="close" data-dismiss="alert">
									×
								</button>
								<i class="fa-fw fa fa-check"></i>
								<strong>Error </strong> '.$this->session->flashdata('error').'
			</div>'; 
	}
	?>	 
	<section id="widget-grid" class="">
		<!-- START ROW -->
		<div class="row">
			<!-- NEW COL START -->
			<article class="col-sm-12 col-md-12 col-lg-12">
				<!-- Widget ID (each widget will need unique ID)-->
				<div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-colorbutton="false"	>
					
					<header>
						<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
						<h2>Mercancia</h2>				
						
					</header>

					<!-- widget div-->
					
						<div class="widget-body">
							<form method="POST" enctype="multipart/form-data"  action="/bo/mercancia/CrearServicio" class="smart-form">
								<input type="text" class="hide" value="<?php echo $_GET['id']; ?>" name="tipo_mercancia">
									
								<fieldset>
									<legend>Datos del Servicio</legend>
									<div id="form_mercancia">
										<div class="row">
												<fieldset>
													<section class="col col-2">
														<label class="input">Nombre
															<input required type="text" id="nombre_s" name="nombre">
														</label>
													</section>
													<section class="col col-2">
														<label class="input">Concepto
															<input required type="text" id="concepto" name="concepto">
														</label>
													</section>
													<section class="col col-2">
														<label class="input">Fecha de inicio
														<input required type="text" name="fecha_inicio" id="startdate" readonly="readonly" /> </label>
													</section>
													<section class="col col-2">
														<label class="input">Fecha de termino
														<input type="text" name="fecha_fin" id="finishdate" readonly="readonly"/> </label>
													</section>
													<section class="col col-3">Categoria
															<label class="select">
																<select name="red">
																<?foreach ($grupos as $grupo){?>
																	<option value="<?=$grupo->id_grupo?>">
																	<?= $grupo->descripcion." (".$grupo->red.")" ?>
																	</option>
																<?}?>
																</select>
															</label>
														</section>
													<div>
														<section style="padding-left: 0px;" class="col col-6">Descripcion
															<textarea name="descripcion" style="max-width: 96%" id="mymarkdown"></textarea>
														</section>
														
														<section id="imagenes" class="col col-6">
														<label class="label">Imágen</label>
														<div class="input input-file">
															<span class="button">
																<input id="img" name="img[]" onchange="this.parentNode.nextSibling.value = this.value" type="file" multiple>Buscar</span><input id="imagen_mr" placeholder="Agregar alguna imágen" readonly="" type="text">
															</div>
															<small>Para cargar múltiples archivos, presione la tecla ctrl y sin soltar selecione sus archivos.<br /><cite title="Source Title">Para ver los archivos que va a cargar, deje el puntero sobre el boton de "Buscar"</cite></small>
														</section>
													</div>
														
												</fieldset>
												<fieldset id="moneda_field">
													<legend>Moneda y país</legend>
													<section class="col col-2">
														<label class="input">
														Costo real
														<input type="text" name="real" id="real">
														</label>
													</section>
													<section class="col col-2">
														<label class="input">Costo distribuidores
														<input type="text" name="costo" id="costo">
														</label>
													</section>
													<section class="col col-2">
														<label class="input">Costo publico
														<input type="text" name="costo_publico" id="costo_publico">
														</label>
													</section>
													<section class="col col-2">
														<label class="input">
														Tiempo mínimo de entrega
														<input placeholder="En días" type="text" name="entrega" id="entrega">
														</label>
													</section>

									
													<section class="col col-3">Proveedor
														<label class="select">
															<select name="proveedor" id="proveedor_select" required>
															<?foreach ($proveedores as $key){?>
																<option value="<?=$key->user_id?>">
																	<?=$key->nombre." ".$key->apellido?>
																</option>
															<?}?>
															</select>
														</label>
														<a style="cursor: pointer;" onclick="add_proveedor()">Agregar Proveedor<i class="fa fa-plus"></i></a>
											
													</section>
													
													<section class="col col-3">
														<label class="input">
														Puntos comisionables
															<input type="number" min="1" max="" name="puntos_com" id="puntos_com">
														</label>
													</section>
													<legend>Impuestos</legend>

													
													<div class="row">
														<section class="col col-2">País del servicio
														<label class="select">
															<select id="pais" required name="pais" onChange="ImpuestosPais()">
															<option value="-" selected>-- Seleciona un pais --</option>
															<?foreach ($pais as $key){?>
																<option value="<?=$key->Code?>">
																<?=$key->Name?></option>
															<?}?>
															</select>
														</label>
													</section>
																	<section class="col col-2" id="impuesto">Impuesto
														<label class="select">
															<select name="id_impuesto[]" >
															
															</select>
															
														</label>
														<a style="cursor: pointer;" onclick="add_impuesto()">Agregar impuesto<i class="fa fa-plus"></i></a>
													</section>
															<section class="col col-2">Requiere especificación
																<div class="inline-group">
																	<label class="radio">
																		<input type="radio" value="1" name="iva" checked="">
																		<i></i>con IVA</label>
																		<label class="radio">
																			<input type="radio" value="0" name="iva">
																			<i></i>más IVA</label>
																		</div>
																	</section>
																	</div>
																	<div class="row">
																		<section class="col col-2">
														<label class="input">
															Costo real con IVA
															<input type="number" min="1" max="" name="real_iva" id="real_iva" disabled>
														</label>
													</section>
													<section class="col col-2">
														<label class="input">
															Costo distribuidores con IVA
															<input type="number" min="1" max="" name="distribuidores_iva" id="distribuidores_iva" disabled>
														</label>
													</section>
													<section class="col col-2">
														<label class="input">
															Costo público con IVA
															<input type="number" min="1" max="" name="publico_iva" id="publico_iva" disabled>
														</label>
													</section>
													</div>
												</fieldset>
											</div>
										</div>
									</fieldset>
									<footer>
										<button type="submit" class="btn btn-primary">
											Agregar
										</button>
									</footer>
								</form>
							</div>
						</div>
					</article>
				</div>
			
		</section>
	</div>
											<!-- END MAIN CONTENT -->
											<script src="/template/js/plugin/dropzone/dropzone.min.js"></script>
											<script src="/template/js/plugin/markdown/markdown.min.js"></script>
											<script src="/template/js/plugin/markdown/to-markdown.min.js"></script>
											<script src="/template/js/plugin/markdown/bootstrap-markdown.min.js"></script>
											<script src="/template/js/plugin/datatables/jquery.dataTables.min.js"></script>
											<script src="/template/js/plugin/datatables/dataTables.colVis.min.js"></script>
											<script src="/template/js/plugin/datatables/dataTables.tableTools.min.js"></script>
											<script src="/template/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
											<script src="/template/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
											<script src="/template/js/validacion.js"></script>
											<script type="text/javascript">

// DO NOT REMOVE : GLOBAL FUNCTIONS!
var i = 0;
$(document).ready(function() {
	
	$("#mymarkdown").markdown({
		autofocus:false,
		savable:false
	})

	$('#startdate').datepicker({
			changeMonth: true,
			numberOfMonths: 2,
			dateFormat:"yy-mm-dd",
			changeYear: true,
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>',
			onSelect : function(selectedDate) {
				$('#finishdate').datepicker('option', 'minDate', selectedDate);
			}
		});

		$('#finishdate').datepicker({
			changeMonth: true,
			numberOfMonths: 2,
			dateFormat:"yy-mm-dd",
			changeYear: true,
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>',
			onSelect : function(selectedDate) {
				$('#startdate').datepicker('option', 'maxDate', selectedDate);
			}
		});
	/* BASIC ;*/
	var responsiveHelper_dt_basic = undefined;
	var responsiveHelper_datatable_fixed_column = undefined;
	var responsiveHelper_datatable_col_reorder = undefined;
	var responsiveHelper_datatable_tabletools = undefined;

	var breakpointDefinition = {
		tablet : 1024,
		phone : 480
	};

	$('#dt_basic').dataTable({
		"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
		"t"+
		"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
		"autoWidth" : true,
		"preDrawCallback" : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_dt_basic) {
					responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				responsiveHelper_dt_basic.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_dt_basic.respond();
			}
		});

	/* END BASIC */

	/* BASIC ;*/
	var responsiveHelper_dt_basic = undefined;
	var responsiveHelper_datatable_fixed_column = undefined;
	var responsiveHelper_datatable_col_reorder = undefined;
	var responsiveHelper_datatable_tabletools = undefined;

	var breakpointDefinition = {
		tablet : 1024,
		phone : 480
	};

	$('#dt_basic_paquete').dataTable({
		"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
		"t"+
		"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
		"autoWidth" : true,
		"preDrawCallback" : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_dt_basic) {
					responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				responsiveHelper_dt_basic.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_dt_basic.respond();
			}
		});

	/* END BASIC */

	pageSetUp();

});

function add_impuesto()
{
	var code=	'<div id="'+i+'"><section class="col col-3" id="impuesto">Impuesto'
	+'<label class="select">'
	+'<select name="id_impuesto[]">'
	<?foreach ($impuesto as $key)
	{
		echo "+'<option value=".$key->id_impuesto.">".$key->descripcion." ".$key->porcentaje."%"."</option>'";
	}?>
	+'</select>'
	+'</label>'
	+'<a class="txt-color-red" style="cursor: pointer;" onclick="dell_impuesto('+i+')">Eliminar <i class="fa fa-minus"></i></a>'
	+'</section></div>';
	$("#moneda_field").append(code);
	ImpuestosPais();
	i = i + 1
}

function dell_impuesto(id)
{	
	$("#"+id+"").remove();
	
}
function ImpuestosPais(){
	var pa = $("#pais").val();
	
	$.ajax({
		type: "POST",
		url: "/bo/mercancia/ImpuestaPais",
		data: {pais: pa}
	})
	.done(function( msg )
	{
		$('#impuesto option').each(function() {
		    
		        $(this).remove();
		    
		});
		datos=$.parseJSON(msg);
	      for(var i in datos){
		      var impuestos = $('#impuesto');
		      $('#impuesto select').each(function() {
				  $(this).append('<option value="'+datos[i]['id_impuesto']+'">'+datos[i]['descripcion']+' '+datos[i]['porcentaje']+'</option>');
			    
			});
	    	  
	        
	      }
	});
}
function add_proveedor(){

	$.ajax({
		type: "POST",
		url: "formProveedor",
		data: { i : 0 }
	})
	.done(function( msg )
	{
		bootbox.dialog({
			message: msg,
			title: "Nuevo proveedor",
			buttons: {
				submit: {
				label: "Aceptar",
				className: "btn-success",
				callback: function() {
					new_proveedor()
					}
				},
					danger: {
					label: "Cancelar",
					className: "btn-danger",
					callback: function() {

						}
				}
			}
		})
	});
}

function new_proveedor()
{
		var ids = new Array( 
			"#nombre",
		 	"#apellido",
		 	"#pais",
		 	"#cp",
		 	"#tipo_proveedor",
		 	"#email",
		 	"#empresa"
		 );
		var mensajes = new Array( 
			"Por favor ingresa tu nombre",
		 	"Por favor ingresa tu apellido",
		 	"Por favor seleciona un pais",
		 	"Por favor ingresa tu código postal",
		 	"Por favor seleciona el tipo de proveedor",
		 	"Por favor ingresa un correo",
		 	"Por favor seleciona una empresa"
		 );
		
		var validacion = valida_vacios(ids,mensajes);
		
		if(validacion)
		{
			
			$.ajax({
				type: "POST",
				url: "/bo/mercancia/new_proveedor",
				data: $('#proveedor').serialize()
			})
			.done(function( msg1) {
				$("#proveedor_select").append(msg1);
					bootbox.dialog({
						message: "El proveedor ha sido creado",
						title: "Atención",
						buttons: {
							success: {
								label: "Ok!",
								className: "btn-success",
								callback: function() {
									
								}
							}
						}
					});
				
			});
		}else{
			$.smallBox({
			      title: "<h1>Atención</h1>",
			      content: "<h3>Por favor reviza que todos los datos estén correctos</h3>",
			      color: "#C46A69",
			      icon : "fa fa-warning fadeInLeft animated",
			      timeout: 4000
			    });
			}
}

</script>