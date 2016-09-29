
<!-- MAIN CONTENT -->
<div id="content">

	<section id="widget-grid">
		<!-- START ROW -->
		<div class="row">
			<!-- NEW COL START -->
			<article class="col-sm-12 col-md-12 col-lg-12">
				<!-- Widget ID (each widget will need unique ID)-->
				<div class="jarviswidget" id="wid-id-1"
					data-widget-colorbutton="false" data-widget-editbutton="false"
					data-widget-togglebutton="false" data-widget-deletebutton="false"
					data-widget-sortable="false" data-widget-fullscreenbutton="false"
					data-widget-custombutton="false" data-widget-collapsed="false">
					<div>

						<!-- widget edit box -->
						<div class="jarviswidget-editbox">
							<!-- This area used as dropdown edit box -->

						</div>
						<!-- end widget edit box -->
						<!-- widget content -->
						<div class="widget-body no-padding smart-form">
							<fieldset>
								<div class="contenidoBotones">
									<div class="row">

										<div class="col-sm-11 link" style="padding-left: 4em">
										
										<section class="col-md-3" style="padding-left: 2em">
											<div class="control-group info">
															<form name="form1" method="post" action="">
																<label> <input type="text" autofocus
																	class="input-xlarge" id="codigo" name="codigo"
																	list="characters"
																	placeholder="Codigo de barra o Nombre del producto"
																	autocomplete="off"> <datalist id="characters">
																		<option value="item 1">
																	
																	</datalist>
																</label>
															</form>
											</div>
											
											
										</section>
										<section class="col-md-3" style="padding-left: 2em">
											<a href="#" class="btn" onclick="crear_item(0)"> 
												<i class="fa fa-tag"></i>
												Agregar Producto
											</a>
										</section>										
										<section class="col-md-5" style="padding-left: 2em">
										<pre style="padding: 2em" class="pull-right">Nombre del Cajero/a : caja 1</pre>
										</section>
										<section class="col-md-12" style="padding-left: 2em"></section>
										<section class="col-md-3" style="padding-left: 2em">
											<div class="alert alert-error" align="center">
												<button type="button" class="close" data-dismiss="alert">×</button>
												<strong>Producto no Registrado<br>
												<a href="#" class="btn btn-success"	onclick="crear_item($('#codigo').val())">Crear Este Producto </a></strong>
											</div>
										</section>
										<section class="col-md-8" style="padding-left: 2em">
											<div class="pull-right">
															<h5>Tipo de Compra:</h5>
															<br/>
																<button type="button" class="btn btn-primary"
																	onClick="window.location='php_caja.php?tventa=venta'">P.
																	Publico</button>
																<button type="button" class="btn btn-primary"
																	onClick="window.location='php_caja.php?tventa=mayoreo'">P.
																	Mayoreo</button>
															
														</div>
										</section>
										
										<hr class="col-md-12" />

											<div
												style="OVERFLOW: auto; WIDTH: 100%; TOP: 48px; HEIGHT: 150px">
												<table style='width: 98%' class="table table-hover">
													<tr class="info">
														<td width="13%"><strong>Codigo</strong></td>
														<td width="27%"><strong>Descripcion del Producto</strong></td>
														<td width="15%"><strong>Valor Unitario</strong></td>
														<td width="13%"><strong>Cant.</strong></td>
														<td width="12%"><strong>Importe</strong></td>
														<td width="9%"><strong>Existencia</strong></td>
														<td width="11%">&nbsp;</td>
													</tr>
													<tr>
														<td>68463</td>
														<td>celular</td>
														<td><div align="right">
																<a
																	href="caja.php?id=4645435'&ddes='.$_SESSION['ddes']; ?>">co395749</a>
															</div></td>
														<td><a href="caja.php?idd=5647654">3</a></td>
														<td bgcolor="#D9EDF7"><div align="right">$ 357645</div></td>
														<td>23</td>
														<td>
															<button type="button" class="btn btn-danger"
																onClick="window.location='php_eliminar_caja.php?id=5645'">
																<i class="fa fa-minus"></i> Remover
															</button>
														</td>
												
												</table>

											</div>

											<hr class="col-md-12" />
											
											<section class="col-md-2 text-center" style=""></section>

											<section class="col-md-4 text-center" style="padding: 2em">
											<form name="form2" method="get" action="php_caja_act.php">
												<input type="hidden" name="xcodigo" id="xcodigo" value="46">
												<div class="padding-10">
												<h4>Nuevo Precio o % Descuento: </h4>
												</div>
												<div class="padding-10">
												<div class="col-md-3 "></div>
												<label class="col-md-6 input">
													<input type="number" name="xdes" id="xdes" value="0" autocomplete="off">
												</label>												
												</div>
												<div class="" style="padding-bottom: 5em">
													<div class="col-md-6">
													[ <input type="radio" name="tipo" id="optionsRadios1" value="p"	checked>
													Descuento % ] 
													</div>
													<div class="col-md-6">
													[ <input type="radio" name="tipo" id="optionsRadios1" value="d" checked>
													Nuevo Precio $ ]
													</div>												
												</div>
												<div class="padding-10" >
													<button type="submit" class="btn btn-success">Procesar</button>
												</div>
												</form>
											</section>

											<section class="col-md-4 text-center" style="padding: 2em">
												<form name="form2" method="get" action="php_caja.php">
													<input type="hidden" name="xcodigo" id="xcodigo" value="34">
													<div class="" style="padding-bottom: 2.5em">
														<h4>Cantidad: </h4>
													</div>
													<div class="" style="padding-bottom: 4em">
														<div class="col-md-3 "></div>
														<label class="col-md-6 input">
															<input type="text" name="cantidad" id="cantidad" value="0" autocomplete="off">													
														</label>
													</div>
													<div class="padding-10" >
														<button type="submit" class="btn btn-success">Procesar</button>
													</div>													
												</form>
											</section>

											<hr class="col-md-12" />

											
												
												<section class="col-md-4" >
													<pre class="pull-left" style="padding: 1em;font-size: 24px">33 Articulos en venta</pre>
												</section>
												<section class="col-md-4 text-center" >
																<div style="padding: 0.5em;">
																
																<form name="form3" method="get" action="caja.php">
																
																	<div class="padding-10">
																		<h4>Descuento al Neto: </h4>
																	</div>
																	<div class="padding-10">
																	<div class="col-md-2 "></div>
																		<label class="input-prepend input-append col-md-8 input">																		
																			<input type="number" class="span1" min="0" max="99"
																			name="ddes" id="ddes" value="54535"> 
																			<span class="add-on">%</span>
																		</label>
																	</div>
																	<div class="padding-10" >
																		<button type="submit" class="btn btn-mini">Aplicar
																			Descuento
																		</button>
																	</div>
																</form>
																
																</div>							
																</section>
																<section class="col-md-4" >
																	<pre class="pull-right" style="padding: 1em;font-size: 24px">Neto: $ 4364366</pre>
																</section>
												
											
											<hr class="col-md-12" />
											

											<div class="well col-md-12" >
																<section class="col-md-4" ></section>
																<section class="col-md-4" >															
																
																	<div class="text-center" style="padding: 1em;">
																		<a href="#" class="btn btn-success" onclick="ver_compra(0)"><i
																			class="fa fa-shopping-cart"></i> V. Contado</a>
																	</div>																
																
																</section>
											</div>

											

											
										</div>
									</div>
								</div>
							</fieldset>
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
			<br /> <br />
		</div>
	</div>
</div>
<!-- END MAIN CONTENT -->
<style>
.link {
	margin: 0.5rem;
}

.minh {
	padding: 50px;
}

.link a:hover {
	text-decoration: none !important;
}
</style>
<script>

function crear_item(code)
{
	$.ajax({
		type: "POST",
		url: "POS/new_item",
		data: {code : code},
	})
	.done(function( msg )
	{
		bootbox.dialog({
		message: msg,
		title: 'Crear Producto',
		buttons: {
			success: {
			label: "Aceptar",
			className: "btn-success",
			callback: function() {
					/*
					$.ajax({
						type: "POST",
						url: "",
						data: $("#"+codigo).serialize(),
					})
					.done(function( msg )
					{
						bootbox.dialog({
						message: "Se han actualizado los cambios",
						title: nombre,
						buttons: {
							success: {
							label: "Aceptar",
							className: "btn-success",
							callback: function() {
								}
							}
						}
					})//fin done ajax
					});//Fin callback bootbox
						*/
				}
			},
				danger: {
				label: "Cancelar!",
				className: "btn-danger",
				callback: function() {

					}
			}
		}
	})
	});
}

function ver_compra(code)
{
	$.ajax({
		type: "POST",
		url: "POS/ver_cobro",
		data: {code : code},
	})
	.done(function( msg )
	{
		bootbox.dialog({
		message: msg,
		title: 'Cobrar al Contado',
		buttons: {
			success: {
			label: "Aceptar",
			className: "btn-success",
			callback: function() {
					/*
					$.ajax({
						type: "POST",
						url: "",
						data: $("#"+codigo).serialize(),
					})
					.done(function( msg )
					{
						bootbox.dialog({
						message: "Se han actualizado los cambios",
						title: nombre,
						buttons: {
							success: {
							label: "Aceptar",
							className: "btn-success",
							callback: function() {
								}
							}
						}
					})//fin done ajax
					});//Fin callback bootbox
						*/
				}
			},
				danger: {
				label: "Cancelar!",
				className: "btn-danger",
				callback: function() {

					}
			}
		}
	})
	});
}

</script>
