<?php

function get_token()
{
    return get_option('woocommerce_asaas-credit-card_settings')['api_key'] ?? '';
}
function get_endpoint()
{
    return get_option('woocommerce_asaas-credit-card_settings')['endpoint'] ?? '';
}

function post_asaas($path, $payload, $get_endpoint, $token = '')
{

    $full_path = $get_endpoint;
    $full_path .= $path;

    $defaults = [
        CURLOPT_POST           => true,
        CURLOPT_HEADER         => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL            => $full_path,
        CURLOPT_POSTFIELDS     => json_encode($payload),
        CURLOPT_HTTPHEADER     => [
            'content-type: application/json',
            "access_token: {$token}",
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


function clear_number(string $number)
{
    return preg_replace('/\D/', '', $number);
}

function register_wallet(
    string $personType,
    string $birthDate,
    string $name,
    string $email,
    string $cpfCNPJ,
    string $companyType,
    string $phone,
    string $mobilePhone,
    string $address,
    string $addressNumber,
    string $complement,
    string $province,
    string $postalCode,

    string $account,
    string $accountDigit,
    string $accountName,
    string $agency,
    string $bank,
    string $bankAccountType

): array {
    $payload = [
        "personType" => $personType,
        "name" => $name,
        "email" => $email,
        "cpfCnpj" => clear_number($cpfCNPJ),
        "phone" => clear_number($phone),
        "mobilePhone" => clear_number($mobilePhone),
        "address" => $address,
        "addressNumber" => $addressNumber,
        "complement" => $complement,
        "province" => $province,
        "postalCode" => clear_number($postalCode),
        // "bankAccount" => [
        //     "account" => clear_number($account),
        //     "accountDigit" => clear_number($accountDigit),
        //     "accountName" => $accountName,
        //     "agency" => clear_number($agency),
        //     "bank" => clear_number($bank),
        //     "bankAccountType" => $bankAccountType,
        //     "cpfCnpj" => clear_number($cpfCNPJ),
        //     "name" => $name,
        // ]
    ];
    if ($personType != "FISICA") {
        $payload["companyType"] = $companyType;
    } else {
        $payload["birthDate"] = $birthDate;
    }
    $token = get_token();
    $get_endpoint = get_endpoint();
    $token = 'TOKEN_CHUMBADO';
    $resAsa = post_asaas('/accounts', $payload, $get_endpoint, $token);
    return $resAsa;
}

function GetAsaas(string $path, array $payload, string $key): array
{
    $param = http_build_query($payload);
    $full_path = "{$path}?{$param}";
    $defaults = [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL            => $full_path,
        CURLOPT_HTTPHEADER     => [
            'Content-Type:application/json',
            "access_token: {$key}"
        ]
    ];
    $con = curl_init();
    curl_setopt_array($con, $defaults);
    $ex = curl_exec($con);
    $info = curl_getinfo($con);
    curl_close($con);
    return json_decode($ex, true);
}

function BalanceAsaas($key)
{
    $base = get_endpoint();
    $response = GetAsaas("{$base}/finance/balance", [], $key);
    return $response['balance'] ?? 0;
}

function GetWalletID()
{
    $base = get_endpoint();
    $key = get_token();
    $response = GetAsaas("{$base}/wallets", [], $key);
    return $response['data']['id'] ?? 0;
}

function TransfeAsaas(
    $value,
    $vendedor_wallet_id,
    $loja_wallet_id
) {
    $get_endpoint = get_endpoint();
    $path = "/transfers";
    $payload = [
        "value" => $value,
        "walletId" => $loja_wallet_id,
    ];
    $token = $vendedor_wallet_id;
    return post_asaas($path, $payload, $get_endpoint, $token);
}

function MakerBank(
    $bankCode,
    $agency,
    $account,
    $accountDigit,
    $bankAccountType,
    $name,
    $cpfCnpj,
    $responsiblePhone,
    $responsibleEmail,
    $token
) {
	global $_debug;
    $get_endpoint = get_endpoint();
    $path = "/bankAccounts";
    $payload = [
        "accountName" => "Conta Bancária",
        "thirdPartyAccount" => true,
        "bankCode" => clear_number($bankCode),
        "agency" => clear_number($agency),
        "account" => clear_number($account),
        "accountDigit" => clear_number($accountDigit),
        "bankAccountType" => $bankAccountType,
        "name" => $name,
        "cpfCnpj" => clear_number($cpfCnpj),
        "responsiblePhone" => clear_number($responsiblePhone),
        "responsibleEmail" => $responsibleEmail,
        "mainAccount" => true
    ];
	$res = post_asaas($path, $payload, $get_endpoint, $token);
	return $res ;
}
