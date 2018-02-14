<?php

/**
 * Generate url for request form
 *
 * @return string
 */
function getTypeUrl(){
	$defaultUrl = "http://www.50.bn.ru/sale/city/flats/?sort=price_for_sort&sortorder=ASC";
	return $url = (isset($_GET['type'])) ? "http://www.50.bn.ru/sale/{$_GET['type']}/?sort=price_for_sort&sortorder=ASC" : $defaultUrl;
}

/**
 * Very primitive price check
 *
 * @return string
 */
function primitiveCheckPrice(){
	$price = $_GET['price'];
	return $error = (isset($price) && $price['from'] > $price['to'] && !empty($price['to']))
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
	foreach ($array as $i){
		$attr = '';
		$data = $object->saveHTML($i);
		$pattern = '/value=\"(.+)\"/';
		$sub = 'value="'.$_GET['type'].'"';
		preg_match_all($pattern, $data, $matches);
		if($matches[0][0] == $sub){
			$attr = 'selected';
		} elseif (empty($matches[0][0])){
			$attr = 'disabled';
		}
		$option .='<option '.$matches[0][0].' '.$attr.'>'.$i->nodeValue.'</option>';
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
