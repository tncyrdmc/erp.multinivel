<div id="spinner-div"></div>
<div style="background: rgb(255, 255, 255) none repeat scroll 0% 0%; margin-right: 0px; margin-left: 0px; padding-bottom: 3rem;" class="row">
	
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

		<form action="" onmouseenter="" method="POST" id="edit" role="form" class="smart-form">
			<legend>Modificar saldo del Afiliado</legend>

			<br><br>

			<div class="form-group">

				<div class="row">
							
									<!-- NEW WIDGET START -->
									<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

										<!-- Widget ID (each widget will need unique ID)-->
										<div class="jarviswidget jarviswidget-color-purity" id="wid-id-1" data-widget-editbutton="false" data-widget-colorbutton="true">
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
																							<!-- widget content -->
												
												<div class="widget-body">
													<div id="myTabContent1" class="tab-content padding-50">
													<h1 class="text-center"></h1>
													
													<div class="table-responsive">
													<table class="table">
													<thead>
														<tr>
															<th> <i class="fa fa-sitemap"></i> Red</th>
															<th> <i class="fa fa-money"></i> Comision</th>
														</tr>
													</thead>
													<tbody>
												<?php 
													$total = 0; 
													$i = 0;
													foreach ($ganancias as $gred){
														if($gred[0]->valor!=0){
														echo '<tr class="success" >
																<td colspan="2">'.$gred[0]->nombre.'</td>
															</tr>'; 

														echo '<tr class="success">
															<td>Comisiones Directas</td>
																<td>$ '.number_format($comisiones_directos[$i][0]->valor,2).'</td>
															</tr>'; 
														
														echo '<tr class="success">
															<td>Comisiones Indirectas</td>
																<td>$ '.number_format($gred[0]->valor - $comisiones_directos[$i][0]->valor,2).'</td>
															</tr>'; 

														if($gred[0]->valor){
														echo '<tr class="warning">
																<td>Total</td>
																<td>$ '.number_format($gred[0]->valor,2).'</td>
															</tr>';
														$total += $gred[0]->valor;
														}else {
															echo '<tr class="warning">
																<td> Total </td>
																<td>$ 0</td>
															</tr>';
														}
														$i++;
													}
													}

													?>  
													<tr class="success">
														<td><h4><b>TOTAL</b></h4></td>
														<td><h4><b>$ <?php echo number_format($total,2);?></b></h4></td>
													</tr>
													</tbody>
													</table>
														
													</div>

													
															<table id="dt_basic" class="table table-striped table-bordered table-hover">
																
																	<?php 
																	$retenciones_total=0;
																	foreach ($retenciones as $retencion) {?>
																	<tr class="danger">
																		<td><b>Retencion por <?php echo $retencion['descripcion']; ?></b></b></td>
																		<td></td>
																		<td>$ <?php 
																		$retenciones_total+=$retencion['valor'];
																		echo number_format($retencion['valor'],2); ?></td>
																	</tr>
																	<?php $total;
																	} ?>
																
																	<tr class="danger">
																		<td><b>Cobros Pendientes</b></td>
																		<td></td>
																		<td>$ <?php 
																		if($cobroPendientes==null)
																			echo "0";
																		else
																			echo number_format($cobroPendientes,2);
																		?></td> 
																	</tr>
																
																	<?php foreach ($cobro as $cobros){
																	?>
																	<tr class="danger">
																		<td><b>Cobros Pagos</b></td>
																		<td></td>
																		<td>$ 
																		<?php 
																		if($cobros->monto==null){
																		  echo '0';
																		  $cobro=0;
																		}
																		else {
																		  echo number_format($cobros->monto,2);
																		  $cobro=$cobros->monto;
																		}
																		?></td>
																	</tr>
																	<?php 
																	}?>
																	<tr class="info">
																		<td><h4><b>Saldo Neto</b></h4>
																		<td></td>
																		<td><h4><b>$ <?php echo number_format($total-($cobro+$retenciones_total+$cobroPendientes),2); ?></b></h4></td>
																	</tr>
																</table>
														
													</div>
												
												</div>
							

											<!-- end widget div -->
										</div>
										<!-- end widget -->
							
									</article>
								</div>
							</section>
						<!-- end widget grid -->

						</div>
					</div>
						
						
				
			</div>
									<button type="submit" class="btn btn-success pull-right btn-next"  disabled="disabled">Actualizar</button>
		</form>
		

</div>
</div>

<script src="/template/js/plugin/jquery-form/jquery-form.min.js"></script>
<script src="/template/js/validacion.js"></script>
<script src="/template/js/plugin/fuelux/wizard/wizard.min.js"></script>

<script type="text/javascript">

$( "#edit" ).submit(function( event ) {
	event.preventDefault();	
	enviar();
});

function enviar(){
	setiniciarSpinner();	
	$.ajax({
		type: "POST",
		url: "/bo/comercial/actualizar_afiliado",
		data: $('#edit').serialize()
	}).done(function( msg ) {				
		bootbox.dialog({
			message: msg,
			title: 'ATENCION',
			buttons: {
				success: {
					label: "Aceptar",
					className: "btn-success",
					callback: function() {
							location.href="/bo/comercial/red_tabla";
							FinalizarSpinner();
					}
				}
			}
		})
	});//fin Done ajax	
}

$(function()
{
	var a = new Date();
 	año = a.getFullYear()-19;
	$( "#datepicker" ).datepicker({
		changeMonth: true,
		numberOfMonths: 2,
		dateFormat:"yy-mm-dd",
		maxDate: año+"-12-31",
		changeYear: true
	});
});

/*function mensaje_notificacion(){
	bootbox.dialog({
		  message: "La modificación del afiliado ha sido exitosa.",
		  title: "Modificación del afiliado",
		  buttons: {
		    success: {
		      label: "Ok",
		      className: "hide",
		      callback: function() {
		    	  location.href="/bo/comercial/red_tabla?id_red";
		      }
		    }
		  }
		})
}*/

/*function use_username()
{
	$("#msg_usuario").remove();
	var username=$("#username").val();
	var id=$("#id").val();
	$.ajax({
		type: "POST",
		url: "/ov/perfil_red/use_username_modificar",
		data: {username: username,id: id},
	})
	.done(function( msg )
	{
		$("#msg_usuario").remove();
		$("#usuario").append("<p id='msg_usuario'>"+msg+"</msg>")
	});
	validate_user_data()
}
function use_mail()
{
	$("#msg_correo").remove();
	var mail=$("#mail").val();
	var id=$("#id").val();
	$.ajax({
		type: "POST",
		url: "/ov/perfil_red/use_mail_modificar",
		data: {mail: mail, id:id},
	})
	.done(function( msg )
	{
		$("#msg_correo").remove();
		$("#correo").append("<p id='msg_correo'>"+msg+"</msg>")
	});
	validate_user_data()
}

function confirm_pass()
{
	var password=$("#password").val();
	var confirm_password=$("#confirm_password").val();
	$.ajax({
		type: "POST",
		url: "/ov/perfil_red/confirm_password",
		data: {password: password,confirm_password: confirm_password},
	})
	.done(function( msg )
	{
		$("#msg_confirm_password").remove();
		$("#confirmar_password").append("<div id='msg_confirm_password'>"+msg+"</div>")
	});
	validate_user_data()
}

function validate_user_data()
{
	var id=$("#id").val();
	var nombre=$("#nombre").val();
	var mail=$("#mail").val();
	var username=$("#username").val();

	var password=$("#password").val();
	var confirm_password=$("#confirm_password").val();

	$("#validate_user_data").remove();

	$.ajax({
		type: "POST",
		url: "/ov/perfil_red/validate_user_data2",
		data: {id: id,nombre: nombre,mail: mail,username: username,password: password,confirm_password: confirm_password},
	})
	.done(function( msg )
	{
		$("#validate_user_data").remove();
		$("#edit").append("<div id='validate_user_data'>"+msg+"</div>")
	});
}*/

</script>
<!-- 
select U.id, UP.nombre, UP.apellido, U.username, U.email, CS.descripcion as sexo,
CEC.descripcion as estado_civil, CTU.descripcion as tipo_usuario, CE.descripcion as estudio,
CO.descripcion as ocupacion, CTD.descripcion as tiempo_dedicado, CEA.descripcion

from users U, user_profiles UP, cat_sexo CS, cat_edo_civil CEC, cat_tipo_usuario CTU,
cat_estudios CE, cat_ocupacion CO, cat_tiempo_dedicado CTD, cat_estatus_afiliado CEA
 
where UP.id_sexo = CS.id_sexo and UP.id_edo_civil = CEC.id_edo_civil and UP.id_tipo_usuario = CTU.id_tipo_usuario
and UP.id_estudio = CE.id_estudio and UP.id_ocupacion = CO.id_ocupacion and U.id = UP.user_id 
and UP.id_tiempo_dedicado = CTD.id_tiempo_dedicado and UP.id_estatus = CEA.id_estatus

 group by (U.id);
 -->
