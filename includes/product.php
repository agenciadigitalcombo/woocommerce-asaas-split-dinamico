<?php

function adicionar_metabox_produto()
{
    add_meta_box(
        'opcoes_produto',
        'Vendedor do Produto',
        'renderizar_metabox_produto',
        'product',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'adicionar_metabox_produto');


function renderizar_metabox_produto($post)
{

    $users = get_users();
    $users_with_account = [];
    foreach ($users as $u) {
        $custom_wallet_id = esc_attr(get_user_meta($u->ID, 'custom_wallet_id', true)) ?? '';
        if (strlen($custom_wallet_id) > 7) {
            $users_with_account[] = $u;
        }
    }
    $opcao_selecionada = get_post_meta($post->ID, '_wcfm_product_author', true);
    echo '
    <label for="user_select">Selecionar Usuário:</label> <br>
    <select name="opcao_selecionada" id="opcao_selecionada" disabled>
        <option value="" ' . selected($opcao_selecionada, '', false) . '>Selecione um usuário</option>';

    foreach ($users_with_account as $user) {
        echo '<option value="' . esc_attr($user->ID) . '" ' . selected($opcao_selecionada, $user->ID, false) . '>' . esc_html($user->user_login) . '</option>';
    }

    echo '</select>';
}

function salvar_dados_metabox($order_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $order_id)) return;

    if (isset($_POST['opcao_selecionada'])) {
        update_post_meta($order_id, '_opcao_selecionada', sanitize_text_field($_POST['opcao_selecionada']));
    }
}
add_action('save_post_product', 'salvar_dados_metabox');
