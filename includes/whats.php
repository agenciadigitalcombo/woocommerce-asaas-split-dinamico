<?php

function PostJson($full_path, $payload)
{
    $defaults = [
        CURLOPT_POST           => true,
        CURLOPT_HEADER         => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL            => $full_path,
        CURLOPT_POSTFIELDS     => json_encode($payload),
        CURLOPT_HTTPHEADER     => [
            'authorization: joohn',
            'content-type: application/json',
            "accept: */*",
            "content-length: " . strlen(json_encode($payload)),
        ]
    ];
    $con = curl_init();
    curl_setopt_array($con, $defaults);
    $ex = curl_exec($con);
    $info = curl_getinfo($con);
    curl_close($con);
    return json_decode($ex, true);
}

function SendWhats($phone, $message)
{
    $path = "https://back.botcombo.com.br/api/messages/send";
    $payload = [
        "number" => "55{$phone}",
        "body" => $message
    ];
    return PostJson($path, $payload);
}
