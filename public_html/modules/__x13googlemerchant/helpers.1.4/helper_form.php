<?php

class helperForm extends Module {
	
	public function generateForm($fields_form) {
		return $this->displayForm($fields_form);
	}
	
	public function displayForm($fields_form)
	{
		global $currentIndex, $cookie;
		$html = '';
		
		$allowEmployeeFormLang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		if ($allowEmployeeFormLang && !$cookie->employee_form_lang)
			$cookie->employee_form_lang = (int)_PS_LANG_DEFAULT_;
		$useLangFromCookie = false;
		$this->_languages = Language::getLanguages(false);
		if ($allowEmployeeFormLang)
			foreach ($this->_languages as $lang)
				if ($cookie->employee_form_lang == $lang['id_lang'])
					$useLangFromCookie = true;
		if (!$useLangFromCookie)
			$this->_defaultFormLanguage = (int)(Configuration::get('PS_LANG_DEFAULT'));
		else
			$this->_defaultFormLanguage = (int)$cookie->employee_form_lang;

		$html .=  '
		<script type="text/javascript">
			$(document).ready(function() {
				id_language = '.$this->_defaultFormLanguage.';
				languages = new Array();';
		foreach ($this->_languages as $k => $language)
			$html .=  '
				languages['.$k.'] = {
					id_lang: '.(int)$language['id_lang'].',
					iso_code: \''.$language['iso_code'].'\',
					name: \''.htmlentities($language['name'], ENT_COMPAT, 'UTF-8').'\'
				};';
		$html .=  '
				displayFlags(languages, id_language, '.$allowEmployeeFormLang.');
			});
		</script>';

		//definiowanie pól wielojęzykowych
		foreach($fields_form as $ff) {
			foreach($ff['form']['input'] as $field) {
				if($field['lang']) $lang_fields[] = $field['name'];
			}
		}
		if(isset($lang_fields))
			$langtags = implode('¤', $lang_fields);
		else
			$langtags = '';
		$html .=  '
			<form action="'.$this->currentIndex.'&token='.$this->token.'" method="post" enctype="multipart/form-data">
			<script type="text/javascript" src="../js/jquery/jquery-colorpicker.js"></script>
		';
		
		//TO_DO: hint, desc, suffix, required
		
		foreach($fields_form as $ff) {
			$html .=  '
				<fieldset style="width: 905px;">
					<legend>'.$ff['form']['legend']['title'].'</legend>
			';
			if(isset($ff['form']['input'])) {
				foreach($ff['form']['input'] as $field) {
					
					$html .=  '
						<label'.(($field['type'] == 'hidden') ? ' style="display:none;"' : '').'>'.$field['label'].'</label>
						<div class="margin-form"'.(($field['type'] == 'hidden') ? ' style="display:none;"' : '').'>
					';
					
					switch($field['type']) {
						
						case 'hidden' : {
							$html .=  '
								<input type="text" size="'.(!empty($field['size']) ? $field['size'] : '').'" name="'.$field['name'].'" value="'.htmlentities($this->fields_value[$field['name']], ENT_COMPAT, 'UTF-8').'" />
							';
						} break;
						
						case 'radio' : {
							foreach($field['values'] as $value) {
								$html .=  '
								<input type="radio" name="'.$field['name'].'" id="'.$field['name'].'_'.$value['id'].'" value="'.$value['value'].'" '.(($this->fields_value[$field['name']] == $value['value'])  ? 'checked="checked" ' : '').'/>
								';
								if($value['label'] == 'Enabled')
									$html .=  '
										<label class="t" for="'.$value['id'].'"> <img src="../img/admin/enabled.gif" alt="'.$value['label'].'" title="'.$value['label'].'" /></label>
									';
								elseif($value['label'] == 'Disabled')
									$html .=  '
										<label class="t" for="'.$value['id'].'"> <img src="../img/admin/disabled.gif" alt="'.$value['label'].'" title="'.$value['label'].'" /></label>
									';
								else
									$html .=  '
										<label class="t" for="'.$value['id'].'">'.$value['label'].'</label>
									';
							}
						} break;
						
						case 'checkbox' : {
							//todo in future
						} break;
						
						case 'select' : {
							$html .=  '<select name="'.$field['name'].'" id="'.$field['name'].'" style="width:40%">';
							foreach($field['options']['query'] as $option) {
								$html .=  '
								<option value="'.$option[$field['options']['id']].'" '.(($this->fields_value[$field['name']] == $option[$field['options']['id']]) ? ' selected="selected"' : '').'>'.$option[$field['options']['name']].'</option>
								';
							}
							$html .=  '</select>';
						} break;
						
						case 'date' : {
							$date_fields[] = $field['name'];
							$html .=  '
								<input  name="'.$field['name'].'" id="'.$field['name'].'" type="text" style="text-align: center" value="'.htmlentities($this->fields_value[$field['name']], ENT_COMPAT, 'UTF-8').'"></input>
							';
						} break;
						
						case 'color' : {
							$html .=  '
								<div>
									<input width="20px" type="color" data-hex="true" class="color mColorPickerInput mColorPicker" name="'.$field['name'].'" value="'.htmlentities($this->fields_value[$field['name']], ENT_COMPAT, 'UTF-8').'" />
								</div>';
						} break;
						
						case 'textarea' : {
							if(isset($field['class']) && strpos($field['class'], 'rte') !== false) {
								$attrs = 'class="rte" cols="100" rows="10"';
							}
							else {
								$attrs = 'class="'.(!empty($field['class']) ? $field['class'] : '').'" cols="'.(!empty($field['cols']) ? (int)$field['cols'] : 94).'" rows="'.(!empty($field['rows']) ? (int)$field['rows'] : 10).'"';
							}
							if($field['lang']) {
								$html .=  '<div class="translatable">';
								foreach ($this->_languages as $language) {
									$html .=  '
										<div style="display: '.($language['id_lang'] == $this->_defaultFormLanguage ? 'block' : 'none').'; float: left;">
											<textarea '.$attrs.' id="'.$field['name'].'_'.$language['id_lang'].'" name="'.$field['name'].'_'.$language['id_lang'].'">'.htmlentities($this->fields_value[$field['name']][$language['id_lang']], ENT_COMPAT, 'UTF-8').'</textarea>
										</div>
									';
								}
								$this->displayFlags($this->_languages, $this->_defaultFormLanguage, $langtags, $field['name']);
								$html .=  '</div>';
								$html .=  '
									<p class="preference_description" style="clear:both;">'.(isset($field['desc']) ? $field['desc'] : '').'</p>
								';
								$html .=  '<div class="clear"></div>';
							}
							else {
								$html .=  '
									<div>
										<textarea '.$attrs.' name="'.$field['name'].'">'.htmlentities($this->fields_value[$field['name']], ENT_COMPAT, 'UTF-8').'</textarea>
									</div>
								';
							}
						} break;
						
						default : { // text
							if($field['lang']) {
								foreach ($this->_languages as $language)
								$html .=  '
									<div id="'.$field['name'].'_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $this->_defaultFormLanguage ? 'block' : 'none').'; float: left;">
										<input size="'.(!empty($field['size']) ? (int)$field['size'] : 90).'" maxlength="'.(!empty($field['maxlength']) ? (int)$field['maxlength'] : '').'" type="text" name="'.$field['name'].'_'.$language['id_lang'].'" id="'.$field['name'].'_'.$language['id_lang'].'" value="'.htmlentities($this->fields_value[$field['name']][$language['id_lang']], ENT_COMPAT, 'UTF-8').'" />
									</div>';
								$this->displayFlags($this->_languages, $this->_defaultFormLanguage, $langtags, $field['name']);
								$html .=  '<div class="clear"></div>';
							}
							else {
								$html .=  '
									<input size="'.(!empty($field['size']) ? (int)$field['size'] : 90).'" maxlength="'.(!empty($field['maxlength']) ? (int)$field['maxlength'] : '').'" type="text" name="'.$field['name'].'" id="'.$field['name'].'" value="'.htmlentities($this->fields_value[$field['name']], ENT_COMPAT, 'UTF-8').'" />
								';
							}
						}
						
					}
					$html .=  '
						</div>
						<div style="clear:both"></div>
					';
				}
			}
			
			$html .=  '
				<div class="margin-form">
			';
			if(isset($ff['form']['buttons'])) {
				foreach($ff['form']['buttons'] as $button) {
					$html .=  '
						<a class="button" style="font-size:12px;padding:4px" href="'.$button['href'].'">'.$button['title'].'</a>
					';
				}
				
			}
			if(isset($ff['form']['submit'])) {
				$html .=  '
					<input type="submit" value="'.$ff['form']['submit']['title'].'" name="'.$this->submit_action.'" class="button" />
				';
			}
			$html .= '</div>';
			$html .=  '
				<div class="small"><sup>*</sup> '.$this->l('Required field').'</div>
			</fieldset>
			';
		}
		$html .=  '
		</form>
		';
		
		//dołączanie pickera do daty
		if(isset($date_fields)) {
			include_once('functions.php');
			includeDatepicker($date_fields, true);
		}
		
		//dołączanie edytora TinyMCE
		$iso = Language::getIsoById((int)($cookie->id_lang));
		$isoTinyMCE = (file_exists(_PS_ROOT_DIR_.'/js/tiny_mce/langs/'.$iso.'.js') ? $iso : 'en');
		$ad = dirname($_SERVER["PHP_SELF"]);
		$html .=  '
			<script type="text/javascript">	
			var iso = \''.$isoTinyMCE.'\' ;
			var pathCSS = \''._THEME_CSS_DIR_.'\' ;
			var ad = \''.$ad.'\' ;
			</script>
			<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tiny_mce/tiny_mce.js"></script>
			<script type="text/javascript" src="'.__PS_BASE_URI__.'js/tinymce.inc.js"></script>
		';
		
		return $html;
		
	}
	
}

?>
