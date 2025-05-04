<?php

class GetCoinInfo
{
    public function ejecutar(array $params): array
    {
        $coin = $params['coin'] ?? null;

        if (!$coin) {
            throw new Exception("Falta el parámetro 'coin'.");
        }

        $url = "https://api.coingecko.com/api/v3/coins/$coin";

        $data = json_decode(file_get_contents($url), true);

        if (!isset($data['id'])) {
            throw new Exception("No se encontró información para la moneda '$coin'.");
        }

        return [
            "id" => $data['id'],
            "symbol" => $data['symbol'],
            "name" => $data['name'],
            "homepage" => $data['links']['homepage'][0] ?? null,
            "description" => strip_tags($data['description']['en'] ?? "Sin descripción."),
            "genesis_date" => $data['genesis_date'],
            "market_cap_rank" => $data['market_cap_rank'],
            "last_updated" => $data['last_updated']
        ];
    }
}