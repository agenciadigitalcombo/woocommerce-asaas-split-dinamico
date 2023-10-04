<?php


add_action('woocommerce_order_status_processing', 'webhook_pagamento_whats', 10, 1);

function webhook_pagamento_whats($order_id)
{
    $order = wc_get_order($order_id);
    $wc_order = $order->get_items();
    $id_prod = array_values($wc_order)[0]->get_product_id();
    $vendedor_id = wcfm_get_vendor_id_by_post($id_prod);
    $vendor_store_name = get_user_meta(intval($vendedor_id), 'store_name', true);
    $vendor_phone = get_user_meta(intval($vendedor_id), 'custom_phone', true);
    $vendor_email = get_user_meta(intval($vendedor_id), 'custom_mail', true);
    $webhook_url = 'https://n8n.digitalcombo.com.br/webhook/310ac435-f90f-4883-9ad6-121e1289c901';
    $product_names = [];
    foreach ($order->get_items() as $item) {
        $product_names[] = $item->get_name();
    }
    $data_to_send = array(
        'order_id' => $order->get_id(),
        'customer_name' => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(),
        'customer_email' => $order->get_billing_email(),
        'customer_phone' => $order->get_billing_phone(),
        'product_names' => implode(',', $product_names),
        'order_total' => $order->get_total(),
        'vendor' => [
            "id" => intval($vendedor_id),
            "name" => $vendor_store_name,
            "phone" => $vendor_phone,
            "email" => $vendor_email,
        ]
    );
    $request_args = array(
        'body' => json_encode($data_to_send),
        'headers' => array(
            'Content-Type' => 'application/json',
        ),
    );
    $response = wp_remote_post($webhook_url, $request_args);
    if (is_wp_error($response)) {
        error_log('fail send message new order: ' . $response->get_error_message());
    } else {
        error_log('Webhook enviado com sucesso.');
    }
}
