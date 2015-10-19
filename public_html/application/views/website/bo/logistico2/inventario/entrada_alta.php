
<!-- MAIN CONTENT -->
<div id="content">
	<div class="row">
		
			
			
				<?php  if($type=='5'){?>
					<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
					<h1 class="page-title txt-color-blueDark">
					<a class="backHome" href="/bo"><i class="fa fa-home"></i> Menu</a>
				<span>
				> <a href="/bo/inventario/index"> Inventario </a>
				> Entrada</a>
			
				</span>
				</h1>
				</div>
				 <?php }else{?>
				 	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
					<h1 class="page-title txt-color-blueDark">
					<a class="backHome" href="/bo"><i class="fa fa-home"></i> Menu</a>
				<span>> <a href="/bol/dashboard/"> Logistico </a>
				> <a href="/bo/inventario/index"> Inventario </a>
				> Entrada
				</span>
				</h1>
				</div>
					<?php }?>
			
		
	</div>
	<?php if($this->session->flashdata('error')) {
		echo '<div class="alert alert-danger fade in">
								<button class="close" data-dismiss="alert">
									×
								</button>
								<i class="fa-fw fa fa-check"></i>
								<strong>Alerta </strong> '.$this->session->flashdata('error').'
			</div>'; 
	}
?>	
	
	<section id="widget-grid" class="">
		<!-- START ROW -->
		<div class="row">
			<!-- NEW COL START -->
			<article class="col-sm-12 col-md-12 col-lg-12">
				
			<div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false" data-widget-custombutton="false">
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
					<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
					<h2>Nueva Entrada</h2>				
					
				</header>

				<!-- widget div-->
				<div>
					
					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->
						
					</div>
					<!-- end widget edit box -->
					
					<!-- widget content -->
					<div class="widget-body no-padding">
						
					
						
							
							<form id="entradas" class="smart-form" method="post" action="new_entrada">
                              
                              <fieldset>
                                <legend>Datos de Entrada</legend>
                                <section  class="col col-3">
                                  <label class="select">Tipo de Entrada
                                    <select id="documento" required type="text" name="documento">
                                      <option >--------Escoja un tipo--------------</option>
                                                           <?foreach ($documento as $key){?>
													<option value="<?=$key->id_doc?>"><?=$key->nombre?></option>
												<?}?>
												
												    </select>
                                  </label>
                                </section>
                                <section class="col col-3">Numero
                                  <label class="input"> <i class="icon-prepend fa fa-barcode"></i>
                                    <input id="n_documento"  required type="text" name="n_documento" placeholder="Clave / Factura">
                                  </label>
                                </section>
                              </fieldset>
                              <fieldset>
                              
                                <legend>Almacen</legend>
                                <section  class="col col-3">
                                  <label class="select"> <strong>Origen</strong>
                                    <select id="tipo" required type="text" name="tipo" onChange="OrigenAlmacen()">
                                      <option value="">--------------Escoja un tipo-----------------</option>
                                         <option value="A">Almacen</option>
                                          <option value="C">Cedi</option>
                                                                                      
                                   </select>
                                  </label>
                                  <br>
                                  <label for="" class="select"> <select
						              id="origen" name="origen" >
								      </select>
								 </label>
								 
								 
                                  <br>
                                  Otro Origen?
                                   <label class="input"> <i class="icon-prepend fa fa-plane"></i>
                                    <input id="origen_in"   type="text" name="origen_in" placeholder="Origen">
                                  </label>
                                  
                                </section>
                               
                                 
                                <section  class="col col-3">
                                  <label class="select">Almacen/Cedi    <strong>Destino</strong>
                                    <select id="destino_in" required type="text" name="destino_in">
                                      <option >--------------Escoja un almacen-----------------</option>
                                                                               
                                                 <?foreach (	$almacenesCedi as $key){?>
													<option value="<?=$key->id_cedi?>"><?=$key->nombre?></option>
												<?}?>    </select>
                                  </label>
                                </section>
                              </fieldset>
                              <fieldset id="general_field_in">
                              
                              
                              
                                <legend>General</legend>
                                <section class="col col-3">
                                  <label class="select">Producto
                                    <select id="mercancia_in" required type="text" name="mercancia_in">
                                      <option >----------- Escoja una mercancia ----------</option>
                                                <?foreach ($productos as $key){?>
													<option value="<?=$key->id?>"><?=$key->nombre?></option>
												<?}?>
												
											 </select>
                                  </label>
                                </section>
                                <section class="col col-3">Cantidad
                                  <label class="input"> <i class="icon-prepend fa fa-unsorted  "></i>
                                    <input id="cantidad_in"  required type="number" min="1" name="cantidad_in" placeholder="Cantidad">
                                  </label>
                                </section>
                              
                              </fieldset>
                              <footer>
                                <button type="submit" class="btn btn-success">
                                  Guardar Entrada
                                </button>
                              </footer>
                           
							  
							  
							  
							  
				
									
									
									
						
							
							
							
						</form>

					</div>
					<!-- end widget content -->
					
				</div>
				<!-- end widget div -->
				
			</div>
			<!-- end widget -->	
		</div>
		
		<div class="row">         
	        <!-- a blank row to get started -->
	        <div class="col-sm-12">
	            <br />
	            <br />
	        </div>
	    
        </div>            
		<!-- END ROW -->
		    </article>
	</section>
	<!-- end widget grid -->
</div>
<script src="/template/js/plugin/jquery-form/jquery-form.min.js"></script>
<script src="/template/js/validacion.js"></script>
<script src="/template/js/plugin/fuelux/wizard/wizard.min.js"></script>
<<script type="text/javascript">
function OrigenAlmacen(){
	var tipo = $("#tipo").val();
	$.ajax({
		type: "POST",
		url: "/bo/inventario/tipoAlmacen",
		data: { tipo:tipo }
	})
	.done(function( msg )
	{
		$('#origen option').each(function() {   
		        $(this).remove();
		});
		datos=$.parseJSON(msg);
		$('#origen').append('<option value="">-- Seleccione--</option>');
	      for(var i in datos){
		      $('#origen').append('<option value="'+datos[i]['id_cedi']+'">'+datos[i]['nombre']+'</option>'); 		        
	      }
	});
}
</script>


