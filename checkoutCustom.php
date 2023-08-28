<?php
// Adicionar o campo personalizado ao checkout
add_action('woocommerce_after_order_notes', 'campo_com_opcao_selecionada_do_produto_checkout');

function campo_com_opcao_selecionada_do_produto_checkout($checkout) {
    // Obtém o carrinho 1
    $cart = WC()->cart;

    // Verifica se há itens no carrinho
    if ($cart->is_empty()) {
        return;
    }

    // Obtém o primeiro item do carrinho
    $cart_items = $cart->get_cart_contents();
    $cart_item = reset($cart_items);

    // Obtém o ID do produto
    $product_id = $cart_item['product_id'];

    // Busca o valor do metadado
    $opcao_selecionada = get_post_meta($product_id, '_opcao_selecionada', true);

    echo '<div id="campo_com_opcao_selecionada_checkout">
        <input type="text" name="campo_com_opcao_selecionada" value="Opção Selecionada: ' . esc_attr($opcao_selecionada) . '" />
    </div>';
}

// Validar e salvar o valor do campo personalizado
add_action('woocommerce_checkout_process', 'validar_campo_com_opcao_selecionada');

function validar_campo_com_opcao_selecionada() {
    if (empty($_POST['campo_com_opcao_selecionada'])) {
        wc_add_notice(__('Por favor, preencha o campo com a opção selecionada.'), 'error');
    }
}

add_action('woocommerce_checkout_update_order_meta', 'salvar_campo_com_opcao_selecionada');

function salvar_campo_com_opcao_selecionada($order_id) {
    if (!empty($_POST['campo_com_opcao_selecionada'])) {
        update_post_meta($order_id, 'Campo com Opção Selecionada', sanitize_text_field($_POST['campo_com_opcao_selecionada']));
    }
}
?>