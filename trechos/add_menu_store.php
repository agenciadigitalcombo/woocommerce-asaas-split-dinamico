<?php

add_filter('wcfm_menus','ws_get_wcfm_menus_b', 30, 1);
function ws_get_wcfm_menus_b($wcfm_menus) {
	$wcfm_menus['ws-contract-6'] = array(
		'label' => 'Carteira',
		'url' => 'https://carteira.pedipag.com.br/public',
		'icon' => 'fa-wallet'
	);
	return $wcfm_menus;
}