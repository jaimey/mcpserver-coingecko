<?php
header('Content-Type: application/json');

echo json_encode([
    [
        "tool" => "get_current_price",
        "description" => "Devuelve el precio actual de una criptomoneda en una divisa específica.",
        "parameters" => [
            "coin" => "string",
            "currency" => "string"
        ]
    ],
    [
        "tool" => "get_coin_info",
        "description" => "Devuelve información general sobre una criptomoneda, incluyendo descripción, sitio web y fecha de origen.",
        "parameters" => [
            "coin" => "string"
        ]
    ]
], JSON_PRETTY_PRINT);
