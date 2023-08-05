<?php

function adicionar_meta_box_produto()
{
    add_meta_box(
        'split_vendedor',
        'Divisão de Pagamento',
        'exibir_meta_box_produto',
        'product',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'adicionar_meta_box_produto');


function exibir_meta_box_produto($post)
{

    $users = get_users();

    $users_witch_account = [];
    foreach($users as $u) {
        $custom_wallet_id =  esc_attr(get_user_meta($u->ID, 'custom_wallet_id', true)) ?? '';
        if(strlen($custom_wallet_id) > 7) {
            $users_witch_account[] = $u;
        }
    }
    
    $users = $users_witch_account;

    $custom_percent_1 = get_post_meta($post->ID, 'custom_percent_1', true);
    $custom_user_1 = get_post_meta($post->ID, 'custom_user_1', true);

    $custom_percent_2 = get_post_meta($post->ID, 'custom_percent_2', true);
    $custom_user_2 = get_post_meta($post->ID, 'custom_user_2', true);


    $custom_percent_3 = get_post_meta($post->ID, 'custom_percent_3', true);
    $custom_user_3 = get_post_meta($post->ID, 'custom_user_3', true);


    $userDefault = [
        "name"=> "Usuário Padrão",
        "id" => "40",
        "percent" => 90
    ];



?>
    <div class="custom-meta-box">

        <ul class="custom-meta-tabs">
            <li class="active">Divisão 1</li>
            <li>Divisão 2</li>
            <li>Divisão 3</li>
        </ul>

        <div class="custom-meta-content">
            <div class="custom-meta-tab active">
                <label for="custom_percent_1">Porcentagem:</label> <br>
                                <input type="number" id="custom_percent_1" name="custom_percent_1" value="<?php echo strlen( $custom_percent_1 ) > 0 ? $custom_percent_1 : $userDefault['percent'] ?>">

                <br> <br>
                <label for="user_select">Selecionar Usuário:</label> <br>
                <select id="custom_user_1" name="custom_user_1">
                    <option value="">Selecione um usuário</option>
                    <option value="<?php echo $userDefault['id'] ?>" SELECTED>
                        <?php echo $userDefault['name'] ?>
                    </option>
                    <?php foreach ($users as $user) : ?>
                        <option value="<?php echo esc_attr($user->ID); ?>" >
                            <?php echo esc_html($user->user_login); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="custom-meta-tab">
                <label for="custom_percent_2">Porcentagem:</label> <br>
                <input type="number" id="custom_percent_2" name="custom_percent_2" value="<?php echo esc_attr($custom_percent_2); ?>">
                <br> <br>
                <label for="user_select">Selecionar Usuário:</label> <br>
                <select id="custom_user_2" name="custom_user_2">
                    <option value="">Selecione um usuário</option>
                    <?php foreach ($users as $user) : ?>
                        <option value="<?php echo esc_attr($user->ID); ?>" <?php echo esc_attr($user->ID) == $custom_user_2 ? "SELECTED" : ""; ?>>
                            <?php echo esc_html($user->user_login); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="custom-meta-tab">
                <label for="custom_percent_3">Porcentagem:</label> <br>
                <input type="number" id="custom_percent_3" name="custom_percent_3" value="<?php echo esc_attr($custom_percent_3); ?>">
                <br> <br>
                <label for="user_select">Selecionar Usuário:</label> <br>
                <select id="custom_user_3" name="custom_user_3">
                    <option value="">Selecione um usuário</option>
                    <?php foreach ($users as $user) : ?>
                        <option value="<?php echo esc_attr($user->ID); ?>" <?php echo esc_attr($user->ID) == $custom_user_3 ? "SELECTED" : ""; ?>>
                            <?php echo esc_html($user->user_login); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    
<?php
}


function salvar_meta_box_produto($post_id)
{
    if (isset($_POST['custom_percent_1'])) {
        update_post_meta($post_id, 'custom_percent_1', sanitize_text_field($_POST['custom_percent_1']));
    }
    if (isset($_POST['custom_user_1'])) {
        update_post_meta($post_id, 'custom_user_1', sanitize_text_field($_POST['custom_user_1']));
    }

    if (isset($_POST['custom_percent_2'])) {
        update_post_meta($post_id, 'custom_percent_2', sanitize_text_field($_POST['custom_percent_2']));
    }
    if (isset($_POST['custom_user_2'])) {
        update_post_meta($post_id, 'custom_user_2', sanitize_text_field($_POST['custom_user_2']));
    }

    if (isset($_POST['custom_percent_3'])) {
        update_post_meta($post_id, 'custom_percent_3', sanitize_text_field($_POST['custom_percent_3']));
    }
    if (isset($_POST['custom_user_3'])) {
        update_post_meta($post_id, 'custom_user_3', sanitize_text_field($_POST['custom_user_3']));
    }
}

add_action('save_post_product', 'salvar_meta_box_produto');


function enqueue_admin_custom_styles()
{
    wp_enqueue_style('split-css', plugin_dir_url(__FILE__) . 'split-css.css');
    wp_enqueue_script('split-script', plugin_dir_url(__FILE__) . 'split-script.js', array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'enqueue_admin_custom_styles');
