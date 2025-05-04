<?php
require_once __DIR__ .'/core/MCPServer.php';
require_once __DIR__ .'/core/tools/GetCurrentPrice.php';
require_once __DIR__ .'/core/tools/GetCoinInfo.php';

// Recibir MCP en formato JSON (POST)
header('Content-Type: application/json');

$input = file_get_contents('php://input');
$request = json_decode($input, true);

if (!$request || !isset($request['tool'])) {
    http_response_code(400);
    echo json_encode(["error" => "Formato MCP inválido. Falta 'tool'."]);
    exit;
}

// Inicializar el servidor MCP
$mcp = new MCPServer();

// Registrar tools disponibles
$mcp->registrarTool('get_current_price', new GetCurrentPrice());
$mcp->registrarTool('get_coin_info', new GetCoinInfo());

// Procesar la solicitud
$response = $mcp->procesar($request);

echo json_encode($response, JSON_PRETTY_PRINT);