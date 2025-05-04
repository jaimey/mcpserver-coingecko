# 🧠 MCP Server - CoinGecko Wrapper

Este proyecto implementa un servidor **MCP (Model Context Protocol)** utilizando `@modelcontextprotocol/sdk`. Responde a requests MCP por `stdio` (entrada/salida estándar) y permite consultar datos de CoinGecko u otras APIs.

---

## 🚀 Requisitos

- Node.js v18 o superior
- Git (para clonar el repositorio)

---

## 📦 Instalación

Cloná el repositorio y entrá a la carpeta:

```bash
git clone https://github.com/tu-usuario/nombre-del-repo.git
cd nombre-del-repo
```

Instalá las dependencias:

```bash
npm install
```

Compilá el código TypeScript:

```bash
npm run build
```

---

## ▶️ Ejecución

Una vez compilado, podés iniciar el servidor MCP:

```bash
node build/index.js
```

El servidor queda a la espera de recibir mensajes MCP por stdio, como los que puede enviar un agente Claude o cualquier otro sistema compatible.

---

## 📂 Estructura del proyecto

```
├── src/
│   └── index.ts         # Lógica principal del servidor MCP
├── package.json         # Dependencias y scripts
├── tsconfig.json        # Configuración TypeScript
├── build/               # Código compilado
```

---

## 🧱 Librerías utilizadas

- `@modelcontextprotocol/sdk`: Para definir funciones MCP y manejar la comunicación.
- `node-fetch`: Para hacer requests HTTP a APIs externas como CoinGecko.
- `zod`: Para validar la entrada de las funciones exportadas (si se usa).

---

## 📜 Licencia

MIT
