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
    $custom_phone = get_user_meta(intval($vendedor_id), 'custom_phone', true);
    $custom_nome = get_user_meta(intval($vendedor_id), 'custom_nome', true);

    $loja_wallet_id = GetWalletID();

    $saldo = BalanceAsaas($vendedor_api_key);
    $saldo_baixo = 35;
    $saldo_print = number_format($saldo, 2, '.', ',');

    $phone_loja = "82999776698";

    if ($saldo <= $saldo_baixo) {
        SendWhats($custom_phone, "
PEDIBANK
Saldo Baixo ⛽👀        
Olá {$custom_nome}, seu saldo no Pedibank é de R$ {$saldo_print}, não fique sem entregas, faça uma recarga agora mesmo!
        ");

        SendWhats($phone_loja, "
PEDIBANK
Saldo Baixo ⛽👀
Loja {$custom_nome}, saldo baixo R$ {$saldo_print}.
        ");
    }

    if ($saldo < $taxa) {
        SendWhats($custom_phone, "
PEDIBANK 
Sem Saldo🥴💰
Olá {$custom_nome}, você está Sem Saldo suficiente no Pedibank. Para novas entregas, recarregue agora mesmo e nao perca vendas.
        ");
        SendWhats($phone_loja, "
PEDIBANK 
Sem Saldo🥴💰
Loja {$custom_nome}, está sem Saldo
        ");
    }

    if ($saldo >= $taxa) {
        TransfeAsaas(
            $taxa,
            $vendedor_wallet_id,
            $loja_wallet_id
        );
    }
}

add_action('woocommerce_order_status_processing', 'minha_funcao_de_acao_quando_processando', 10, 1);
