<?php

function enviar_dados_para_webhook($user_id) {
	
	
    //     Verifica se o usuário foi criado com sucesso
        if (!is_wp_error($user_id)) {
            $user = get_user_by('ID', $user_id);
            
            // Verifique se o usuário existe
            if ($user) {
                 $webhook_url = 'https://n8n.digitalcombo.com.br/webhook/abd89804-cb9c-450d-bb43-4bbd34a742f4';
    
                // Dados a serem enviados para o webhook
                $data = array(
                    'user_id' => $user_id,
                    'user_email' => $user->user_email,
                    'user_name' => $user->user_login,
                    'user_password' => $_POST['pass1'],
                    'timestamp' => current_time('mysql'),
                );
    
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
    }
    
    // Adicione um gancho para executar a função após o cadastro do usuário
    add_action('user_register', 'enviar_dados_para_webhook');