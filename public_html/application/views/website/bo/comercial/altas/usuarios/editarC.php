
				<form id="nueva" class="smart-form"  novalidate="novalidate" >
	                <fieldset>
		                <div class="contenidoBotones">
							<div class="row col-xs-8 col-sm-6 col-md-4 col-lg-4" style="margin: 4rem;">
								<div class="">
										<section>
											<div>
											<label class="select">
												<label class="label">Seleccione el CEDI al que pertenecerá</label>
												<select name="id_cedi" id="id_cedi" required="">
													<?foreach ($cedis as $cedi) {
														if ($cedi->id_cedi==$user[0]->cedi){?>
														<option selected value="<?php echo $cedi->id_cedi; ?>">
															<?php echo $cedi->nombre; ?>
														</option>
													<?}else {?>	
														<option value="<?php echo $cedi->id_cedi; ?>">
															<?php echo $cedi->nombre; ?>
														</option>
													<?}
													}?>
												</select>
											</label>
												<br>
												
												<table>
													<input type="text" class="hide" value="<?php echo $user[0]->id; ?>" name="id">
													<tr>
														<td>DNI</td>
														<td><input name="dni" value="<?php echo $user[0]->dni?>" id="dni" maxlength="60" size="30" type="text" required></td>
														<td style="color: red;"></td>
													</tr>
													<tr>
														<td>Nombres</td>
														<td><input name="nombre" value="<?php echo $user[0]->nombre?>" id="username" maxlength="60" size="30" type="text" required></td>
														<td style="color: red;"></td>
													</tr>
													<tr>
														<td>Apellidos</td>
														<td><input name="apellido" value="<?php echo $user[0]->apellido?>" id="username" maxlength="60" size="30" type="text" required></td>
														<td style="color: red;"></td>
													</tr>
													<tr>
														<td>Telefono</td>
														<td><input name="telefono" value="<?php echo $user[0]->telefono_fijo?>" id="telefono" maxlength="60" size="30" type="text" required></td>
														<td style="color: red;"></td>
													</tr>
													<tr>
														<td>Email</td>
														<td><input name="email" value="<?php echo $user[0]->email?>" id="email" maxlength="60" size="30" required="" type="text"></td>
														<td style="color: red;"></td>
													</tr>
														<label class="select">
													<label class="label">País</label>
													<select name="id_pais" id="id_pais" required="">
														<?foreach ($paises as $pais) {
															if ($pais->Code == $user[0]->id_pais){?>
															<option selected value="<?php echo $pais->Code; ?>">
																<?php echo $pais->Name; ?>
															</option>
														<?}else {?>
															<option value="<?php echo $pais->Code; ?>">
																<?php echo $pais->Name; ?>
															</option>
														<?}
														}?>
													</select>
												</label>
												
												<br>
												
												</table>
												<br>
											</div>
													</section>
											</div>
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
							url: "/bo/usuarios/actualizar_users_cedi",
							data: $('#nueva').serialize()
						})
						.done(function( msg ) {
							
									bootbox.dialog({
										//location.href="/bo/usuarios/listarCedi";
										message: msg,
										title: "Atención",
										buttons: {
											success: {
											label: "Ok!",
											className: "btn-success",
											callback: function() {
												location.href="/bo/usuarios/listarCedi";
												}
											}
										}
									});
						});//fin Done ajax
		
}
</script>