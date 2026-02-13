<?php

class HelperOptions {
	/**
     * Display flags in forms for translations
     *
     * @param array $languages All languages available
     * @param int $default_language Default language id
     * @param string $ids Multilingual div ids in form
     * @param string $id Current div id]
     * @param bool $return define the return way : false for a display, true for a return
     * @param bool $use_vars_instead_of_ids use an js vars instead of ids seperate by "¤"
     */
    public function displayFlags($languages, $default_language, $ids, $id, $return = false, $use_vars_instead_of_ids = false)
    {
        if (count($languages) == 1) {
            return false;
        }
        $output = '
		<div class="displayed_flag">
			<img src="../img/l/'.$default_language.'.jpg" class="pointer" id="language_current_'.$id.'" onclick="toggleLanguageFlags(this);" alt="" />
		</div>
		<div id="languages_'.$id.'" class="language_flags">
			Wybierz język<br /><br />';
        foreach ($languages as $language) {
            if ($use_vars_instead_of_ids) {
                $output .= '<img src="../img/l/'.(int)($language['id_lang']).'.jpg" class="pointer" alt="'.$language['name'].'" title="'.$language['name'].'" onclick="changeLanguage(\''.$id.'\', '.$ids.', '.$language['id_lang'].', \''.$language['iso_code'].'\');" /> ';
            } else {
                $output .= '<img src="../img/l/'.(int)($language['id_lang']).'.jpg" class="pointer" alt="'.$language['name'].'" title="'.$language['name'].'" onclick="changeLanguage(\''.$id.'\', \''.$ids.'\', '.$language['id_lang'].', \''.$language['iso_code'].'\');" /> ';
            }
        }
        $output .= '</div>';

        if ($return) {
            return $output;
        }
        echo $output;
    }

	public function generateOptions($fields_options) {
		return $this->displayOptionsList($fields_options);
	}
	
	public function displayOptionsList($fields_options) {
		
		global $currentIndex, $cookie, $tab;
		$html =  '';
		
		$this->_fieldsOptions = $fields_options;
		
		if (!isset($this->_fieldsOptions) || !count($this->_fieldsOptions))
			return false;

		$defaultLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
		$this->_languages = Language::getLanguages(false);
		$tabAdmin = Tab::getTab((int)$cookie->id_lang, Tab::getIdFromClassName($tab));
		
		$html .=   '
		<script type="text/javascript">
			id_language = Number('.$defaultLanguage.');
		</script>
		
		<form action="'.$this->currentIndex.'&token='.$this->token.'" method="post">';
		foreach ($this->_fieldsOptions as $key_fieldset => $fieldset) {
			$html .=   '<fieldset>';
			$html .=   (isset($fieldset['title']) ? '<legend><img src="'.(!empty($tabAdmin['module']) && file_exists($_SERVER['DOCUMENT_ROOT']._MODULE_DIR_.$tabAdmin['module'].'/'.$tabAdmin['class_name'].'.gif') ? _MODULE_DIR_.$tabAdmin['module'].'/' : '../img/t/').$tabAdmin['class_name'].'.gif" />'.$fieldset['title'].'</legend>' : '');
		
			foreach ($fieldset['fields'] as $key => $field) {
				
			$val = Tools::getValue($key, Configuration::get($key));
			if ($field['type'] != 'textLang')
				if (!Validate::isCleanHtml($val))
					$val = Configuration::get($key);
					$html .=   '
						<label>'.$field['title'].' </label>
						<div class="margin-form">';
						switch ($field['type']) {
							
						case 'select':
							$html .=   '<select name="'.$key.'">';
							foreach ($field['list'] as $value)
								$html .=   '<option value="'.(isset($field['cast']) ? $field['cast']($value[$field['identifier']]) : $value[$field['identifier']]).'"'.($val == $value[$field['identifier']] ? ' selected="selected"' : '').'>'.$value['name'].'</option>';
							$html .=   '</select>';
						break;
						
						case 'bool':
							$html .=   '<label class="t" for="'.$key.'_on"><img src="../img/admin/enabled.gif" alt="tak" title="tak" /></label>
							<input type="radio" name="'.$key.'" id="'.$key.'_on" value="1"'.($val ? ' checked="checked"' : '').' />
							<label class="t" for="'.$key.'_on"> tak </label>
							<label class="t" for="'.$key.'_off"><img src="../img/admin/disabled.gif" alt="nie" title="nie" style="margin-left: 10px;" /></label>
							<input type="radio" name="'.$key.'" id="'.$key.'_off" value="0" '.(!$val ? 'checked="checked"' : '').'/>
							<label class="t" for="'.$key.'_off"> nie </label>';
						break;
						
						case 'radio' : {
							foreach($field['choices'] as $id => $value) {
								$html .=   '
								<input type="radio" name="'.$key.'" id="'.$key.'_'.$id.'" value="'.$id.'" '.(($val == $id)  ? 'checked="checked" ' : '').'/>
								';
								$html .=   '
									<label class="t" for="'.$key.'_'.$id.'">'.$value.'</label>
								';
							}
						} break;
						
						case 'color' : {
							$html .=   '
							<div>
								<input width="20px" type="color" data-hex="true" class="color mColorPickerInput mColorPicker" name="'.$field['name'].'" value="'.htmlentities($val, ENT_COMPAT, 'UTF-8').'" />
							</div>';
						} break;
						
						case 'textLang':
							foreach ($this->_languages as $language){
								$val = Tools::getValue($key.'_'.$language['id_lang'], Configuration::get($key, $language['id_lang']));
								if (!Validate::isCleanHtml($val))
									$val = Configuration::get($key);
								$html .=   '
								<div id="'.$key.'_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
									<input size="'.$field['size'].'" type="text" name="'.$key.'_'.(int)$language['id_lang'].'" value="'.$val.'" />
								</div>';
							}
							$this->displayFlags($this->_languages, $defaultLanguage, $key, $key);
							$html .=   '<br style="clear:both">';
						break;
						
						case 'textareaLang':
							foreach ($this->_languages as $language)
							{
								$val = Configuration::get($key, $language['id_lang']);
								$html .=   '
								<div id="'.$key.'_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
									<textarea rows="'.(int)($field['rows']).'" cols="'.(int)($field['cols']).'"  name="'.$key.'_'.$language['id_lang'].'">'.str_replace('\r\n', "\n", $val).'</textarea>
								</div>';
							}
							$this->displayFlags($this->_languages, $defaultLanguage, $key, $key);
							$html .=   '<br style="clear:both">';
						break;
						
						case 'textarea' :
							$html .= '<textarea rows="'.(int)($field['rows']).'" cols="'.(int)($field['cols']).'"  name="'.$key.'">'.str_replace('\r\n', "\n", $val).'</textarea>';
						break;
						
						case 'checkboxmultiple' :
							if(isset($val))
								$checked_values = explode(',', $val);
							else
								$checked_values = array();
							foreach($field['choices'] AS $k => $v) {
								$html .= '
								<p class="checkbox">
									<label for="'.$key.$k.'_on" style="float:none;text-align:left;">
										<input type="checkbox" name="'.$key.'[]" id="'.$key.$k.'_on" value="'.$k.'"'.(in_array($k, $checked_values) ? ' checked="checked"' : '').' '.(isset($field['js'][$k]) ? $field['js'][$k] : '').'/>
										'.$v.'
									</label>
								</p>';
							}
						break;
						
						case 'text':
						default:
							$html .=   '<input type="text" name="'.$key.'" value="'.$val.'" size="'.$field['size'].'" />'.(isset($field['suffix']) ? $field['suffix'] : '');
			}

			if (isset($field['required']) AND $field['required'])
				$html .=   ' <sup>*</sup>';

			$html .=   (isset($field['desc']) ? '<p>'.$field['desc'].'</p>' : '');
			
			$html .=   '</div>';
		}
		if(isset($fieldset['submit'])) {
			$html .=
			'<div class="margin-form">
				<input type="hidden" value="Zapisz" name="'.$fieldset['submit']['name'].'"/>
				<input type="submit" value="Zapisz" name="'.$fieldset['submit']['name'].'" class="button" />
			</div>';
		}
		$html .= '</fieldset>';
	}
	$html .=   '
		<input type="hidden" name="token" value="'.$this->token.'" />
	</form>
	<br>
	';
	return $html;
	}
	
	
}

?>
