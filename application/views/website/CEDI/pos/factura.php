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

										<div class="col-sm-11 link" style="padding-left: 2em">
											
											<section class="col-md-10 text-center" style="padding-top: 2em">
												<a onclick="location.href='/CEDI/POS'" class="btn"><i
													class="fa fa-backward"></i> Regresar a Ventas</a> <a
													onclick="imprimir()" class="btn"><i
													class="fa fa-print"></i> Imprimir Factura</a> <br>
												</section> 
												
												<section class="col-md-5">
												<div class="text-center">
													<h5>Total a Pagar</h5><h3>$ <?=number_format($pago,2)?></h3>
													<br/><br/><h5 >Dinero Recibido</h5><h3>$ <?=number_format($saldo,2)?></h3>
													<br/><br/><h5 >Cambio</h5><h3>$ <?=number_format(($saldo-$pago),2)?></h3>
												</div>
												
												
												<br/>
												<div class="alert alert-success text-center">
													<strong>Pago realizado con exito</strong><br>
													<a href="caja.php?ddes=0">Regresar a la caja</a>
												</div>
														
											</section>
														
														
											<section class="col-md-1"></section>
														
														
											<section class="col-md-5">
											
											<div id="Imprime" style="font-size: 12px">
															<br />
															<!-- <iframe frameborder="0" height="100" width="300" src="></iframe> -->
															<table width="310px" border="0" >
																<tr>
																	<td>
																		<strong>empresa</strong>
																		<br /> direccion
																		<br />telefono
																		<br /> nit
																		<br />
																	</td>
																</tr>
																<tr>
																	<td colspan="2"></td>
																	<td>fecha</td>
																</tr>
																<tr>
																	<td>CAJERO: cajera</td>
																</tr>
																<tr>
																	<td colspan="3">&nbsp;</td>
																</tr>
																
																
																<tr>
																	<td width="45">CANT</td>
																	<td width="158">DESCRIPCION</td>
																	<td width="93"><div align="right">IMPORTE</div></td>
																</tr>
																
																<tr>
																	<td colspan="3">=====================================</td>
																</tr>
																<?php foreach (items as $item){?>
																<tr>
																	<td>2</td>
																	<td>nombre 56464564</td>
																	<td><div align="right">$ 5476474</div></td>
																</tr>
																<?php }?>
																<tr>
																	<td colspan="3">&nbsp;</td>
																</tr>
																<tr >
																	<td colspan="3" class="text-center">NO. DE ARTICULOS: 2</td>
																</tr>
																<tr>
																	<td colspan="3" class="text-center"><strong>TOTAL: $ 534756456</strong></td>
																</tr>
																<tr>
																	<td colspan="3" class="text-center"><strong>* VENTA A MAYOR/DETAL *</strong></td>
																</tr>
																<tr>
																	<td colspan="3" class="text-center">FIRMA DEL CLIENTE</td>
																</tr>
																<tr>
																	<td colspan="3" class="text-center">__________________________</td>
																</tr>
																<tr>
																	<td colspan="3">&nbsp;</td>
																</tr>
																<tr>
																	<td colspan="3" class="text-center">GRACIAS POR SU COMPRA</td>
																</tr>
																<tr>
																	<td colspan="3" class="text-center">No</td>
																</tr>
																<tr>
																	<td colspan="3">&nbsp;</td>
																</tr>
																<tr>
																	<td colspan="3" class="text-center">
																		<a onclick="imprimir()" class="btn">
																		<i class="fa fa-print"></i> Imprimir Factura</a>
																	</td>
																</tr>
															</table>
															<br>
															<p>
															
															</p> <!-- fin del codigo factura -->
															
														</div>
											
											</section>
												
											<table width="100%" border="0">
												<tr>
													<td width="50%"><pre style="font-size: 24px">
															</td>
													<td width="50%" rowspan="3">
														<!-- codigo imprimir -->

														
														
													</td>
												</tr>
												<tr>
													<td>
														



													</td>
												</tr>
												<tr>
													<td>&nbsp;</td>
												</tr>
											</table>

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
<script src="/template/js/plugin/dropzone/dropzone.min.js"></script>
<script src="/template/js/plugin/markdown/markdown.min.js"></script>
<script src="/template/js/plugin/markdown/to-markdown.min.js"></script>
<script src="/template/js/plugin/markdown/bootstrap-markdown.min.js"></script>
<script src="/template/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="/template/js/plugin/datatables/dataTables.colVis.min.js"></script>
<script
	src="/template/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="/template/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script
	src="/template/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
<script src="/template/js/validacion.js"></script>
<script>


function imprSelec(nombre) {
	
	  var ficha = document.getElementById(nombre);
	  var ventimp = window.open(' ', 'popimpr');
	  ventimp.document.write( ficha.innerHTML );
	  ventimp.document.close();
	  ventimp.print( );
	  ventimp.close();
} 
</script>
