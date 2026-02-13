
<div class="product-tabs-container-slider parents-product">
	<div class="container">
		<div class="tab_inner">
			<ul class="tabs_slider">
			{$count=0}
			{foreach from=$productTabslider item=productTab name=posTabProduct}
				<li class="{$productTab.id} {if $smarty.foreach.posTabProduct.first}first_item{elseif $smarty.foreach.posTabProduct.last}last_item{else}{/if} item {if $count==0} active {/if}" rel="tab_{$productTab.id}"  >
					<span>{$productTab.name}</span>

				</li>
				{$count= $count+1}
			{/foreach}	
			</ul>
		</div>
		{$rows= $config['POS_HOME_PRODUCTTAB_ROWS']}
		<div class="row pos_content"> 
		{$countss=0}
		{foreach from=$productTabslider item=productTab name=posTabProduct}
				<div id="tab_{$productTab.id}" class="tab_content">
					<div class="productTabContent{$countss} productTab-item owl-carousel shop-products">
					{foreach from=$productTab.productInfo item=product name=myLoop}
					{if $smarty.foreach.myLoop.index % $rows == 0 || $smarty.foreach.myLoop.first }
						<div class="item-product">
					{/if}
					
					{include file="catalog/_partials/miniatures/product.tpl" product=$product}
					{if $smarty.foreach.myLoop.iteration % $rows == 0 || $smarty.foreach.myLoop.last  }
						</div>
					{/if}	
					{/foreach}
					</div>
				</div>
				{$countss= $countss+1}
		{/foreach}	
		</div>
	</div>
</div>
