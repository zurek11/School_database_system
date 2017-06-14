<?php

class App {

	private $dotenv;
	private $dump;

	function __construct($dotenv) {
		$this->dotenv = $dotenv;
	}

    public function autoload() {

    	session_start();
		ob_start();

		$this->dotenv->load();
		$this->dotenv->required(['DB_HOST', 'DB_PORT', 'DB_USERNAME', 'DB_PASSWORD', 'DB_DATABASENAME']);
	}

	static public function render($template, $array = null) {

		$app = \Slim\Slim::getInstance();
		if ($array) {
			$app->render($template, $array);
		}
		else {
			$app->render($template);
		}
	}

	static public function log($log) {
        $file = fopen($_SERVER['DOCUMENT_ROOT'] . "/../doc/log.txt","a");
        fwrite($file,preg_replace('/\s+/S', " ", $log) . "\n");
        fclose($file);
    }
    static public function delLog() {
        $file = fopen($_SERVER['DOCUMENT_ROOT'] . "/../doc/log.txt","w+");
        fclose($file);
    }

	static public function redirect($redirect, $seconds = null) {

		if (empty($seconds)) {
			$app = \Slim\Slim::getInstance();
			echo $redirect;
			$app->redirect($redirect);
		}
		else {
			header('Refresh: ' . $seconds . '; URL=' . $redirect);
		}
	}

	static public function neverExpireCookie($name, $value) {

		if (is_array($value) || is_object($value)) {
			$value = serialize($value);
		}

		setcookie($name, $value, time() + (20 * 365 * 24 * 60 * 60), "/");
	}

	// date formats
	static public function currentDatetime() {

		return date('Y-m-d H:i:s');
	}

	static public function dateFormat($date, $type = "datetime") {

		/*$array = array("gb");

		if (in_array($_COOKIE['TRANSLATION'], $array)) {
			$format = "Y.m.d";
		}
		else {
			$format = "d.m.Y";
		}*/

		$format = "d.m.Y";

		switch ($type) {
			case 'datetime':
				$format .= " H:i";
				break;

			case 'time':
				$format = "H:i";
				break;

			default:
				break;
		}

		return date($format, strtotime($date));
	}

	static public function randomString($length = 10, $type = null) {

		switch ($type) {
			case 'number':
				$type = "0123456789";
				break;
			case 'string':
				$type = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
				break;
			case 'lstring':
				$type = "abcdefghijklmnopqrstuvwxyz";
				break;
			case 'ustring':
				$type = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
				break;
			default:
				$type = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
				break;
		}

		$typeLength = strlen($type);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $type[rand(0, $typeLength - 1)];
	    }

	    return $randomString;
	}

	static public function responseError() {

		header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die();
	}

	static public function absolutePath($url) {

		return $_SERVER['DOCUMENT_ROOT'] . "/" . $url;
	}

	static public function modal(array $params, $json = false) {

		$modal = '<div class="header"><i class="warning circle icon"></i>';

		$modal .= (empty($params['title'])) ? null : $params['title'];

		$modal .= '
				<i class="close icon black"></i>
			</div>
			<div class="content">
				' . $params['message'] . '
			</div>
		';

		if ($json === true) {
			echo json_encode($modal);
			return;
		}

		echo $modal;
	}

    static public function debug() {

    	foreach (func_get_args() as $debug) {
    		if (empty($debug)) {
    			$debug = "null";
    		}

      		echo '<pre>' . var_export($debug, true) . '</pre>';
      	}
    }

   	static public function xdebug() {

   		foreach (func_get_args() as $debug) {
      		Self::debug($debug);
      	}

		exit();
	}

	static public function ucfirst($str, $encoding = "UTF-8", $lowerEnd = false) {

		$first = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding);
		$end = "";
		if ($lowerEnd) {
			$end = mb_strtolower(mb_substr($str, 1, mb_strlen($str, $encoding), $encoding), $encoding);
		}
		else {
			$end = mb_substr($str, 1, mb_strlen($str, $encoding), $encoding);
		}
		$str = $first . $end;

        return $str;
    }
}
