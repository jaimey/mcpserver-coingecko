<?php

class MCPServer
{
    private $tools = [];

    public function registrarTool(string $nombre, object $tool)
    {
        $this->tools[$nombre] = $tool;
    }

    public function procesar(array $request): array
    {
        $toolName = $request['tool'];
        $params = $request['parameters'] ?? [];

        if (!isset($this->tools[$toolName])) {
            return ["error" => "La herramienta '$toolName' no está registrada."];
        }

        try {
            return $this->tools[$toolName]->ejecutar($params);
        } catch (Exception $e) {
            return ["error" => "Error en '$toolName': " . $e->getMessage()];
        }
    }
}