
{if $price_history['show'] == 1 or $price_history['show'] == 2}
	<div id="roxomnibus">
		{l s='Najniższa cena z 30 dni przed obniżką:' d='Shop.Theme.Global'}<span> {$price_history['price_wt']|string_format:"%.2f"}
			zł</span>
	</div>
	<!-- <div class="omnibusregularprice">
	Cena regularna: <b>{$price_history['old_price']} zł</b>
</div> -->
{/if}