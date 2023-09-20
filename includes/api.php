<?php


function enviar_api($user_id, $wallet, $key)
{

    $webhook_url = 'https://n8n.digitalcombo.com.br/webhook/51f9bd28-8d8f-4aae-897c-f86daa6f2ed1';

    $data = array(
        'user_id' => $user_id,
        'wallet' => $wallet,
        'key' => $key,
    );

    $args = array(
        'body' => json_encode($data),
        'headers' => array(
            'Content-Type' => 'application/json',
        ),
    );

    wp_safe_remote_post($webhook_url, $args);
}
