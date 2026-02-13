<div class="container">
	<div class="pos-special-products" 
		data-items="{$slider_options.number_item}" 
		data-speed="{$slider_options.speed_slide}"
		data-autoplay="{$slider_options.auto_play}"
		data-time="{$slider_options.auto_time}"
		data-arrow="{$slider_options.show_arrow}"
		data-pagination="{$slider_options.show_pagination}"
		data-move="{$slider_options.move}"
		data-pausehover="{$slider_options.pausehover}"
		data-md="{$slider_options.items_md}"
		data-sm="{$slider_options.items_sm}"
		data-xs="{$slider_options.items_xs}"
		data-xxs="{$slider_options.items_xxs}">
		{if $title}
		<div class="pos_title">
			 <h2>
				{$title}
			</h2>	
			<p class="des-title">{l s='greenfarm deal of the day' mod='posspecialproducts'}</p>
		</div>
		{/if}
		{$rows= $slider_options.rows}
		<div class="row pos_content">
			<div class="special-item owl-carousel">
			{foreach from=$products item=product name=myLoop}
				{if $smarty.foreach.myLoop.index % $rows == 0 || $smarty.foreach.myLoop.first }
				<div class="item-product">
				{/if}
					<article class="js-product-miniature item_in" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
						<div class="img_block thumbnail-container">
							{block name='product_thumbnail'}
							  <a href="{$product.url}" class="thumbnail product-thumbnail">
								<img
								  src = "{$product.cover.bySize.home_default.url}"
								  alt = "{$product.cover.legend}"
								  data-full-size-image-url = "{$product.cover.large.url}"
								>
								   {hook h="rotatorImg" product=$product}
							  </a>
							{/block}
							{block name='product_flags'}
							  <ul class="product-flag">
								{foreach from=$product.flags item=flag}
									{if $flag.type == "discount"}
										{continue}
									{/if}
									<li class="{$flag.type}"><span>{$flag.label}</span></li>
								{/foreach}
							  </ul>
							{/block}
						</div>
						<div class="product_desc">
						  {block name='product_name'}
						   <h4><a href="{$product.url}" title="{$product.name}" itemprop="name" class="product_name">{$product.name}</a></h4>
						  {/block}
						  {block name='product_description_short'}
								<div class="product-desc" itemprop="description">{$product.description_short|truncate:250:' ...'|escape:'html':'UTF-8' nofilter}</div>
							{/block}
						  {block name='product_price_and_shipping'}
							{if $product.show_price}
							  <div class="product-price-and-shipping">
								{if $product.has_discount}
								  {hook h='displayProductPriceBlock' product=$product type="old_price"}

								  <span class="regular-price">{$product.regular_price}</span>
								{/if}

								{hook h='displayProductPriceBlock' product=$product type="before_price"}

								<span itemprop="price" class="price {if $product.has_discount} price_sale{/if}">{$product.price}</span>

								{hook h='displayProductPriceBlock' product=$product type='unit_price'}

								{hook h='displayProductPriceBlock' product=$product type='weight'}
							  </div>
							{/if}
						  {/block}
						  {block name='product_reviews'}
							<div class="hook-reviews">
							{hook h='displayProductListReviews' product=$product}
							</div>
						  {/block}
							{block name='product_variants'}
								{if $product.main_variants}
								  {include file='catalog/_partials/variant-links.tpl' variants=$product.main_variants}
								{/if}
							 {/block}
							 <div class="cart">
									{include file='catalog/_partials/customize/button-cart.tpl' product=$product}
								</div>
						</div>
						<div class="countdown" >
								{hook h='timecountdown' product=$product }
								<span 	id="future_date_{$product.id_category_default}_{$product.id_product}"
								class="id_countdown"></span>
								<div class="clearfix"></div>
							</div>
					</article>
				{if $smarty.foreach.myLoop.iteration % $rows == 0 || $smarty.foreach.myLoop.last  }
				</div>
				{/if}
			{/foreach}
			</div>
		</div>	
	</div>
</div>
