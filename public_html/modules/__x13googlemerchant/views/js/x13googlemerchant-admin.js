$(document).ready(function(){

    if (typeof x13googlemerchant_bo_url !== 'undefined') {
        $('#desc-module-back').attr('href', x13googlemerchant_bo_url);
    }

    if (!x13googlemerchant_15)
    {
        $('.shipment-exclude').parents('.form-group').addClass('shipment-exclude-block');
        $('.country-shipping-price').parents('.form-group').addClass('country-shipping-price-block');
        $('.shipment-country-include').parents('.form-group').addClass('shipment-country-include-block');
    }

    customTitleFormat();
    $('select[name="X13_GOOGLEMERCHANT_TITLE_TYPE"]').on('change', customTitleFormat);

    function customTitleFormat()
    {
    	var $element = $('.custom_title_format');
    	$element.hide();
    	$val = $('select[name="X13_GOOGLEMERCHANT_TITLE_TYPE"]').val();
    	if (parseInt($val, 10) === 3) {
    		$element.show();
    	} else {
    		$element.hide();
    	}
    }

	energyEfficiencyClass();
	$('[name="X13_GOOGLEMERCHANT_ENERGY"]').on('change', energyEfficiencyClass);

	function energyEfficiencyClass()
	{
		var $element = $('#conf_id_X13_GOOGLEMERCHANT_ENERGY_ID');
		if (!x13googlemerchant_15) {
			$element = $element.closest('.form-group');
		}

		if ($('[name="X13_GOOGLEMERCHANT_ENERGY"]:checked').val() == 1) {
			$element.show();
		} else {
			$element.hide();
		}
	}

	unitPricing();
	$('[name="X13_GOOGLEMERCHANT_UNIT"]').on('change', unitPricing);

	function unitPricing()
	{
		var $elements = $('div[id^="conf_id_X13_GOOGLEMERCHANT_UNIT_"]');
		if (!x13googlemerchant_15) {
			$elements = $elements.closest('.form-group');
		}

		if ($('[name="X13_GOOGLEMERCHANT_UNIT"]:checked').val() == 1) {
			$elements.show();
		} else {
			$elements.hide();
		}
	}

	shippingLabel();
	$('[name="X13_GOOGLEMERCHANT_SHIP_LABEL"]').on('change', shippingLabel);

	function shippingLabel()
	{
		var $element = $('#conf_id_X13_GOOGLEMERCHANT_SHIP_LABEL_ID');
		if (!x13googlemerchant_15) {
			$element = $element.closest('.form-group');
		}

		if ($('[name="X13_GOOGLEMERCHANT_SHIP_LABEL"]:checked').val() == 1) {
			$element.show();
		} else {
			$element.hide();
		}
	}

    addingCombinationNameToElements();
    $('select[name="X13_GOOGLEMERCHANT_SKIP_ATTR"]').on('change', addingCombinationNameToElements);

    function addingCombinationNameToElements()
    {
        var $element = $('.adding_combination_name');
        $element.hide();
        $val = $('select[name="X13_GOOGLEMERCHANT_SKIP_ATTR"]').val();
        if (parseInt($val, 10) === 0 || parseInt($val, 10) === 2) {
            $element.show();
        } else {
            $element.hide();
        }
    }

	utmInputs();
	$('[name="X13_GOOGLEMERCHANT_UTM"]').on('change', utmInputs);

	function utmInputs()
	{
		var $elements;
		if (x13googlemerchant_15) {
			$elements = $('div[id^="conf_id_X13_GOOGLEMERCHANT_UTM_"]');
		} else {
			$elements = $('div[id^="conf_id_X13_GOOGLEMERCHANT_UTM_"]').closest('.form-group');
		}

		if ($('[name="X13_GOOGLEMERCHANT_UTM"]:checked').val() == 1) {
			$elements.show();
		} else {
			$elements.hide();
		}
	}

	overrideAttributeMapping();
	$('[name="X13_GOOGLEMERCHANT_OVERRIDE_ATTR"]').on('change', overrideAttributeMapping);

	function overrideAttributeMapping()
	{
		var $element = $('#conf_id_X13_GOOGLEMERCHANT_OVERRIDE_ATTR_MAPPING');
		$element.hide();
		if ($('[name="X13_GOOGLEMERCHANT_OVERRIDE_ATTR"]:checked').val() == 1) {
			$element.show();
		} else {
			$element.hide();
		}
	}

    shipmentBehaviorChange($('#shipment_behavior').val());

    $('#shipment_behavior').on('change', function() {
        shipmentBehaviorChange($(this).val());
    });

    function shipmentBehaviorChange(val)
    {
        if (val == 1) {
            $('.country-shipping-price-block').show();
            $('.shipment-exclude-block').hide();
            $('.shipment-country-include-block').hide();
        }
        else {
            $('.country-shipping-price-block').hide();
            $('.shipment-exclude-block').show();
            $('.shipment-country-include-block').show();
        }
    }

	$('.process-icon-downloadxml, .process-downloadxml').bind('click', function(e){
		e.preventDefault();
		$('#x13googlemerchant-generate-form').slideToggle('fast');
	});
	
	$('.change_status a, #top_container .x13googlemerchant > tbody > tr > td.center > a').bind('click', function(e){
		e.preventDefault();
		var _t = $(this);
		var post_obj = {
			'data' : {
				'method' : 'setGoogleStatus',
				'data' : {
					'id_shop' : x13googlemerchant_shop,
					'id_lang' : x13googlemerchant_lang,
					'active' : (_t.hasClass('action-disabled') || (_t.children('img').attr('src') == '../img/admin/disabled.gif')) ? 1 : 0,
					'param' : _t.attr('href')
				}
			}
		};
		$.post(x13googlemerchant_path + 'ajax.php', post_obj, function(d){
			if(d == 'ok1') {
				_t.removeClass('action-disabled').addClass('action-enabled');
				_t.blur().children('i').toggleClass('hidden');
				//1.5
				_t.attr('title', 'Włączone').children('img').attr('src', '../img/admin/enabled.gif');
			}
			else if(d == 'ok0') {
				_t.removeClass('action-enabled').addClass('action-disabled');
				_t.blur().children('i').toggleClass('hidden');
				//1.5
				_t.attr('title', 'Wyłączone').children('img').attr('src', '../img/admin/disabled.gif');
			}
			else {
				alert(d);
			}
		});
	});
	
	$('.google_name').each(function(){
		if($(this).val() != '') $(this).addClass('has-cat').attr('title', $(this).val());
	});
	
	$('body')
	.delegate('.google_name', 'focusin', function(){
		var _t = $(this);
		_t.data('old', $(this).val());
		var i, j = 0;
		var ab = '';
        var thisLang = _t.data('lang');
		ab += '<div class="htmnet-autocomplete">';
		for(i in google_categories[thisLang]) {
			if(google_categories[thisLang][i].toLowerCase().indexOf(_t.val()) != -1) {
				_ab += '<p>'+google_categories[thisLang][i]+'</p>';
				if(++j > 50) break;
			}
		}
		ab += '</div>';
		;
		var _ab = $(ab);
		_ab.width(_t.outerWidth()-2).insertAfter(_t).hide();
	})
	.delegate('.google_name', 'blur', function(){
		var _t = $(this);
		setTimeout(function(){
			if(!_t.hasClass('has-cat'))
				_t.val('');
			if(_t.data('old') != _t.val()) {
				var post_obj = {
					'data' : {
						'method' : 'setGoogleName',
						'data' : {
							'id_shop' : x13googlemerchant_shop, 
							'id_lang' : _t.data('lang'),
							'id_category' : _t.attr('name').replace('google_name_row_', ''),
							'google_name' : _t.val()
						}
					}
				};
				if(_t.attr('id') != 'mass_taxonomy') {
					$.post(x13googlemerchant_path + 'ajax.php', post_obj, function(d){
						if(d != 'ok') {
							alert(d);
						}
					});
				}
			}
			_t.siblings('.htmnet-autocomplete').remove();
		}, 500);
	})
	.delegate('.google_name', 'keydown', function(e){
		if(e.which == 13) e.preventDefault();
	})
	.delegate('.google_name', 'keyup', function(e){
		var _t = $(this);
        var thisLang = _t.data('lang');
		var _ab = $(this).siblings('.htmnet-autocomplete');
		var ab_height = _ab.height();
		switch(e.which) {
			case  13 : { //enter
				e.preventDefault();
				if(_ab.find('.active').length > 0) {
					var text = _ab.find('.active').text();
					_t.addClass('has-cat').val(text).attr('title', text);
					_ab.hide();
				}
			} break;
			/*
			case  27 : { //esc
				if(!_t.hasClass('has-cat'))
					_t.val('');
				_ab.hide();
			} break;
			*/
			case  38 : { //up
				if(_ab.find('.active').length > 0)
					_ab.find('.active').removeClass('active').prev('p').addClass('active');
				else 
					_ab.find('p').last().addClass('active');
				var pos = _ab.find('.active').position();
				if(pos)
					_ab.scrollTop(pos.top + _ab.scrollTop());
				else
					_ab.scrollTop(0);
			} break;
			case  40 : { //down
				if(_ab.find('.active').length > 0)
					_ab.find('.active').removeClass('active').next('p').addClass('active');
				else 
					_ab.find('p').first().addClass('active');
				var pos = _ab.find('.active').position();
				if(pos)
					_ab.scrollTop(pos.top + _ab.scrollTop());
				else
					_ab.scrollTop(0);
			} break;
			default : {
				if(_t.val() != _t.data('old')) _t.removeClass('has-cat');
				var _p = '';
				var i, j = 0;
				for(i in google_categories[thisLang]) {
					if(google_categories[thisLang][i].search(new RegExp(_t.val(), "i")) != -1) {
						_p += '<p>'+google_categories[thisLang][i]+'</p>';
						if(++j > 50) break;
					}
				}
				if(_p != '')
					_ab.empty().html(_p).show();
				else
					_ab.hide();
			}
		}
	});
	
	$('body')
	.delegate('.htmnet-autocomplete p', 'mouseenter', function(){
		$(this).addClass('active').siblings('active').removeClass('active');
	})
	.delegate('.htmnet-autocomplete p', 'mouseleave', function(){
		$(this).removeClass('active').siblings('active').removeClass('active');
	})
	.delegate('.htmnet-autocomplete p', 'click', function(e){
		e.preventDefault();
		var text = $(this).text();
		$(this).parent().siblings('.google_name').addClass('has-cat').val(text).attr('title', text);
		$(this).parent().remove();
	});
	
	if($('.setMassTaxonomy').length > 0) {
		var mass_quantity_trigger = $('.setMassTaxonomy').parent();
	}
	else if($('[name="submitBulksetMassTaxonomyx13googlemerchant"]').length > 0) {
		var mass_quantity_trigger = $('[name="submitBulksetMassTaxonomyx13googlemerchant"]');
	}
	else {
		var mass_quantity_trigger = false;
	}
	
	if(mass_quantity_trigger) {
		mass_quantity_trigger.removeAttr('onclick');
		mass_quantity_trigger.bind('click', function(e){
			e.preventDefault();
			var ids = '0';
			$('[name="x13googlemerchantBox\[]\"]:checked').each(function(){
				ids += ',' + $(this).val();
			});

            var langOptions = '';
            x13languages.forEach(function(el, i) {
                langOptions += '<option value="'+el.id_lang+'" '+ (el.id_lang == x13googlemerchant_lang ? 'selected="selected"' : '') +'>'+el.name+'</option>';
            });

			var content =
				'<form action="'+$(this).closest('form').attr('action')+'" method="post">'+
					'<input type="hidden" name="masstaxonomyx13pdfoffer_product" value="">'+
					'<input type="hidden" name="ids" value="' + ids + '">'+
					'<div class="bootstrap">'+
                        '<div class="row clearfix" style="margin:0 0 5px 0">'+
                            '<label for="mass_language" style="padding-top:4px">Wybierz język:</label>'+
                            '<select id="mass_language" name="mass_language" onchange="javascript:changeMassLanguage(this.value)">'+
                                langOptions +
                            '</select>'+
                        '</div>'+
						'<div class="row clearfix" style="margin:0 0 5px 0">'+
							'<label for="mass_taxonomy" style="padding-top:4px">Wybierz kategorię:</label>'+
							'<div>'+
								'<input autocomplete="off" type="text" name="mass_taxonomy" id="mass_taxonomy" class="google_name" data-lang="'+x13googlemerchant_lang+'">'+
							'</div>'+
						'</div><hr>'+
						'<div class="row clearfix" style="margin:0 0 5px 0">'+
							'<button type="submit" class="btn btn-default">Zastosuj</button>'+
						'</div>'+
					'</div>'+
				'</form>'
			;
			$.fancybox(content, {'autoDimensions': false, 'autoSize': false, 'width': 500, 'height': '370px', 'openEffect': 'fadeIn', 'closeEffect': 'fadeOut'} );
		});
	}
});

function changeMassLanguage(id)
{
    $('.fancybox-overlay input#mass_taxonomy').data('lang', parseInt(id)).attr('data-lang', parseInt(id));
}

if (typeof hideOtherLanguage === 'undefined') {
    function hideOtherLanguage(id)
    {
        $('.translatable-field').hide();
        $('.lang-' + id).show();
    }
}
