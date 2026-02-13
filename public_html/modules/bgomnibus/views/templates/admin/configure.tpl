{*
* 2007-2022 PrestaShop
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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2022 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="panel">
	<h3><i class="icon icon-credit-card"></i> {l s='Omnibus ' mod='bgomnibus'}</h3>
	<p>
		<strong>{l s='Module presenting the history of price changes.' mod='bgomnibus'}</strong><br />
		{l s='The module has its own hook that you can place anywhere in the store related to the product.' mod='bgomnibus'}
		<br />
		{l s='To use, place this code on the product card or product list : '}
		&#123;hook h='displayOmnibusInfo' product=$product&#125;
		<br />
		{l s='To generate daily price drops use : '}
		https://yourshopurl.com/module/bgomnibus/cron

	</p>
	<br />
	<p>
		{l s='Enjoy!' mod='roxomnibus'}
	</p>
</div>
<!--
<div class="panel">
	<h3><i class="icon icon-tags"></i> {l s='Documentation' mod='roxomnibus'}</h3>
	<p>
		&raquo; {l s='You can get a PDF documentation to configure this module' mod='roxomnibus'} :
		<ul>
			<li><a href="#" target="_blank">{l s='English' mod='roxomnibus'}</a></li>
			<li><a href="#" target="_blank">{l s='French' mod='roxomnibus'}</a></li>
		</ul>
	</p>
</div>
-->

