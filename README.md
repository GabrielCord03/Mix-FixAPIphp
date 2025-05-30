spotify-php-api-project
├── api
│   ├── public
│   │   └── index.php          # Ponto de entrada da API
│   ├── src
│   │   ├── SpotifyService.php  # Comunicação com a API do Spotify
│   │   └── routes.php          # Rotas da API
│   └── composer.json           # Configuração do Composer
├── frontend
│   ├── index.html              # Página principal da interface
│   ├── css
│   │   └── style.css           # Estilos do frontend
│   └── js
│       └── app.js              # Lógica JavaScript da aplicação
└── README.md                   # Documentação do projeto

## Como Usar

1. **Clonar o repositório:**
   ```
   git clone <repository-url>
   cd spotify-php-api-project
   ```

2. **Instalar dependências PHP:**
   ```
   cd api
   composer install
   ```

3. **Configurar credenciais do Spotify:**
   Cadastre um app no Spotify Developer e configure as credenciais (pode ser por arquivo .env ou direto no código).

4. **Rodar o servidor da API:**
   ```
   php -S localhost:8000 -t public
   ```

5. **Abrir o frontend:**
   Abra o arquivo `frontend/index.html` no navegador.

## Observações

- A interface envia requisições para o backend PHP, que repassa para a API do Spotify.

- Você precisa de um token válido do Spotify para funcionar corretamente.

- Personalize o arquivo SpotifyService.php conforme suas necessidades.