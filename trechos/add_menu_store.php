<?php

add_filter('wcfm_menus','ws_get_wcfm_menus_b', 30, 1);
function ws_get_wcfm_menus_b($wcfm_menus) {
	$wcfm_menus['ws-contract-1'] = array(
		'label' => 'carteira',
		'url' => 'http://carteira.digitalcombo.com.br/public/',
		'icon' => 'dashicons-money'
	);
	return $wcfm_menus;
}