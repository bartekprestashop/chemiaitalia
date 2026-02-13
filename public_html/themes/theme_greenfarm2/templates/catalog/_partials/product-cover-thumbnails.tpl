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
<div class="images-container {if $product.images|count <= 1}no-thumbs{else}has-thumbs{/if}">
{block name='product_cover'}
    <div class="product-cover">
      <img id="zoom-images" class="hidden-lg-down js-qv-product-cover"
		   src="{if !empty($product.cover.bySize.large_default.url)}{$product.cover.bySize.large_default.url}{else}/img/p/pl.jpg{/if}"
		   data-zoom-image="{$product.cover.bySize.large_default.url}" alt="{$product.cover.legend}" title="{$product.cover.legend}" style="width:100%;" itemprop="image">
	  <img class="hidden-xl-up js-qv-product-cover" src="{$product.cover.bySize.large_default.url}" alt="{$product.cover.legend}" title="{$product.cover.legend}" style="width:100%;" itemprop="image">
		{if $product.images|count > 1}
		<div id="click-zoom">
        <i class="material-icons zoom-in">&#xE8FF;</i>
		</div>
		{/if}
    </div>

  {/block}
{block name='product_images'}
  {if $product.images|count > 1}
    <div class="js-qv-mask mask pos_content hidden-lg-down">
      <div class="product-images js-qv-product-images owl-carousel">
        {foreach from=$product.images item=image name=myLoop}
		{if $smarty.foreach.myLoop.index % 4 == 0 || $smarty.foreach.myLoop.first }
          <div class="thumb-container" id="gal1">
		  {/if}
			<a data-image="{$image.bySize.large_default.url}"
              data-zoom-image="{$image.bySize.large_default.url}">
            <img id="zoom-images"
              class="thumb js-thumb {if $image.id_image == $product.cover.id_image} selected {/if}"
              src="{$image.bySize.cart_default.url}"
              alt="{$image.legend}"
              title="{$image.legend}"
              width="100"
              itemprop="image"
            >
			</a>
			{if $smarty.foreach.myLoop.iteration % 4 == 0 || $smarty.foreach.myLoop.last  }
          </div>
		    {/if}
        {/foreach}
      </div>
    </div>
	<div class="js-qv-mask mask pos_content hidden-xl-up">
      <div class="product-images js-qv-product-images  owl-carousel">
        {foreach from=$product.images item=image}
          <div class="thumb-container">
            <img
              class="thumb js-thumb {if $image.id_image == $product.cover.id_image} selected {/if}"
              data-image-medium-src="{$image.bySize.large_default.url}"
              data-image-large-src="{$image.bySize.large_default.url}"
              src="{$image.bySize.home_default.url}"
              alt="{$image.legend}"
              title="{$image.legend}"
              width="100"
              itemprop="image"
            >
          </div>
        {/foreach}
      </div>
    </div>
  {/if}
{/block}
</div>
{hook h='displayAfterProductThumbs'}
<script type="text/javascript"> 
		$(document).ready(function() {
			var owl = $("#product .images-container .product-images");
			owl.owlCarousel({
				autoPlay : false ,
				smartSpeed: 1000,
				autoplayHoverPause: true,
				nav: true,
				dots : false,	
				responsive:{
					0:{
						items:1,
					},
					480:{
						items:1,
					},
					768:{
						items:1,

					},
					992:{
						items:1,
					},
					1200:{
						items:1,
					}
				}
			}); 
			var owl = $(".quickview .images-container .product-images");
			owl.owlCarousel({
				loop: true,
				animateOut: 'fadeOut',
				animateIn: 'fadeIn',
				autoPlay : false ,
				smartSpeed: 1000,
				autoplayHoverPause: true,
				nav: true,
				dots : false,	
				responsive:{
					0:{
						items:1,
					},
					480:{
						items:1,
					},
					768:{
						items:1,
						nav:false,
					},
					992:{
						items:1,
					},
					1200:{
						items:1,
					}
				}
			}); 
			 //initiate the plugin and pass the id of the div containing gallery images 
			$("#zoom-images").elevateZoom({ gallery: 'gal1', zoomType: "inner", cursor: "crosshair", galleryActiveClass: 'active', imageCrossfade: true });
			//pass the images to Fancybox 
			$("#click-zoom").bind("click", function (e) { var ez = $('#zoom-images').data('elevateZoom'); $.fancybox(ez.getGalleryList()); return false; });
		});
</script>