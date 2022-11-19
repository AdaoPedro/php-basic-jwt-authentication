<?php
    declare(strict_types=1);

    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    use Firebase\JWT\ExpiredException;

    require __DIR__ . "/../vendor/autoload.php";

    if (
        !isset($_SERVER["HTTP_AUTHORIZATION"])
    ) {
        header("HTTP/1.0 400 Bad Request");

        echo "Token not found in request";

        exit;
    }

    $secretKey = "123";
    $issuer = "infracomercial.ao";
    $now = new DateTimeImmutable();

    list(, $token) = explode(" ", $_SERVER["HTTP_AUTHORIZATION"]);

    try {
        $jwtDecoded = JWT::decode($token, new Key($secretKey, "HS256"));
    } catch (ExpiredException $ex) {
        header("HTTP/1.0 401 Unauthorized");

        exit;
    }

    if (
        $jwtDecoded->iss !== $issuer
        || $jwtDecoded->nbf > $now->getTimestamp()
        || $jwtDecoded->exp < $now ->getTimestamp()
    ) {
        header("HTTP/1.0 401 Unauthorized");

        exit;
    }

    print_r($jwtDecoded);