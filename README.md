
# MCPServer + CoinGecko Wrapper

Este repositorio contiene dos componentes clave para trabajar con **Model Context Protocol (MCP)**:

---

## 1. `mcpserver` (PHP)

Servidor principal que recibe y responde peticiones MCP desde agentes compatibles.

### Archivos principales:
- `core/`: lógica central reutilizable.
- `capabilities.php`: declara qué herramientas (tools) puede usar este servidor.
- `webhook.php`: endpoint principal que recibe las requests MCP.

### Qué hace?
- Recibe solicitudes en formato MCP (JSON).
- Redirige internamente según el `tool_choice`.
- Llama a la herramienta correspondiente (por ejemplo, el wrapper de CoinGecko).
- Devuelve una respuesta estructurada MCP para que la procese el agente.

---

## 2. `mcp-coingecko-wrapper` (Node.js + TypeScript)

Tool externa que expone datos de criptomonedas usando la API pública de CoinGecko.

### Estructura:
- `src/index.ts`: lógica principal del wrapper.
- `package.json`: scripts y dependencias.

### Qué hace?
- Expone un endpoint HTTP compatible con MCP.
- Permite obtener datos como:
  - Precio actual de una criptomoneda.
  - Información general.
  - Historial de precios.

---

## Cómo funciona todo junto?

1. Un agente (como Claude o GPT) hace una consulta MCP.
2. `webhook.php` del `mcpserver` la recibe y decide qué tool usar.
3. Si es sobre criptomonedas, llama al wrapper TypeScript (`mcp-coingecko-wrapper`).
4. Se obtiene la respuesta de CoinGecko y se devuelve en formato MCP.

---

## Requisitos

- PHP 8+ con soporte para `curl` (para `mcpserver`).
- Node.js 18+ (para el wrapper).
- Una instancia de agente compatible con MCP (ej: Claude).

---

## Instalación rápida

```bash
# 1. Instalar dependencias del wrapper
cd mcp-coingecko-wrapper
npm install
npm run build
```

```bash
# 2. Servir el mcpserver (PHP)
# Usar XAMPP, Apache o cualquier servidor PHP con acceso a webhook.php
```

---

## 馃摤 Ejemplo de request MCP

```json
{
  "tool_choice": "coingecko",
  "input": {
    "symbol": "bitcoin",
    "operation": "price_now"
  }
}
```

---
Listo. Es todo lo que necesit谩s para conectar un agente con CoinGecko usando MCP.  
