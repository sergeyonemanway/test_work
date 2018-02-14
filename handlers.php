<?php

/**
 * Generate url for request form
 *
 * @return string
 */
function getTypeUrl(){
	$defaultUrl = "http://www.50.bn.ru/sale/city/flats/?sort=price&sortorder=ASC&price[from]=&price[to]=";
	return $url = (isset($_GET['type'])) ? 'http://www.50.bn.ru/sale/'.clearRequest($_GET['type']).'/?sort=price&sortorder=ASC' : $defaultUrl;
}

/**
 * Clear request
 *
 * @param $var
 *
 * @return string
 */
function clearRequest($var){
	return trim(strip_tags($var));
}

/**
 * Very primitive price check
 *
 * @return string
 */
function primitiveCheckPrice(){
	$price = isset($_GET['price']);
	return $error = (isset($price) && clearRequest($price['from']) > clearRequest($price['to']) && !empty(clearRequest($price['to'])))
		? '<div class="error">Ошибка! "Цена ОТ" должна быть < "цены ДО"</div>' : '';
}


/**
 * Generate select options types of realty
 *
 * @param $array
 * @param $object
 *
 * @return string
 */
function getTypeRealty($array, $object){
	$option = '';
	$type = (isset($_GET['type'])) ? clearRequest($_GET['type']) : '';
	foreach ($array as $i){
		$matches = [];
		$data = $object->saveHTML($i);
		$pattern = '/value=\"(.+)\"/';
		$sub = 'value="'.$type.'"';
		$check = preg_replace($pattern, $sub.' selected', $data);

		if($check){
			$option .='<option '.$check.'>'.$i->nodeValue.'</option>';
		} elseif (empty($matches)){
			$option .='<option '.$matches[0].' >'.$i->nodeValue.'</option>';
		}
	}

	//return $option;
}


/**
 * Вывод элементов option в форме
 *
 * @param $array
 *
 * @param $getName
 *
 * @return string
 * @internal param array $listOptions
 * @internal param string $selectName
 *
 */
function showOptions($array, $getName) {
	$option = '';
	foreach ($array as $key => $value) {
		if (strpos($key, 'dis') !== false) {
			$option .='<option disabled>'.$value.'</option>';
		} else {
			$attr = (isset($_GET[$getName]) && clearRequest($_GET[$getName]) === $key)
				? 'selected'
				: '';
			$option .= '<option value="'.$key.'" '.$attr.' >'.$value.'</option>';
		}
	}
	return $option;
}



/**
 * Generate table of results
 *
 * @param $array
 * @param $object
 *
 * @return string
 */
function getResult($array, $object){
	$html = '';
	foreach ($array as $i){
		$html = $object->saveHTML($i);
	}
	return $html;
}


/**
 * Generate select options rooms
 *
 * @param $array
 * @param $requestName
 *
 * @internal param array $listOptions
 * @internal param string $selectName
 *
 * @return string
 */
function getOptionRooms($array, $requestName) {
	$option = '';
	foreach ($array as $key => $value) {
		$selected = (!empty($_GET[$requestName]) && in_array($key, $_GET[$requestName])) ? 'selected' : '';
		$option .= '<option value="'.$key.'"'.$selected.' >'.$value .'</option>';
	}
	return $option;
}
