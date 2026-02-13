{*
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="recommended-product parents-product"
	data-items="{$content_options.number_item}" 
	data-lazyload="{$content_options.lazy_load}" 
	data-speed="{$content_options.speed_slide}"
	data-autoplay="{$content_options.auto_play}"
	data-time="{$content_options.auto_time}"
	data-arrow="{$content_options.show_arrow}"
	data-pagination="{$content_options.show_pagination}"
	data-move="{$content_options.move}"
	data-pausehover="{$content_options.pausehover}"
	data-md="{$content_options.items_md}"
	data-sm="{$content_options.items_sm}"
	data-xs="{$content_options.items_xs}"
	data-xxs="{$content_options.items_xxs}">
	<div class="container">
		{if $title}
		<div class="pos_title">
			 <h2>
				{$title}
			</h2>	
		</div>
		{/if}
		<div class="row pos_content">
			<div class="recommendedproductslide owl-carousel shop-products">
			{foreach from=$products item="product" name=myLoop}
				{if $smarty.foreach.myLoop.index % $content_options.rows == 0 || $smarty.foreach.myLoop.first }
					<div class="item-product">
				{/if}
					{include file="catalog/_partials/miniatures/product.tpl" product=$product}
				{if $smarty.foreach.myLoop.iteration % $content_options.rows == 0 || $smarty.foreach.myLoop.last  }
					</div>
				{/if}
			{/foreach}
			</div>
		</div>
    </div>
</div>