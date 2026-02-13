
<div class="tab-category-container-slider parents-product"  
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
	<div class="container">
		<div class="tab-category">				
			<div class="pos_tab">
				<div class="pos_title">
					 <h2>
						{$title}
					</h2>	
					<ul class="tab_cates"> 
						{$count=0}
						{foreach from=$productCates item=productCate name=postabcateslider}
								<li data-title="tabtitle_{$productCate.id}" rel="tab_{$productCate.id}" {if $count==0} class="active"  {/if} > 
								<span>{$productCate.name}</span>
								</li>
								{$count= $count+1}
						{/foreach}	
					</ul>	
				</div>			
							
			</div>
			<div class="row pos_content">	
				{$rows= $slider_options.rows}			
				<div class="tab1_container"> 
				{foreach from=$productCates item=productCate name=postabcateslider}				
					<div id="tab_{$productCate.id}" class="tab_category">
						<div class="productTabCategorySlider  owl-carousel">
						{foreach from=$productCate.product item=product name=myLoop}
							{if $smarty.foreach.myLoop.index % $rows == 0 || $smarty.foreach.myLoop.first }
								<div class="item-product">
							{/if}
								<div class="item-inner">
								<article class="product-miniature js-product-miniature" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
									<div class="img_block">
									  {block name='product_thumbnail'}
										<a href="{$product.url}" class="thumbnail product-thumbnail">
										  <img class="first-image"
											src = "{$product.cover.bySize.home_default.url}"
											alt = "{if !empty($product.cover.legend)}{$product.cover.legend}{else}{$product.name|truncate:30:'...'}{/if}"
											data-full-size-image-url = "{$product.cover.large.url}"
										  >
										   {hook h="rotatorImg" product=$product}	
										</a>
									  {/block}
										{block name='product_price_and_shipping'}
										  {if $product.show_price}
											<div class="product-price-and-shipping-top">
											  {if $product.has_discount}
												{if $product.discount_type === 'percentage'}
												  <span class="discount-percentage discount-product">{$product.discount_percentage}</span>
												{elseif $product.discount_type === 'amount'}
												  <span class="discount-amount discount-product">{$product.discount_amount_to_display}</span>
												{/if}
											  {/if}
											</div>
										  {/if}
										{/block}
										{block name='product_flags'}
										<ul class="product-flag">
										{foreach from=$product.flags item=flag}
											<li class="{$flag.type}"><span>{$flag.label}</span></li>
										{/foreach}
										</ul>
										{/block}
									</div>
									<div class="product_desc">
										{if isset($product.id_manufacturer)}
										 <div class="manufacturer"><a href="{url entity='manufacturer' id=$product.id_manufacturer }">{$product.manufacturer_name|strip_tags:'UTF-8'|escape:'html':'UTF-8'}</a></div>
										{/if}
										{block name='product_name'}
										  <h1 itemprop="name"><a href="{$product.url}" class="product_name">{$product.name|truncate:50:'...'}</a></h1>
										{/block}
										{block name='product_price_and_shipping'}
										  {if $product.show_price}
											<div class="product-price-and-shipping">
											  {if $product.has_discount}
												{hook h='displayProductPriceBlock' product=$product type="old_price"}

												<span class="sr-only">{l s='Regular price' d='Shop.Theme.Catalog'}</span>
												<span class="regular-price">{$product.regular_price}</span>
											  {/if}

											  {hook h='displayProductPriceBlock' product=$product type="before_price"}

											  <span class="sr-only">{l s='Price' d='Shop.Theme.Catalog'}</span>
											  <span itemprop="price" class="price {if $product.has_discount}price-sale{/if}">{$product.price}</span>
											  {hook h='displayProductPriceBlock' product=$product type='unit_price'}

											  {hook h='displayProductPriceBlock' product=$product type='weight'}
											</div>
										  {/if}
										{/block}
										{block name='product_description_short'}
											<div class="product-desc" itemprop="description">{$product.description_short|truncate:200:' ...'|escape:'html':'UTF-8' nofilter}</div>
										{/block}
										<div class="box-hover">
											<ul class="add-to-links">
												<li class="cart">
													{include file='catalog/_partials/customize/button-cart.tpl' product=$product}
												</li>
												<li>
													{hook h='displayProductActions' product=$product}
												</li>
											</ul>
										</div>
										
									
									</div>
								  </article>
								  </div>
							{if $smarty.foreach.myLoop.iteration % $rows == 0 || $smarty.foreach.myLoop.last  }
								</div>
							{/if}
						{/foreach}
						</div>
					</div>			
				{/foreach}	
				 </div> <!-- .tab_container -->
			</div>
		
		</div>	
	
	</div>
</div>
