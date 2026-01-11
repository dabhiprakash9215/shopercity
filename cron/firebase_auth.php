<?php

function getFirebaseAccessToken(string $serviceAccountPath): string
{
    $json = json_decode(file_get_contents($serviceAccountPath), true);

    $now = time();
    $payload = [
        "iss"   => $json['client_email'],
        "scope" => "https://www.googleapis.com/auth/firebase.messaging",
        "aud"   => "https://oauth2.googleapis.com/token",
        "iat"   => $now,
        "exp"   => $now + 3600
    ];

    $header = ["alg" => "RS256", "typ" => "JWT"];

    $base64UrlEncode = function ($data) {
        return rtrim(strtr(base64_encode(json_encode($data)), '+/', '-_'), '=');
    };

    $jwtHeader  = $base64UrlEncode($header);
    $jwtPayload = $base64UrlEncode($payload);

    openssl_sign(
        $jwtHeader . "." . $jwtPayload,
        $signature,
        $json['private_key'],
        OPENSSL_ALGO_SHA256
    );

    $jwt = $jwtHeader . "." . $jwtPayload . "." . rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');

    // Exchange JWT for access token
    $ch = curl_init("https://oauth2.googleapis.com/token");
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ["Content-Type: application/x-www-form-urlencoded"],
        CURLOPT_POSTFIELDS => http_build_query([
            "grant_type" => "urn:ietf:params:oauth:grant-type:jwt-bearer",
            "assertion"  => $jwt
        ])
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    return $data['access_token'] ?? '';
}
