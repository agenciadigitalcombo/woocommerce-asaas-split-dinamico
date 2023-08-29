<?php
/*
Plugin Name: Custom User Profile Fields
Description: Adiciona campos personalizados à página de perfil do usuário.
Version: 1.0
Author: Seu Nome
*/

// Adicione o metabox de campos personalizados ao perfil do usuário
function adicionar_custom_meta_box($user)
{
    $users = get_users(); // Você precisa definir $users de acordo com a lógica desejada

    $userDefault = array(
        'id' => 'default_id',
        'name' => 'Default User',
        'percent' => '50'
    );

    $split_titles = array(
        'Split PIX',
        'Split Crédito',
        'Split Boleto'
    );

    $split_tabs = array(
        'Divisão 1',
        'Divisão 2',
        'Divisão 3'
    );

    for ($i = 1; $i <= 3; $i++) {
        $custom_value = esc_attr(get_user_meta($user->ID, "custom_value_$i", true)) ?? '';
        $custom_user = esc_attr(get_user_meta($user->ID, "custom_user_$i", true)) ?? '';

        ?>
        <br><br>
        <h3>
            <?php echo $split_titles[$i - 1]; ?>
        </h3>
        <div class="custom-meta-box">
            <ul class="custom-meta-tabs">
                <?php for ($j = 1; $j <= 3; $j++): ?>
                    <li <?php if ($j === 1)
                        echo 'class="active"'; ?>><?php echo $split_tabs[$j - 1]; ?></li>
                <?php endfor; ?>
            </ul>

            <div class="custom-meta-content">
                <?php for ($j = 1; $j <= 3; $j++): ?>
                    <div class="custom-meta-tab<?php if ($j === 1)
                        echo ' active'; ?>">
                        <label for="custom_type_<?php echo $j; ?>">Tipo:</label> <br>
                        <select id="custom_type_<?php echo $j; ?>" name="custom_type_<?php echo $j; ?>">
                            <option value="porcentagem">Porcentagem</option>
                            <option value="valor_fixo">Valor Fixo</option>
                        </select>

                        <br> <br>
                        <label for="custom_value_<?php echo $j; ?>">Valor:</label> <br>
                        <input type="number" id="custom_value_<?php echo $j; ?>" name="custom_value_<?php echo $j; ?>"
                            value="<?php echo $custom_value; ?>">

                        <br> <br>
                        <label for="custom_user_<?php echo $j; ?>">Selecionar Usuário:</label> <br>
                        <select id="custom_user_<?php echo $j; ?>" name="custom_user_<?php echo $j; ?>">
                            <option value="">Selecione um usuário</option>
                            <option value="<?php echo $userDefault['id']; ?>" <?php if ($custom_user === $userDefault['id'])
                                   echo ' SELECTED'; ?>>
                                <?php echo $userDefault['name']; ?>
                            </option>
                            <?php foreach ($users as $user_option): ?>
                                <option value="<?php echo esc_attr($user_option->ID); ?>" <?php if ($custom_user === $user_option->ID)
                                       echo ' SELECTED'; ?>>
                                    <?php echo esc_html($user_option->user_login); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
        <?php
    }
}

// Adicione o metabox na página de perfil do usuário
function adicionar_custom_meta_box_profile()
{
    add_action('show_user_profile', 'adicionar_custom_meta_box');
    add_action('edit_user_profile', 'adicionar_custom_meta_box');
}
add_action('admin_init', 'adicionar_custom_meta_box_profile');

// Salvar campos personalizados ao atualizar o perfil do usuário
function salvar_campos_perfil_usuario($user_id)
{
    if (current_user_can('edit_user', $user_id)) {
        for ($i = 1; $i <= 3; $i++) {
            if (isset($_POST["custom_value_$i"])) {
                update_user_meta($user_id, "custom_value_$i", sanitize_text_field($_POST["custom_value_$i"]));
            }
            if (isset($_POST["custom_user_$i"])) {
                update_user_meta($user_id, "custom_user_$i", sanitize_text_field($_POST["custom_user_$i"]));
            }
        }
    }
}
add_action('personal_options_update', 'salvar_campos_perfil_usuario');
add_action('edit_user_profile_update', 'salvar_campos_perfil_usuario');
?>