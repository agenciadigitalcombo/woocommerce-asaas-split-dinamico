<?php

function minha_funcao_de_acao_quando_processando($order_id)
{
    $order    = new WC_Order((int)$order_id);
    $wc_order = $order->get_items();
    $id_prod = array_values($wc_order)[0]->get_product_id();
    $vendedor_id = get_post_meta($id_prod, '_wcfm_product_author', true);
    $vendedor_wallet_id = get_user_meta(intval($vendedor_id), 'custom_wallet_id', true);
    if (strlen($vendedor_wallet_id) > 7) {
        $vendedor_api_key = get_user_meta(intval($vendedor_id), 'asaas_api_key', true);
        $taxa = get_user_meta(intval($vendedor_id), 'taxa_entrega', true);
        $custom_phone = get_user_meta(intval($vendedor_id), 'custom_phone', true);
        $custom_nome = get_user_meta(intval($vendedor_id), 'custom_nome', true);
        $phone_loja = "31993063616";
        $loja_wallet_id = get_user_meta(10, 'custom_wallet_id', true);
        $saldo = BalanceAsaas($vendedor_api_key);
        $saldo_baixo = 35;
        $saldo_print = number_format($saldo, 2, '.', ',');

        if (intval($taxa) > 0) {
            if ($saldo <= $saldo_baixo) {
                SendWhats($custom_phone, "
PEDIBANK
SALDO BAIXO ⛽👀
        
Olá {$custom_nome}, 

Seu saldo no PEDIBANK é de R$ {$saldo_print}, não fique sem entregas, faça uma recarga agora mesmo!🛵
                ");
                SendWhats($phone_loja, "
PEDIBANK
SALDO BAIXO ⛽👀
Loja {$custom_nome}, saldo baixo R$ {$saldo_print}.
                ");
            }
            if ($saldo < $taxa) {
                SendWhats($custom_phone, "
PEDIBANK 
SEM SALDO🥴💰👎
        
Olá {$custom_nome}, 

Você está Sem Saldo suficiente no PEDIBANK. Para novas entregas, recarregue agora mesmo e não perca vendas.🛵
                ");
                SendWhats($phone_loja, "
PEDIBANK 
SEM SALDO🥴💰👎
Loja {$custom_nome}, está sem Saldo
                ");
            }
            if ($saldo >= $taxa) {
                $res = TransfeAsaas(
                    $taxa,
                    $vendedor_api_key,
                    $loja_wallet_id
                );
            }
        }

    }
}
add_action('woocommerce_order_status_processing', 'minha_funcao_de_acao_quando_processando', 10, 1);
