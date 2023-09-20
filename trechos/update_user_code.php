<?php

function enviar_dados_apos_atualizacao_de_perfil($user_id) {
    // Verifique se o usuário existe
    $user = get_user_by('ID', $user_id);
    
    if ($user) {
        $webhook_url = 'https://n8n.digitalcombo.com.br/webhook/592616b3-da77-48b7-a31f-b652c259c47a';

        // Dados a serem enviados para o webhook
        $data = array(
            'user_id' => $user_id,
            'user_email' => $user->user_email,
            'user_name' => $user->user_login,
            'store_name' => get_user_meta($user_id,'wcfmmp_store_name', true),
        );

        // Verifica se a senha foi alterada
        if (isset($_POST['pass1']) && !empty($_POST['pass1'])) {
            $data['user_password'] = $_POST['pass1'];
        }

        // Configuração da requisição POST
        $args = array(
            'body' => json_encode($data),
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
        );

        // Envia a requisição POST para o webhook
        $response = wp_safe_remote_post($webhook_url, $args);

        // Verifica se a requisição foi bem-sucedida (você pode personalizar essa verificação)
        if (is_wp_error($response)) {
            error_log('Erro ao enviar dados para o webhook: ' . $response->get_error_message());
        }
    }
}

// Adicione um gancho para executar a função após a atualização do perfil do usuário
add_action('profile_update', 'enviar_dados_apos_atualizacao_de_perfil');