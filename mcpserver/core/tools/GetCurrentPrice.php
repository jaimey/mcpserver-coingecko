<?php

class GetCurrentPrice
{
    public function ejecutar(array $params): array
    {
        $coin = $params['coin'] ?? 'bitcoin';
        $currency = $params['currency'] ?? 'usd';

        $url = "https://api.coingecko.com/api/v3/simple/price?ids=$coin&vs_currencies=$currency";

        $data = json_decode(file_get_contents($url), true);

        if (!isset($data[$coin][$currency])) {
            throw new Exception("No se pudo obtener el precio de $coin en $currency.");
        }

        return [
            "coin" => $coin,
            "currency" => $currency,
            "price" => $data[$coin][$currency],
            "timestamp" => date('c')
        ];
    }
}