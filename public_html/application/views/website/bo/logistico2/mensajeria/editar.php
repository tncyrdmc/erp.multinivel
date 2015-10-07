<form class="smart-form" method="POST" action="/bo/proveedor_mensajeria/crear_proveedor">
							<fieldset>
								<div class="row">
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										<label for="" class="input">Numero de empresa
											<input type="text" class="form-control" name="numero" placeholder="Numero de empresa"class="form-control" value="<?php echo $proveedor[0]->numero_proveedor; ?>" required />
										</label>
									</div>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										<label for="" class="input">Nombre de empresa
											<input type="text" class="form-control" name="nombre" placeholder="Nombre de empresa"class="form-control" required />
										</label>
									</div>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										<label for="" class="input">Razon Social
											<input type="text" class="form-control" name="razon_social" placeholder="Razon social"class="form-control" required />
										</label>
									</div>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										<label class="select">Pais
											<select id="pais" required name="pais">
												<option value="-" selected>-- Seleciona un pais --</option>
												<?foreach ($paises as $key){?>
													<option value="<?=$key->Code?>"><?=$key->Name?></option>
												<?}?>
											</select>
										</label>
									</div>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										<label for="" class="input">Idioma
											<input type="text" class="form-control" name="idioma" placeholder="Idioma"class="form-control" required />
										</label>
									</div>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										<label for="" class="input">Dirección
											<input type="text" class="form-control" name="direccion" placeholder="Direccion de empresa"class="form-control" required />
										</label>
									</div>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										<label for="" class="input">Colonia
											<input type="text" class="form-control" name="colonia" placeholder="Colonia"class="form-control" required />
										</label>
									</div>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										<label for="" class="input">Municipio
											<input type="text" class="form-control" name="municipio" placeholder="Municipio"class="form-control" required />
										</label>
									</div>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										<label for="" class="input">Codigo Postal
											<input type="text" class="form-control" name="codigo_postal" placeholder="Codigo Postal" class="form-control" required />
										</label>
									</div>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										<label for="" class="input">Estado
											<input type="text" class="form-control" name="estado" placeholder="Estado"class="form-control" required />
										</label>
									</div>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										<label for="" class="input">Direccion Web
											<input type="text" class="form-control" name="web" placeholder="URL del sitio web" class="form-control" required />
										</label>
									</div>
								</div>
								
							
								<div class="row">
									<header>Contacto N° 1</header>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										<label for="" class="input">Nombre
											<input type="text" class="form-control" name="nommbre_contacto1" placeholder="Nombre de persona de contacto"class="form-control" required />
										</label>
									</div>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										<label for="" class="input">Apellido
											<input type="text" class="form-control" name="apellido_contacto1" placeholder="Apellido de persona de contacto" class="form-control" required />
										</label>
									</div>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										Telefono Movil<label for="" class="input">
											<i class="icon-prepend fa fa-phone"></i>
											<input name="telefonomovil1[]" placeholder="Telefono Movil 1" data-mask="999 999-9999" type="tel" required>
										</label>
									</div>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										Telefono Movil<label for="" class="input">
											<i class="icon-prepend fa fa-phone"></i>
											<input name="telefonomovil1[]" placeholder="Telefono movil 2" data-mask="999 999-9999" type="tel">
										</label>
									</div>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										Telefono Movil<label for="" class="input">
											<i class="icon-prepend fa fa-phone"></i>
											<input name="telefonomovil1[]" placeholder="Telefono movil 3" data-mask="999 999-9999" type="tel">
										</label>
									</div>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										Telefono Fijo<label for="" class="input">
											<i class="icon-prepend fa fa-phone"></i>
											<input name="telefonofijo1[]" placeholder="Telefono Fijo 1" data-mask=" (999) 999-9999" type="tel" required>
										</label>
									</div>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										Telefono Fijo<label for="" class="input">
											<i class="icon-prepend fa fa-phone"></i>
											<input name="telefonofijo1[]" placeholder="Telefono fijo 2" data-mask="(999) 999-9999" type="tel">
										</label>
									</div>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										Telefono Fijo<label for="" class="input">
											<i class="icon-prepend fa fa-phone"></i>
											<input name="telefonofijo1[]" placeholder="Telefono Fijo 3" data-mask="999 999-9999" type="tel">
										</label>
									</div>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										Email
										<label for="" class="input">
											<i class="icon-prepend fa fa-envelope-o"></i>
											<input type="email" class="form-control" name="email_contacto1" placeholder="Email de la persona de contacto"class="form-control" required />
										</label>
									</div>
									<div class="col col-xs-12 col-sm-6 col-lg-6">
											<label for="" class="input">Puesto
											<input type="text" class="form-control" name="puesto_contacto1" placeholder="Puesto de la persona de contacto"class="form-control" />
										</label>
									</div>
								</div>
								
								<div class="row">
									<header>Contacto N° 2</header>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										<label for="" class="input">Nombre
											<input type="text" class="form-control" name="nommbre_contacto2" placeholder="Nombre de persona de contacto"class="form-control" />
										</label>
									</div>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										<label for="" class="input">Apellido
											<input type="text" class="form-control" name="apellido_contacto2" placeholder="Apellido de persona de contacto"class="form-control" />
										</label>
									</div>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										Telefono Movil<label for="" class="input">
											<i class="icon-prepend fa fa-phone"></i>
											<input name="telefonomovil2[]" placeholder="Telefono Movil 1" data-mask="999 999-9999" type="tel">
										</label>
									</div>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										Telefono Movil<label for="" class="input">
											<i class="icon-prepend fa fa-phone"></i>
											<input name="telefonomovil2[]" placeholder="Telefono movil 2" data-mask="999 999-9999" type="tel">
										</label>
									</div>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										Telefono Movil<label for="" class="input">
											<i class="icon-prepend fa fa-phone"></i>
											<input name="telefonomovil2[]" placeholder="Telefono movil 3" data-mask="999 999-9999" type="tel">
										</label>
									</div>
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										Telefono Fijo<label for="" class="input">
											<i class="icon-prepend fa fa-phone"></i>
											<input name="telefonofijo2[]" placeholder="Telefono Fijo 1" data-mask=" (999) 999-9999" type="tel">
										</label>
									</div>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										Telefono Fijo<label for="" class="input">
											<i class="icon-prepend fa fa-phone"></i>
											<input name="telefonofijo2[]" placeholder="Telefono fijo 2" data-mask="(999) 999-9999" type="tel">
										</label>
									</div>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										Telefono Fijo<label for="" class="input">
											<i class="icon-prepend fa fa-phone"></i>
											<input name="telefonofijo2[]" placeholder="Telefono Fijo 3" data-mask="999 999-9999" type="tel">
										</label>
									</div>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										Email<label for="" class="input">
											<i class="icon-prepend fa fa-envelope-o"></i>
											<input type="email" class="form-control" name="email_contacto2" placeholder="Email de la persona de contacto"class="form-control" />
										</label>
									</div>
									
									<div class="col col-xs-12 col-sm-6 col-lg-6">
										Puesto<label for="" class="input">
											<i class="icon-prepend fa fa-envelope-o"></i>
											<input type="text" class="form-control" name="puesto_contacto2" placeholder="Puesto de la persona de contacto"class="form-control" />
										</label>
									</div>
								</div>
								
								<div class="row" id="tarifa">
									<header>Tarifas</header>
									<div class="col col-lg-3 col-xs-3">
									</div>
									<div class="row">
										<div class="col col-lg-6 col-xs-6">
											<a style="cursor: pointer;" onclick="add_tarifa()">Agregar Tarifa <i class="fa fa-plus"></i></a>
										</div>
										
									</div>
									<div class="row">
										<div class="col col-xs-12 col-sm-6 col-lg-6">
											Ciudad<label for="" class="input">
												<i class="icon-prepend fa fa-bank"></i>
												<input type="text" class="form-control" name="ciudad_tarifa[]" placeholder=""class="form-control" required />
											</label>
										</div>
										
										<div class="col col-xs-12 col-sm-6 col-lg-6">
											Tarifa<label for="" class="input">
												<i class="icon-prepend fa fa-dollar"></i>
												<input type="number" class="form-control" name="valor_tarifa[]" placeholder=""class="form-control" required />
											</label>		
										</div>
									</div>
									
								</div>
								
								<div id="tarifas">
								
								</div>
								
							</filedset>
							
							<div class="row">
								<section  id="div_subir" style="width: 25rem;">
									<div style="width: 25rem;">
										<input type="submit" class="btn btn-success" style="margin-left: 66% ! important; width: 40%;" id="boton_subir" value="Agregar">
									</div>
								</section>
							</div>
						</form>
<script type="text/javascript">
var i=0;
function enviar() {
	
	 $.ajax({
							type: "POST",
							url: "/bo/proveedor_mensajeria/crear_proveedor",
							data: $('#nueva').serialize()
						})
						.done(function( msg ) {
							location.href="/bo/proveedor_mensajeria/listar";
						});//fin Done ajax
		
}

function add_tarifa()
{
	var code=	'<div id="'+i+'" class="row">'
	+'<div class="col col-xs-12 col-sm-6 col-lg-6">'
		+'Ciudad<label for="" class="input">'
			+'<i class="icon-prepend fa fa-bank"></i>'
			+'<input type="text" class="form-control" name="ciudad_tarifa[]" placeholder=""class="form-control" required />'
		+'</label>'
	+'</div>'
	+'<div class="col col-xs-12 col-sm-5 col-lg-6">'
		+'Tarifa<label for="" class="input">'
			+'<i class="icon-prepend fa fa-dollar"></i>'
			+'<input type="number" class="form-control" name="valor_tarifa[]" placeholder=""class="form-control" required />'
			+'<a style="cursor: pointer;" onclick="delete_tarifa('+i+')">Eliminar Tarifa <i class="fa fa-minus"></i></a>'
		+'</label>'
	+'</div>'
	+'</div>';
	$("#tarifa").append(code);
	i = i + 1
}

function delete_tarifa(id)
{	
	$("#"+id+"").remove();
	
}
</script>