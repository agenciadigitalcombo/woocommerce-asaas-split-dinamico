<?php

function minha_funcao_de_acao_quando_processando($order_id)
{

    $order    = new WC_Order((int)$order_id);
    $wc_order = $order->get_items();
    $id_prod = array_values($wc_order)[0]->get_product_id();

    $vendedor_id = get_post_meta($id_prod, '_opcao_selecionada', true);

    $vendedor_wallet_id = get_user_meta(intval($vendedor_id), 'custom_wallet_id', true);
    $vendedor_api_key = get_user_meta(intval($vendedor_id), 'asaas_api_key', true);
    $taxa = get_user_meta(intval($vendedor_id), 'taxa_entrega', true);

    $loja_wallet_id = GetWalletID();

    $balance = BalanceAsaas($vendedor_api_key);
    $saldo_minimo = 16;

    if ($balance < $saldo_minimo) {
        SendWhats('82999776698', "saldo atual insuficiente {$balance}");
    }

    if ($saldo_minimo >= $taxa) {
        TransfeAsaas(
            $taxa,
            $vendedor_wallet_id,
            $loja_wallet_id
        );
    }

    file_put_contents(__DIR__ . "/log-alter-status.log", date('Y-m-d H:i:s') . " -> order: $order_id \r\n", FILE_APPEND);
}

add_action('woocommerce_order_status_processing', 'minha_funcao_de_acao_quando_processando', 10, 1);
