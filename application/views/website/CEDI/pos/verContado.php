<p align="center" class="text-info">
	<strong>Total Cobrar</strong>
</p>
<pre class="text-center" style="font-size: 30px">$ <?=number_format($valor,2);?></pre>
<p align="center" class="text-info">
	<strong>Forma de Pago "Contado"</strong>
</p>
<div align="center">
	<form id="canjeo" class="smart-form" method="POST" role="form" action="POS/facturar">
		<section class="col-md-3"></section>
		<section class="col-md-6">
			<label>Cliente Registrado</label>
			<label class="select">
				<select id="user" required name="user">
					<option value="">Elije un Cliente</option>
	            <?foreach ($users as $key){?>
					<option value="<?=$key->id?>"><?=$key->nombre." ".$key->apellido?></option>
				<?}?>
				</select>
			</label>
		</section>
		<section class="col-md-12"></section>
		<section class="col-md-3"></section>
		<section class="col-md-6"><label for="ccpago">Dinero Recibido</label> 
			<input type="hidden" name="pago" id="pago" value="<?=$valor;?>">
			<div class="input-prepend input-append">
				<span class="add-on" style="height: 30px">$</span> 
				<input type="number" name="saldo" min="<?=$valor;?>"
					id="saldo" autocomplete="on" required /> 
				<span class="add-on" style="height: 30px">.00</span>
			</div>
		</section>				
		<br> 
		<?php if($valor>0){?>
		<input type="submit" class="btn btn-success" value="Cobrar Dinero Recibido" />
		<?php } ?>
	</form>
</div>

<script>
/*
$( "#canjeo" ).submit(function( event ) {
	event.preventDefault();
	enviar();
});		

function enviar(){

	$.ajax({
		type: "POST",
		url: "POS/canjear",
		data: $("#canjeo").serialize(),
	})
	.done(function( msg2 )
	{
		bootbox.dialog({
			message: "Se han Realizado la Venta # ".msg2,
			title: "Descuento al Producto",
			buttons: {
				success: {
					label: "Aceptar",
					className: "btn-success",
					callback: function() {
						FinalizarSpinner();
						location.href='POS/factura?id='.msg2;
					}
				}
			}
		})//fin done ajax
	});//Fin callback bootbox
	
	
}*/


</script>
