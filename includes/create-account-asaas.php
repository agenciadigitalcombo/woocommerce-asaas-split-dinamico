<?php

function custom_add_user_field($user)
{

    @$custom_wallet_id = $_POST['custom_wallet_id'] ?? esc_attr(get_user_meta($user->ID, 'custom_wallet_id', true)) ?? '';
    @$cus_tipo_conta = $_POST['cus_tipo_conta'] ?? esc_attr(get_user_meta($user->ID, 'cus_tipo_conta', true)) ?? '';
    @$cus_tipo_empresa = $_POST['cus_tipo_empresa'] ?? esc_attr(get_user_meta($user->ID, 'cus_tipo_empresa', true)) ?? '';
    @$custom_nascimento = $_POST['custom_nascimento'] ?? esc_attr(get_user_meta($user->ID, 'custom_nascimento', true)) ?? '';
    @$custom_nome = $_POST['custom_nome'] ?? esc_attr(get_user_meta($user->ID, 'custom_nome', true)) ?? '';
    @$custom_CPF = $_POST['custom_CPF'] ?? esc_attr(get_user_meta($user->ID, 'custom_CPF', true)) ?? '';
    @$custom_CNPJ = $_POST['custom_CNPJ'] ?? esc_attr(get_user_meta($user->ID, 'custom_CNPJ', true)) ?? '';
    @$custom_mail = $_POST['custom_mail'] ?? esc_attr(get_user_meta($user->ID, 'custom_mail', true)) ?? '';
    @$custom_phone = $_POST['custom_phone'] ?? esc_attr(get_user_meta($user->ID, 'custom_phone', true)) ?? '';
    @$custom_zip_code = $_POST['custom_zip_code'] ?? esc_attr(get_user_meta($user->ID, 'custom_zip_code', true)) ?? '';
    @$custom_address = $_POST['custom_address'] ?? esc_attr(get_user_meta($user->ID, 'custom_address', true)) ?? '';
    @$custom_address_number = esc_attr(get_user_meta($user->ID, 'custom_address_number', true)) ?? $_REQUEST['custom_address_number'] ?? '';
    @$custom_bairro = $_POST['custom_bairro'] ?? esc_attr(get_user_meta($user->ID, 'custom_bairro', true)) ?? '';

    @$account = $_POST['account'] ?? esc_attr(get_user_meta($user->ID, 'account', true)) ?? '';
    @$accountDigit = $_POST['accountDigit'] ?? esc_attr(get_user_meta($user->ID, 'accountDigit', true)) ?? '';
    @$accountName = $_POST['accountName'] ?? esc_attr(get_user_meta($user->ID, 'accountName', true)) ?? '';
    @$agency = $_POST['agency'] ?? esc_attr(get_user_meta($user->ID, 'agency', true)) ?? '';
    @$bank = $_POST['bank'] ?? esc_attr(get_user_meta($user->ID, 'bank', true)) ?? '';
    @$bankAccountType = $_POST['bankAccountType'] ?? esc_attr(get_user_meta($user->ID, 'bankAccountType', true)) ?? '';

?>
    <h2>Informações Adicionais Asaas</h2>
    <table class="form-table">
        <tr>
            <th><label>ASAAS WalletId</label></th>
            <td>
                <input type="text" name="custom_wallet_id" value="<?php echo $custom_wallet_id ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label>Conta Tipo</label></th>
            <td>
                <select class="regular-text js-type-person" name="cus_tipo_conta" onchange="typePerson()">
                    <option value="FISICA">Pessoas Física</option>
                    <option value="JURIDICA">Jurídica</option>
                </select>
            </td>
        </tr>
        <tr class="js-type-company" hidden>
            <th><label>Tipo de empresa</label></th>
            <td>
                <select class="regular-text" name="cus_tipo_empresa">
                    <option value="MEI">Micro Empreendedor Individual</option>
                    <option value="LIMITED">Empresa Limitada</option>
                    <option value="INDIVIDUAL">Empresa Individual</option>
                    <option value="ASSOCIATION">Associação</option>
                </select>
            </td>
        </tr>
        <tr class="js-nascimento">
            <th><label>Data de Nascimento</label></th>
            <td>
                <input type="date" name="custom_nascimento" value="<?php echo $custom_nascimento ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label>Nome</label></th>
            <td>
                <input type="text" name="custom_nome" value="<?php echo $custom_nome ?>" class="regular-text" />
            </td>
        </tr>
        <tr class="js-cpf">
            <th><label>CPF</label></th>
            <td>
                <input type="text" name="custom_CPF" value="<?php echo $custom_CPF ?>" class="regular-text" />
            </td>
        </tr>
        <tr class="js-cnpj" hidden>
            <th><label>CNPJ</label></th>
            <td>
                <input type="text" name="custom_CNPJ" value="<?php echo $custom_CNPJ ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label>Email</label></th>
            <td>
                <input type="text" name="custom_mail" value="<?php echo $custom_mail ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label>Celular</label></th>
            <td>
                <input type="text" name="custom_phone" value="<?php echo $custom_phone ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label>CEP</label></th>
            <td>
                <input type="text" name="custom_zip_code" value="<?php echo $custom_zip_code ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label>Endereço</label></th>
            <td>
                <input type="text" name="custom_address" value="<?php echo $custom_address ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label>Numero</label></th>
            <td>
                <input type="text" name="custom_address_number" value="<?php echo $custom_address_number ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label>Bairro</label></th>
            <td>
                <input type="text" name="custom_bairro" value="<?php echo $custom_bairro ?>" class="regular-text" />
            </td>
        </tr>

    </table>

    <h2>Informações Bancaria</h2>
    <table class="form-table">
        <tr>
            <th><label>Conta</label></th>
            <td>
                <input type="text" name="account" value="<?php echo $account ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label>Digito Conta</label></th>
            <td>
                <input type="text" name="accountDigit" value="<?php echo $accountDigit ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label>Nome Conta</label></th>
            <td>
                <input type="text" name="accountName" value="<?php echo $accountName ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label>Agencia</label></th>
            <td>
                <input type="text" name="agency" value="<?php echo $agency ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label>Banco</label></th>
            <td>
                <?php $selectd = fn ($v) => $v == $bank ? 'selectd' : ''; ?>
                <select class="regular-text" name="bank">
                    <option value='001' <?php echo $selectd('001') ?>> BANCO DO BRASIL - 001 </option>
                    <option value='104' <?php echo $selectd('104') ?>> CAIXA ECONÔMICA FEDERAL - 104 </option>
                    <option value='033' <?php echo $selectd('033') ?>> BCO SANTANDER S.A. - 033 </option>
                    <option value='237' <?php echo $selectd('237') ?>> BCO BRADESCO S.A. - 237 </option>
                    <option value='041' <?php echo $selectd('041') ?>> BCO DO ESTADO DO RS S.A. - 041 </option>
                    <option value='748' <?php echo $selectd('748') ?>> BCO COOPERATIVO SICREDI S.A. - 748 </option>
                    <option value='756' <?php echo $selectd('756') ?>> BCO SICOOB - 756 </option>
                    <option value='341' <?php echo $selectd('341') ?>> BCO ITAÚ UNIBANCO - 341 </option>
                    <option value='077' <?php echo $selectd('077') ?>> BCO INTER - 077 </option>
                    <option value='756' <?php echo $selectd('756') ?>> BCO SICOOB - 756 </option>
                    <option value='260' <?php echo $selectd('260') ?>> NUBANK - 260 </option>
                    <option value='336' <?php echo $selectd('336') ?>> Banco C6 S.A. - 336 </option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label>Tipo de conta</label></th>
            <td>
                <?php $selectd_2 = fn ($v) => $v == $bankAccountType ? 'selectd' : ''; ?>
                <select class="regular-text" name="bankAccountType">
                    <option value='CONTA_CORRENTE' <?php echo $selectd_2('CONTA_CORRENTE') ?>> Corrente </option>
                    <option value='CONTA_POUPANCA' <?php echo $selectd_2('CONTA_POUPANCA') ?>> Poupança </option>
                </select>
            </td>
        </tr>

    </table>

<?php
}
// add_action('user_new_form', 'custom_add_user_field');
add_action('show_user_profile', 'custom_add_user_field');
add_action('edit_user_profile', 'custom_add_user_field');

function custom_registration_fields_validation($errors, $sanitized_user_login, $user_email)
{

    $is_walletI = $_POST['custom_wallet_id'] ?? '';
    if (strlen($is_walletI) < 30 && isset($_POST['cus_tipo_conta'])) {

        $campos_obrigatorios = [
            "cus_tipo_conta",
            "cus_tipo_empresa",
            "custom_nascimento",
            "custom_nome",
            "custom_CPF",
            "custom_CNPJ",
            "custom_mail",
            "custom_phone",
            "custom_zip_code",
            "custom_address",
            "custom_address_number",
            "custom_bairro",
        ];

        // foreach($campos_obrigatorios as $name_campo_obrigatorio) {
        //     if(empty($_POST[$name_campo_obrigatorio])) return $errors;
        // }

        $cus_tipo_conta = sanitize_text_field($_POST['cus_tipo_conta']);
        $cus_tipo_empresa = sanitize_text_field($_POST['cus_tipo_empresa']);
        $custom_nascimento = sanitize_text_field($_POST['custom_nascimento']);
        $custom_nome = sanitize_text_field($_POST['custom_nome']);
        $custom_CPF = sanitize_text_field($_POST['custom_CPF']);
        $custom_CNPJ = sanitize_text_field($_POST['custom_CNPJ']);
        $custom_mail = sanitize_text_field($_POST['custom_mail']);
        $custom_phone = sanitize_text_field($_POST['custom_phone']);
        $custom_zip_code = sanitize_text_field($_POST['custom_zip_code']);
        $custom_address = sanitize_text_field($_POST['custom_address']);
        $custom_address_number = sanitize_text_field($_POST['custom_address_number']);
        $custom_bairro = sanitize_text_field($_POST['custom_bairro']);

        $account = sanitize_text_field($_POST['account']);
        $accountDigit = sanitize_text_field($_POST['accountDigit']);
        $accountName = sanitize_text_field($_POST['accountName']);
        $agency = sanitize_text_field($_POST['agency']);
        $bank = sanitize_text_field($_POST['bank']);
        $bankAccountType = sanitize_text_field($_POST['bankAccountType']);

        $CPF_OR_CNPJ = $cus_tipo_conta == 'FISICA' ? $custom_CPF : $custom_CNPJ;

        $custom_wallet_id_res_asaas = register_wallet(
            $cus_tipo_conta,
            $custom_nascimento,
            $custom_nome,
            $custom_mail,
            $CPF_OR_CNPJ,
            $cus_tipo_empresa,
            $custom_phone,
            $custom_phone,
            $custom_address,
            $custom_address_number,
            '',
            $custom_bairro,
            $custom_zip_code,
            $account,
            $accountDigit,
            $accountName,
            $agency,
            $bank,
            $bankAccountType
        );

        if (!empty($custom_wallet_id_res_asaas["errors"])) {
            $errors->add('custom_wallet_id', __('<strong>Erro</strong>:' . $custom_wallet_id_res_asaas["errors"][0]['description']));
        }

        if (empty($custom_wallet_id_res_asaas["errors"])) {
            $_POST['walletId'] = $custom_wallet_id_res_asaas['walletId'];
            $_POST['custom_wallet_id'] = $_POST['walletId'];
            $_POST['asaas_api_key'] = $custom_wallet_id_res_asaas['apiKey'];
        }
    } else {
        $_POST['walletId'] = $_POST['custom_wallet_id'];
    }

    return $errors;
}
add_filter('user_profile_update_errors', 'custom_registration_fields_validation', 10, 3);

function custom_user_register($user_id)
{

    $cus_tipo_conta = sanitize_text_field($_POST['cus_tipo_conta']);
    $cus_tipo_empresa = sanitize_text_field($_POST['cus_tipo_empresa']);
    $custom_nascimento = sanitize_text_field($_POST['custom_nascimento']);
    $custom_nome = sanitize_text_field($_POST['custom_nome']);
    $custom_CPF = sanitize_text_field($_POST['custom_CPF']);
    $custom_CNPJ = sanitize_text_field($_POST['custom_CNPJ']);
    $custom_mail = sanitize_text_field($_POST['custom_mail']);
    $custom_phone = sanitize_text_field($_POST['custom_phone']);
    $custom_zip_code = sanitize_text_field($_POST['custom_zip_code']);
    $custom_address = sanitize_text_field($_POST['custom_address']);
    $custom_address_number = sanitize_text_field($_POST['custom_address_number']);
    $custom_bairro = sanitize_text_field($_POST['custom_bairro']);

    if (isset($_POST['custom_wallet_id'])) {
        add_user_meta($user_id, 'custom_wallet_id', $_POST['walletId']);
    }

    if (isset($_POST['asaas_api_key'])) {
        add_user_meta($user_id, 'asaas_api_key', $_POST['asaas_api_key']);
    }

    if (isset($_POST['asaas_api_key']) && isset($_POST['custom_wallet_id'])) {
        enviar_api($user_id, sanitize_text_field($_POST['custom_wallet_id']), sanitize_text_field($_POST['asaas_api_key']));
    }

    $loop = [
        'cus_tipo_conta',
        'cus_tipo_empresa',
        'custom_nascimento',
        'custom_nome',
        'custom_CPF',
        'custom_CNPJ',
        'custom_mail',
        'custom_phone',
        'custom_zip_code',
        'custom_address',
        'custom_address_number',
        'custom_bairro',
        'account',
        'accountDigit',
        'accountName',
        'agency',
        'bank',
        'bankAccountType',
    ];
    foreach ($loop as $el) {
        if (isset($_POST[$el])) {
            add_user_meta($user_id, $el, $$el);
        }
    }
}
add_action('user_register', 'custom_user_register');

function custom_user_update($user_id)
{
    
    if (isset($_POST['custom_wallet_id'])) {
        update_user_meta($user_id, 'custom_wallet_id', sanitize_text_field($_POST['custom_wallet_id']));
    }

    if (isset($_POST['asaas_api_key'])) {
        add_user_meta($user_id, 'asaas_api_key', sanitize_text_field($_POST['asaas_api_key']));
    }

    if (isset($_POST['asaas_api_key']) && isset($_POST['custom_wallet_id'])) {
        enviar_api($user_id, sanitize_text_field($_POST['custom_wallet_id']), sanitize_text_field($_POST['asaas_api_key']));
    }

    $loop = [
        'cus_tipo_conta',
        'cus_tipo_empresa',
        'custom_nascimento',
        'custom_nome',
        'custom_CPF',
        'custom_CNPJ',
        'custom_mail',
        'custom_phone',
        'custom_zip_code',
        'custom_address',
        'custom_address_number',
        'custom_bairro',
        'account',
        'accountDigit',
        'accountName',
        'agency',
        'bank',
        'bankAccountType',
    ];

    foreach ($loop as $el) {
        if (isset($_POST[$el])) {
            update_user_meta($user_id, $el, sanitize_text_field($_POST[$el]));
        }
    }

}
add_action('profile_update', 'custom_user_update');
