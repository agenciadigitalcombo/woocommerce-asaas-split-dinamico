<?php


function adicionar_custom_meta_box($user)
{
    $users = get_users();

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

    $defaults_percentes = [
        'pix' => [94, 6, 0],
        'card' => [97, 3, 0],
        'boleto' => [97, 3, 0],
    ];


    $ID = $user->ID;
    foreach (['pix', 'card', 'boleto'] as $i => $type) {
        for ($j = 1; $j <= 3; $j++) {
            $names = [
                'custom_type_' . $type . '_' . $j,
                'custom_value_' . $type . '_' . $j,
                'custom_user_' . $type . '_' . $j,
            ];
            foreach ($names as $index => $name_var) {
                @$$name_var = $_POST[$name_var] ?? esc_attr(get_user_meta($user->ID, $name_var, true)) ?? null;
                if ($index == 1) {
                    $$name_var = !empty($$name_var) ? $$name_var : $defaults_percentes[$type][$j - 1];
                }
                if ($index == 2 && $j == 1) {
                    $$name_var = !empty($$name_var) ? $$name_var : $_REQUEST['user_id'];
                }
                if ($index == 2 && $j == 2) {
                    $$name_var = 1; // ID da plataforma
                }
            }
        }
    }

    foreach (['pix', 'card', 'boleto'] as $i => $type) {

?>
        <br><br>
        <h3>
            <?php echo $split_titles[$i]; ?>
        </h3>
        <div class="custom-meta-box">
            <ul class="custom-meta-tabs">
                <?php for ($j = 0; $j <= 2; $j++) : ?>
                    <li <?php if ($j === 1)
                            echo 'class="active"'; ?>><?php echo $split_tabs[$j]; ?></li>
                <?php endfor; ?>
            </ul>

            <div class="custom-meta-content">
                <?php for ($j = 1; $j <= 3; $j++) : ?>
                    <div class="custom-meta-tab<?php if ($j === 1) echo ' active'; ?>">
                        <label for="custom_type_<?php echo $type ?>_<?php echo $j; ?>">Tipo:</label> <br>
                        <select id="custom_type_<?php echo $type ?>_<?php echo $j; ?>" name="custom_type_<?php echo $type ?>_<?php echo $j; ?>">
                            <option value="percentualValue" <?php echo ${'custom_type_' . $type . '_' . $j} == "percentualValue" ? "SELECTED" : ""; ?>>Porcentagem</option>
                            <option value="fixedValue" <?php echo ${'custom_type_' . $type . '_' . $j} == "fixedValue" ? "SELECTED" : ""; ?>>Valor Fixo</option>
                        </select>

                        <br> <br>
                        <label for="custom_value_<?php echo $type ?>_<?php echo $j; ?>">Valor:</label> <br>
                        <input type="text" id="custom_value_<?php echo $type ?>_<?php echo $j; ?>" name="custom_value_<?php echo $type ?>_<?php echo $j; ?>" value="<?php echo ${'custom_value_' . $type . '_' . $j}; ?>">

                        <br> <br>
                        <label for="custom_user_<?php echo $type ?>_<?php echo $j; ?>">Selecionar Usuário:</label> <br>
                        <select id="custom_user_<?php echo $type ?>_<?php echo $j; ?>" name="custom_user_<?php echo $type ?>_<?php echo $j; ?>">
                            <option value="">Selecione um usuário</option>
                            <?php foreach ($users as $user_option) : ?>
                                <option value="<?php echo esc_attr($user_option->ID); ?>" <?php echo ${'custom_user_' . $type . '_' . $j} == $user_option->ID ? "SELECTED" : ""; ?>>
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

function adicionar_custom_meta_box_profile()
{
    add_action('show_user_profile', 'adicionar_custom_meta_box');
    add_action('edit_user_profile', 'adicionar_custom_meta_box');
}
add_action('admin_init', 'adicionar_custom_meta_box_profile');

function salvar_campos_perfil_usuario($user_id)
{
    if (current_user_can('edit_user', $user_id)) {

        foreach (['pix', 'card', 'boleto'] as $i => $type) {
            for ($j = 1; $j <= 3; $j++) {
                $names = [
                    'custom_type_' . $type . '_' . $j,
                    'custom_value_' . $type . '_' . $j,
                    'custom_user_' . $type . '_' . $j,
                ];
                foreach ($names as $name_var) {
                    if (isset($_POST[$name_var])) {
                        update_user_meta($user_id, $name_var, sanitize_text_field($_POST[$name_var]));
                    }
                }
            }
        }
    }
}

add_action('personal_options_update', 'salvar_campos_perfil_usuario');
add_action('edit_user_profile_update', 'salvar_campos_perfil_usuario');
