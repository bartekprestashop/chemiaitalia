<?php
/*
 * Stworzono przez SEIGI http://pl.seigi.eu/
 * Wszelkie prawa zastrzeżone.
 * Zabrania się modyfikacji używania i udostępniania kodu bez zgody lub odpowiedniej licencji.
 * Utworzono  : 2025-01-05 12:43:31
 * Author     : SEIGI - Grzegorz Zawadzki <kontakt@seigi.eu>
 */

if(
    extension_loaded('xdebug') ||
    Configuration::get('SEI_BLOCK_seigicookie') == 1 ||
    !extension_loaded('ionCube Loader') ||
    ioncube_loader_iversion() < 120000 ||
    PHP_VERSION_ID < 80100 ||
    PHP_VERSION_ID > 80199
){
    if (PHP_SAPI === 'cli') {
        $message = "";
        if (extension_loaded('xdebug')) {
            $message .= "------- ERROR: Xdebug jest zainstalowany. Powoduje on konflikty z IONCube Loader.\n";
        }
        if (!extension_loaded('ionCube Loader')) {
            $message .= "------- ERROR: ionCube Loader nie jest zainstalowany.\n";
        }
        if (PHP_VERSION_ID < 80100) {
            $message .= "------- ERROR: Dla tego modułu minimalna wersja PHP to 8.1.0. Na naszej stronie https://seigi.eu/ mogą być dostepne wersje dla Twojej wersji PHP\n";
        }

        if (PHP_VERSION_ID > 80199) {
            $message .= "------- ERROR: Dla tego modułu maksymalna wersja PHP to 8.1.99. Na naszej stronie https://seigi.eu/ mogą być dostepne wersje dla Twojej wersji PHP\n";
        }
        if($message) {
            die($message);
        }
    }
	class seigicookie extends Module {
		public function __construct()
		{
			$this->name = 'seigicookie';
			$this->version = 'x.x.x';
			$this->author = 'SEIGI';
			$this->need_instance = 1;
			parent::__construct();
			$this->displayName = 'seigicookie';
			$this->description = 'Nie można było zainstalować modułu / Unable to install module';
		}

		public function install() {
			// Blokada jest tylko po to, ażeby klient napewno odinstalował moduł.
			// Znając życie, to nikt nie przeczyta tego do końca, a procedury instalacyjne muszę zostać wykonane
			Configuration::updateGlobalValue('SEI_BLOCK_seigicookie', 1);
			return parent::install();
		}
		public function uninstall() {
			Configuration::deleteByName('SEI_BLOCK_seigicookie');
			return parent::uninstall();
		}


		public function getContent() {

        $minimum_io_v = '12.0.0';



        $is_ok = true;
        $return = '';
        $return .= '<div style="padding: 15px;">';
        $return .= '<h1>Nie można uruchomić modułu.</h1>';
        $return .= '<p>Prosimy o zapoznanie się z wymagniami modułu <a href="http://docs.seigi.eu/Podstawowe_informacje/Ioncube/index.html">Więcej informacji na temat wymagań zanajduje się pod tym adresem</a></p>';
        $ic_version = 0;
        $errors = [];
        if( extension_loaded('xdebug')){
            $errors[] = $this->displayError('<span style="color: black"><b>Rozszerzenie xDebug i IonCube nie są kompatybilne</b> i nie mogą współdziałać. Aby moduł działał poprawnie, niezbędne jest odinstalowanie rozszerzenia xDebug, które powoduje błędy typu 500.<br> Więcej informacji znajduje się na stronie: https://xdebug.org/docs/compat.</span>');
            $is_ok = false;
        }

        if(!function_exists('ioncube_loader_iversion') || !function_exists('ioncube_loader_version')){
            $ic_message = '<b style="color: red;">BŁĄD: IonCube jest albo bardzo bardzo stary, albo w ogóle nie jest zainstalowany';
            $is_ok = false;
        }else if(intval('120000') > ioncube_loader_iversion()){
            $ic_version = ioncube_loader_iversion();
            $ic_message = '<b style="color: red;">BŁĄD: Zainstalowana wersja IonCube Loader jest zbyt stara.';
            $is_ok = false;
        } else {
            $ic_version = ioncube_loader_iversion();
            $ic_message = '<b style="color: green;">OK: Wersja IonCube Loader jest odpowiednia';
        }

        if(PHP_VERSION_ID < intval('80100')){
            $php_message = '<b style="color: red;">BŁĄD: Wersja jest zbyt stara. ';
            $is_ok = false;
        } elseif(PHP_VERSION_ID > intval('80199')){
            $php_message = '<b style="color: red;">BŁĄD: Wersja jest zbyt wysoka. Jeszcze jej nie wspieramy. ';
            $is_ok = false;
        } else {
            $php_message = '<b style="color: green;">OK: Wersja jest odpowiednia';
        }
        $return .= implode('', $errors);
        $return .= '<table class="table"">
                <thead>
                <tr>
                <th>&nbsp;</th>
                <th>Wymagana</th>
                <th>Zainstalowana</th>
                <th>Status</th>
               </tr>
                </thead>
               <tr>
                <td>Ioncube</td>
                <td>'.$minimum_io_v.'</td>
                <td>'.implode('.', array_map('intval',str_split(str_pad($ic_version, 6, 0, STR_PAD_LEFT),2))).'</td>
                <td>'. $ic_message .'</td>
               </tr>
               <tr>
                <td>PHP</td>
                <td>8.1.0 - 8.1.99</td>
                <td>'.phpversion(). '</td>
                <td>'.$php_message.'</td>
               </tr>



    </table>';

            $test_xyz = function($domain) use (&$return){
                $return .= "<p>Testing {$domain} / IP: ".gethostbyname($domain).': ';
                $return .= (Tools::file_get_contents('http://'.$domain.'/xyz.txt') == 'xyz' ? '<span style="color: green">Connection OK</span>' : '<span style="color: red">Not xyz - connection error</span>');
                $return .= "</p>";
            };

            $test_xyz('seigi.eu');
            $test_xyz('s1.license.seigi.eu');
            $test_xyz('s2.license.seigi.eu');
            $test_xyz('s3.license.seigi.eu');
            $test_xyz('s4.license.seigi.eu');

            if($is_ok && Configuration::get('SEI_BLOCK_seigirequestreview') == 1){
                $return .= '<div style="padding: 10px; text-align: center; color: white; font-size: 2em; background-color: green;">' .
                    'Wszystko wygląda poprawnie. Aby zapewnić prawidłowe działanie modułu, należy przejść do listy modułów i przeprowadzić jego ponowną instalację.' .
                    '</div>';
            } else {
                $return .= '<div style="padding: 10px; text-align: center; color: white; font-size: 2em; background-color: #bd2424;">Prosimy poprawić błędy/problemy i zainstalować ponownie moduł. Prosimy odinstalować i zainstalować moduł ponownie</div>';
            }
            $return .= '</div>';

            return $return;
        }


	}

} else {
	require_once(dirname(__FILE__). '/seigicookie.inc.php');
}
