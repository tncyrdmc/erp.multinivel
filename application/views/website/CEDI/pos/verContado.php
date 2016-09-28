<p align="center" class="text-info">
	<strong>Total Cobrar</strong>
</p>
<pre style="font-size: 30px">$ 545453</pre>
<p align="center" class="text-info">
	<strong>Forma de Pago "Contado"</strong>
</p>
<div align="center">
	<form id="form1" name="contado" method="get"
		action="contado_credito.php">
		<label for="ccpago">Dinero Recibido</label> <input type="hidden"
			name="tpagar" id="tpagar" value="456465">
		<div class="input-prepend input-append">
			<span class="add-on">$</span> <input type="number" name="ccpago"
				id="ccpago" autocomplete="on" required /> <span class="add-on">.00</span>
		</div>
		<br> <input type="submit" class="btn btn-success" name="button"
			id="button" value="Cobrar Dinero Recibido" />
	</form>
</div>