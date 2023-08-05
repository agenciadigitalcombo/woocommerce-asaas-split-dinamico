<?php

function makerSplit($order_id)
{

    $order    = new WC_Order((int)$order_id);
    $wc_order = $order->get_items();

    $id_prod = array_values($wc_order)[0]->get_product_id();
    $custom_percent_1 = get_post_meta($id_prod, 'custom_percent_1', true);
    $custom_user_1 = get_post_meta($id_prod, 'custom_user_1', true);
    $custom_percent_2 = get_post_meta($id_prod, 'custom_percent_2', true);
    $custom_user_2 = get_post_meta($id_prod, 'custom_user_2', true);
    $custom_percent_3 = get_post_meta($id_prod, 'custom_percent_3', true);
    $custom_user_3 = get_post_meta($id_prod, 'custom_user_3', true);

    $split_prod =  [
        [
            "percentualValue" => $custom_percent_1,
            "walletId" => get_user_meta($custom_user_1, 'custom_wallet_id', true),
        ],
        [
            "percentualValue" => $custom_percent_2,
            "walletId" => get_user_meta($custom_user_2, 'custom_wallet_id', true),
        ],
        [
            "percentualValue" => $custom_percent_3,
            "walletId" => get_user_meta($custom_user_3, 'custom_wallet_id', true),
        ]
    ];   

    $split_prod = array_values( array_filter($split_prod, function ($label) {   
        
        $walletId = $label['walletId'] ?? '';
        $fixedValue = $label['fixedValue'] ?? '';
        $percentualValue = $label['percentualValue'] ?? '';
        
        $isWalletId = strlen($walletId) > 0;
        $isFixedValue = strlen($fixedValue)  > 0;
        $isPercentualValue = strlen($percentualValue)  > 0;
        
        return $isWalletId && $isFixedValue || $isPercentualValue ;
    }));

    return $split_prod;

}


function split_code($atts)
{
    $attributes = shortcode_atts(array(
        'id' => '0'
    ), $atts);

    return esc_html(json_encode(makerSplit($attributes['id'])));
}

add_action('woocommerce_loaded', function () {

    add_shortcode('split', 'split_code');
});
