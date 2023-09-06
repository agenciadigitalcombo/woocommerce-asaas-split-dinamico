<?php

function makerSplit($order_id)
{

    $order    = new WC_Order((int)$order_id);
    $wc_order = $order->get_items();
    $id_prod = array_values($wc_order)[0]->get_product_id();

    $vendedor_id = get_post_meta($id_prod, '_wcfm_product_author', true);
    $get_payment_method = $order->get_payment_method();



    $split_prod = [];

    $lb = [
        'pix' => 'asaas-pix',
        'card' => 'asaas-credit-card',
        'boleto' => 'asaas-ticket'
    ];

    foreach (['pix', 'card', 'boleto'] as $i => $type) {
        for ($j = 1; $j <= 3; $j++) {
            $names = [
                'custom_type_' . $type . '_' . $j,
                'custom_value_' . $type . '_' . $j,
                'custom_user_' . $type . '_' . $j,
            ];
            foreach ($names as $name_var) {
                @$$name_var = esc_attr(get_user_meta($vendedor_id, $name_var, true)) ?? '';
            }
            if ($lb[$type] == $get_payment_method) {
                $split_prod[] = [
                    ${'custom_type_' . $type . '_' . $j} => ${'custom_value_' . $type . '_' . $j},
                    "walletId" => get_user_meta(intval(${'custom_user_' . $type . '_' . $j}), 'custom_wallet_id', true),
                ];
            }
        }
    }

    $split_prod = array_values(array_filter($split_prod, function ($label) {

        $walletId = $label['walletId'] ?? '';
        $fixedValue = $label['fixedValue'] ?? '';
        $percentualValue = $label['percentualValue'] ?? '';

        $isWalletId = $walletId > 0;
        $isFixedValue = $fixedValue  > 0;
        $isPercentualValue = $percentualValue  > 0;

        return $isWalletId && $isFixedValue || $isPercentualValue;
    }));

    return $split_prod;
}
