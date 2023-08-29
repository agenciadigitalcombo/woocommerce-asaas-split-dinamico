<?php
/**
 * Plugin Name: Taxa de Entrega no Perfil
 * Description: Adiciona um campo para inserir a taxa de entrega no perfil do usuário.
 * Version: 1.0
 * Author: Seu Nome
 */

// Função para adicionar o campo de taxa de entrega ao perfil do usuário
function taxa_entrega_field($user) {
    $taxa_entrega = get_user_meta($user->ID, 'taxa_entrega', true);
    ?>
    <h3>Taxa de Entrega</h3>
    <table class="form-table">
        <tr>
            <th><label for="taxa_entrega">Valor da Taxa de Entrega</label></th>
            <td>
                <input type="text" name="taxa_entrega" id="taxa_entrega" value="<?php echo esc_attr($taxa_entrega); ?>" />
                <p class="description">Insira o valor da taxa de entrega.</p>
            </td>
        </tr>
    </table>
    <?php
}

// Função para salvar o valor da taxa de entrega ao atualizar o perfil do usuário
function salvar_taxa_entrega($user_id) {
    if (isset($_POST['taxa_entrega'])) {
        update_user_meta($user_id, 'taxa_entrega', sanitize_text_field($_POST['taxa_entrega']));
    }
}

// Adicionar o campo de taxa de entrega no perfil do usuário
function adicionar_taxa_entrega_profile($user) {
    add_action('show_user_profile', 'taxa_entrega_field');
    add_action('edit_user_profile', 'taxa_entrega_field');
    add_action('personal_options_update', 'salvar_taxa_entrega');
    add_action('edit_user_profile_update', 'salvar_taxa_entrega');
}
add_action('admin_init', 'adicionar_taxa_entrega_profile');
