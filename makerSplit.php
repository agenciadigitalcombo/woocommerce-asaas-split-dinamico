<?php

function makerSplit($order_id)
{

    $order    = new WC_Order((int)$order_id);
    $wc_order = $order->get_items();
    $id_prod = array_values($wc_order)[0]->get_product_id();

    $campos = ["asa_split_type_", "asa_split_value_", "asa_split_wallet_id_"];

    for ($i = 1; $i <= 3; $i++) {
        foreach ($campos as $key) {
            $name = $key . $i;
            $$name = get_post_meta($id_prod, $name, true);
        }
    }

    $split_prod = [];

    for ($i = 1; $i <= 3; $i++) {
        $split_prod[] = [
            ${'asa_split_type_' . $i} => ${'asa_split_value_' . $i},
            "walletId" => ${'asa_split_wallet_id_' . $i},
        ];
    }

    $split_prod = array_values(array_filter($split_prod, function ($label) {

        $walletId = $label['walletId'] ?? '';
        $fixedValue = $label['fixedValue'] ?? '';
        $percentualValue = $label['percentualValue'] ?? '';

        $isWalletId = strlen($walletId) > 0;
        $isFixedValue = strlen($fixedValue)  > 0;
        $isPercentualValue = strlen($percentualValue)  > 0;

        return $isWalletId && $isFixedValue || $isPercentualValue;
    }));

    return $split_prod;
}

add_filters("woocommerce_asaas_payment_data", function ($payment_data, $wc_order) {
    $payment_data['split'] = makerSplit($wc_order->get_id());
    return $payment_data;
});
