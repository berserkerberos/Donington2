<?php

class UtilsService {

	/**
	 * Devuelve el tiempo en milisegundos
	 * @return float
	 */
	public static function microtimeFloat() {
		list($useg, $seg) = explode(" ", microtime());
		return ((float) $useg + (float) $seg);
	}

	/**
	 * Recorre un array y devuelve todas las claves del mismo que contengan un array como value
	 * @param array $arr
	 * @return array o FALSE si no se encontró ningun array
	 */
	public static function findArrayInArray(array $arr) {
		$result = false;
		foreach ($arr as $key => $val) {
			if (is_array($val)) {
				$result[] = $key;
			}
		}
		return $result;
	}

	/**
	 * Devuelve un string truncado al tamaño especificado
	 * @param string $string
	 * @param int $len
	 * @return string
	 */
	public static function shortenText($string, $len) {
		if (strlen($string) > $len) {
			return substr($string, 0, $len) . '...';
		} else {
			return $string;
		}
	}



}

?>
