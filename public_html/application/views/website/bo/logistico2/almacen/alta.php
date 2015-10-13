
<!-- MAIN CONTENT -->
<div id="content">
	<div class="row">
		
			
			
				<?php  if($type=='5'){?>
					<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
					<h1 class="page-title txt-color-blueDark">
					<a class="backHome" href="/bo"><i class="fa fa-home"></i> Menu</a>
				<span>
				> <a href="/bo/logistico2/alta"> Alta </a>
				> <a href="/bo/almacen/"> Almacen </a>
				>	Alta
				</span>
				</h1>
				</div>
				 <?php }else{?>
				 	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
					<h1 class="page-title txt-color-blueDark">
					<a class="backHome" href="/bo"><i class="fa fa-home"></i> Menu</a>
				<span>> <a href="/bol/dashboard/"> Logistico </a>
				> <a href="/bo/logistico2/alta"> Alta </a>
				> <a href="/bo/almacen/"> Almacen </a>
				>	Alta
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
					<h2>Nuevo Almacen</h2>				
					
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
						
						<form id="nueva" class="smart-form" method="POST" action="/bo/almacen/crear_almacen" enctype="multipart/form-data">
							<fieldset>
								<label class="input">Nombre
									<input style="width: 25rem;" type="text" name="nombre" placeholder="Nombre"class="form-control" required>
								</label>
								
								<div class="row" style="width: 28rem;">
									<section class="col col-lg-12 col-md-12 col-sm-12 col-xs-12" id="busquedatodos" >
										<label class="label">Descripcion</label>
										<label class="textarea">								
											<textarea required rows="3" class="custom-scroll" name="descripcion">
											</textarea>
										</label>
									</section>
								</div>
								
								<label class="input">Ciudad
									<input style="width: 25rem;" type="text" name="ciudad" placeholder="Ciudad" class="form-control" required>
								</label>
								
								<label class="input">Dirección
									<input style="width: 25rem;" type="text" name="direccion" placeholder="Direeccion" class="form-control" required>
								</label>
								
								<label class="input">Telefono
									<input style="width: 25rem;" type="tel" pattern="[0-9]{7,50}" title="Por favor digite un numero de telefono valido" name="telefono" placeholder="Telefono" class="form-control" required>
								</label>
								<div class="row">
									<section  id="div_subir" style="width: 25rem;">
										<div style="width: 25rem;">
											<input type="submit" class="btn btn-success" style="margin-left: 66% ! important; width: 40%;" id="boton_subir" value="Agregar">
										</div>
									</section>
								</div>	
									
							</fieldset>
							
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
	</section>
	<!-- end widget grid -->
</div>
<script src="/template/js/plugin/jquery-form/jquery-form.min.js"></script>
<script src="/template/js/validacion.js"></script>
<script src="/template/js/plugin/fuelux/wizard/wizard.min.js"></script>