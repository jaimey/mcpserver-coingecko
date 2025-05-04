/**
Este script actúa como una capa intermedia local, que:
Traduce el lenguaje MCP a llamadas HTTP.
Carga las herramientas definidas en el servidor.
Le presenta esas herramientas a Claude.
Ejecuta cada una de esas herramientas cuando Claude lo pide.
*/
import { McpServer } from "@modelcontextprotocol/sdk/server/mcp.js";
import { StdioServerTransport } from "@modelcontextprotocol/sdk/server/stdio.js";
import { z } from "zod";
import fetch from "node-fetch";
//McpServer: Clase que representa un servidor MCP local (el que va a hablar con Claude).
//StdioServerTransport: Canal de comunicación entre este script y el modelo.
//zod: Se usa para definir y validar esquemas de datos.
//fetch: Para llamar a los endpoints PHP del servidor web.


// Config: URLs a PHP
const webhookUrl = "https://tudominio.com/mcpserver/webhook.php";
const capabilitiesUrl = "https://tudominio.com/mcpserver/capabilities.php";

// Crear instancia del MCP Server que va a exponer las tools a Claude. 
// En este caso está vacío al principio (tools: {}), porque las tools se cargarán dinámicamente desde capabilities.php.
const server = new McpServer({
  name: "coingecko-mcp-wrapper",
  version: "1.0.0",
  capabilities: {
    resources: {},
    tools: {},
  },
});

// Cargar tools desde capabilities.php y registrarlas
async function loadCapabilitiesAndRegisterTools() {
  //Llama al archivo capabilities.php
  const response = await fetch(capabilitiesUrl);
  const tools = await response.json();

  for (const tool of tools) {
    const { tool: name, description, parameters } = tool;

    // Armamos el esquema en bruto, como Claude lo espera
    //  name: nombre interno.
    //  description: para que Claude sepa cuando usarla.
    //  parameters: los inputs que necesita, que se convierte en un zod schema (todos los tipos se fuerzan a string porque Claude hoy solo soporta strings como input).
    const schemaShape = Object.fromEntries(
      Object.entries(parameters).map(([key, _type]) => [key, z.string()])
    );

    // Registramos la tool dentro del MCP Server
    // Define cómo se ejecuta: Manda los datos al webhook.php, que se encargará de invocar la clase PHP correspondiente y devolver el resultado.    
    server.tool(name, description, schemaShape, async (input) => {
      const res = await fetch(webhookUrl, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          tool: name,
          parameters: input,
        }),
      });

      const data = await res.json();

      //La respuesta se formatea en un contenido de tipo text (que es lo que Claude espera).
      return {
        content: [
          {
            type: "text",
            text: JSON.stringify(data, null, 2),
          },
        ],
      };
    });
  }
}



//Deja el wrapper esperando órdenes.
async function main() {
  //Carga las tools.
  await loadCapabilitiesAndRegisterTools();

  //Abre el canal de comunicación con Claude (por stdio).
  const transport = new StdioServerTransport();

  // Iniciar el servidor MCP y conectarlo por stdio
  await server.connect(transport);

  console.error("✅ MCP Wrapper (CoinGecko) corriendo sobre stdio");
}

//Captura errores y muestra un mensaje si algo sale mal al iniciar.
main().catch((err) => {
  console.error("💥 Error crítico:", err);
  process.exit(1);
});