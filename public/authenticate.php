<?php

    declare(strict_types=1);

    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    require_once __DIR__. "/../vendor/autoload.php";

    $isUserValid = true;

    if(!$isUserValid) {
        header("HTTP/1.0 400 Bad Request");

        echo "Email or password is not valid";

        exit;
    }

    header("HTTP/1.0 200 OK");

    $secretKey = "123";

    $issuedAt = new \DateTimeImmutable();
    $notBefore = $issuedAt;
    $expiresIn = $issuedAt->modify("+60 minutes");
    $issuer = "infracomercial.ao";
    $tokenId = base64_encode(random_bytes(16)); 

    $data = [
        "userId" => 9182
    ];


    $payload = [
        "jti" => $tokenId, //Unique id for token
        "iat" => $issuedAt->getTimestamp(), //Issued at
        "iss" => $issuer, //Who create and sign this token
        "nbf" => $notBefore->getTimestamp(), //Not valid before
        "exp" => $expiresIn->getTimestamp(), //Expiration time
        "data" => $data
    ];

    $jwt = JWT::encode($payload, $secretKey, "HS256");

    echo json_encode(["jwt" => $jwt]);

    