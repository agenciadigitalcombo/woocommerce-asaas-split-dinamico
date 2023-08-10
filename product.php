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

    $campos = ["asa_split_type_", "asa_split_value_", "asa_split_wallet_id_"];

    for ($i = 1; $i <= 3; $i++) {
        foreach ($campos as $key) {
            $name = $key . $i;
            $$name = get_post_meta($post->ID, $name, true);
        }
    }


?>
    <div class="custom-meta-box">

        <ul class="custom-meta-tabs">
            <li class="active">Divisão 1</li>
            <li>Divisão 2</li>
            <li>Divisão 3</li>
        </ul>
        <?php for ($i = 1; $i <= 3; $i++) { ?>
            <div class="custom-meta-content">
                <div class="custom-meta-tab <?php echo $i == "1" ? "active" : "" ?>">

                    <label for="asa_split_type_<?php echo $i ?>">Tipo:</label> <br>
                    <select id="asa_split_type_<?php echo $i ?>" name="asa_split_type_<?php echo $i ?>">
                        <option value="percentualValue" <?php echo ${"asa_split_type_" . $i} == "percentualValue" ? "selected" : ""  ?>>Porcentagem</option>
                        <option value="fixedValue" <?php echo ${"asa_split_type_" . $i} == "fixedValue" ? "selected" : ""  ?>>Valor Fixo</option>
                    </select>
                    <br> <br>

                    <label for="asa_split_value_<?php echo $i ?>">Valor da divisão:</label> <br>
                    <input type="text" id="asa_split_value_<?php echo $i ?>" name="asa_split_value_<?php echo $i ?>" value="<?php echo ${"asa_split_value_" . $i} ?>">
                    <br> <br>

                    <label for="asa_split_wallet_id_<?php echo $i ?>">Wallet ID:</label> <br>
                    <input type="text" id="asa_split_wallet_id_<?php echo $i ?>" name="asa_split_wallet_id_<?php echo $i ?>" value="<?php echo ${"asa_split_wallet_id_" . $i} ?>">
                    <br> <br>

                </div>

            </div>
        <?php } ?>
    </div>

<?php
}


function salvar_meta_box_produto($post_id)
{
    $campos = ["asa_split_type_", "asa_split_value_", "asa_split_wallet_id_"];
    for ($i = 1; $i <= 3; $i++) {
        foreach ($campos as $key) {
            $name = $key . $i;
            if (isset($_POST[$name])) {
                update_post_meta($post_id, $name, sanitize_text_field($_POST[$name]));
            }
        }
    }
}
add_action('save_post_product', 'salvar_meta_box_produto');


function enqueue_admin_custom_styles()
{
    wp_enqueue_style('split-css', plugin_dir_url(__FILE__) . 'split-css.css');
    wp_enqueue_script('split-script', plugin_dir_url(__FILE__) . 'split-script.js', array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'enqueue_admin_custom_styles');
