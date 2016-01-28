<form id="nueva" class="smart-form"  novalidate="novalidate" >
	<div class="row col-xs-8 col-sm-6 col-md-4 col-lg-12" style="margin: 4rem;">
		<?php foreach ($productos as $detalle) {?>
			<label> <b>Producto: </b><?= $detalle->producto;?> </label> <label> <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cantidad: </b><?= $detalle->cantidad;?> </label>
			<label> <b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Red:</b> <?= $detalle->red;?> </label> <br><label> <b>Proveedor de mensajeria:</b> <?= $detalle->nombre_empresa;?> </label>
			<br><label> <b>Ciudad:</b> <?= $detalle->ciudad;?> </label> <br><label> <b>Tarifa: </b> $<?= $detalle->tarifa;?> </label>
			<br><br>
		<?php } ?>
		<?php foreach ($servicios as $detalle) {?>
			<label> <b>Servicio: </b><?= $detalle->servicio;?> </label> <label> <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cantidad: </b><?= $detalle->cantidad;?> </label>
			<label> <b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Red:</b> <?= $detalle->red;?> </label> 
			<br><br>
		<?php } ?>
		<?php foreach ($combinados as $detalle) {?>
			<label> <b>Combinado: </b><?= $detalle->combinado;?> </label> <label> <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cantidad: </b><?= $detalle->cantidad;?> </label>
			<label> <b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Red:</b> <?= $detalle->red;?> </label> 
			<br><br>
		<?php } ?>
		<?php foreach ($paquetes as $detalle) {?>
			<label> <b>Paquete: </b><?= $detalle->paquete;?> </label> <label> <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cantidad: </b><?= $detalle->cantidad;?> </label>
			<label> <b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Red:</b> <?= $detalle->red;?> </label> 
			<br><br>
		<?php } ?>
	</div>
</form>