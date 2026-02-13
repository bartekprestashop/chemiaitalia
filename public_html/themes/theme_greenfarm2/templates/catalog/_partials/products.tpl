{**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
<div id="js-product-list">
   <div class="products row product_content grid">
    {foreach from=$listing.products item="product"}
      {block name='product_miniature'}
	  	<div class="item-product col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">
          <article class="product-miniature js-product-miniature" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
			<div class="img_block thumbnail-container">
			  {block name='product_thumbnail'}
				<a href="{$product.url}" class="thumbnail product-thumbnail">
				  <img class="first-image" 
				   	src="{if !empty($product.cover.bySize.home_default.url)}{$product.cover.bySize.home_default.url}{else}/img/p/pl.jpg{/if}"
					alt = "{if !empty($product.cover.legend)}{$product.cover.legend}{else}{$product.name|truncate:60:'...'}{/if}"
					data-full-size-image-url = "{$product.cover.large.url}"
				  >
				   {hook h="rotatorImg" product=$product}	
				</a>
			  {/block}
			  <ul class="add-to-links">
					<li class="cart">
						{include file='catalog/_partials/customize/button-cart.tpl' product=$product}
					</li>
					<li>
						{hook h='displayProductActions' product=$product}
					</li>
					<li class="quick-view">
						{block name='quick_view'}
						<a class="quick_view" href="#" data-link-action="quickview" title="{l s='Quick view' d='Shop.Theme.Actions'}">
						 {l s='Quick view' d='Shop.Theme.Actions'}
						</a>
						{/block}
					</li>
				</ul>
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
				 <div class="manufacturer"><a href="{url entity='manufacturer' id=$product.id_manufacturer }">{Manufacturer::getnamebyid($product.id_manufacturer)}</a></div>
				{/if}
				{block name='product_name'}
				  <h1 itemprop="name"><a href="{$product.url}" class="product_name">{$product.name|truncate:120:'...'}</a></h1>
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
				{block name='product_reviews'}
					<div class="hook-reviews">
					{hook h='displayProductListReviews' product=$product}
					</div>
				{/block} 
				{block name='product_description_short'}
					<div class="product-desc desc_grid" itemprop="description">{$product.description_short|truncate:100:' ...'|escape:'html':'UTF-8' nofilter}</div>
					<div class="product-desc desc_list" itemprop="description">{$product.description_short|truncate:200:' ...'|escape:'html':'UTF-8' nofilter}</div>
				{/block}
				<ul class="add-to-links">
					<li class="cart">
						{include file='catalog/_partials/customize/button-cart.tpl' product=$product}
					</li>
					<li>
						{hook h='displayProductActions' product=$product}
					</li>
					<li class="quick-view">
						{block name='quick_view'}
						<a class="quick_view" href="#" data-link-action="quickview" title="{l s='Quick view' d='Shop.Theme.Actions'}">
						 {l s='Quick view' d='Shop.Theme.Actions'}
						</a>
						{/block}
					</li>
				</ul>
				{block name='product_variants'}
				{if $product.main_variants}
				{include file='catalog/_partials/variant-links.tpl' variants=$product.main_variants}
				{/if}
				{/block}
			
			</div>
		  </article>
		</div>
      {/block}
    {/foreach}
  </div>

  {block name='pagination'}
    {include file='_partials/pagination.tpl' pagination=$listing.pagination}
  {/block}
</div>
