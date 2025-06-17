spotify-php-api-project
├── api
│   ├── public
│   │   └── index.php          # Ponto de entrada da API
│   ├── src
│   │    ├── routes.php           # Arquivo principal de rotas da API
│   │    ├── SpotifyService.php   # Serviço para integração com Spotify
│   │    └── PlaylistService.php  # Serviço para CRUD de playlists (mock)
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

## Funcionalidades das Rotas

### Spotify

- **GET /api/spotify/auth**  
  Autentica e retorna token de acesso do Spotify.

- **GET /api/spotify/tracks**  
  Retorna faixas do Spotify (exemplo de integração).

- **GET /api/spotify/albums**  
  Retorna álbuns do Spotify (exemplo de integração).

---

### Playlists (Mock CRUD)

#### Criar Playlist

- **POST /api/playlists**  
  Cria uma nova playlist local (mock).  
  **Body JSON:**  
  ```json
  {
    "nome": "Minha Playlist",
    "descricao": "Playlist de estudos"
  }
  ```
  **Respostas:**
  - `201 Created` com a playlist criada (inclui ID)
  - `400 Bad Request` com erros de validação

#### Buscar Playlist por ID

- **GET /api/playlists/{id}**  
  Retorna uma playlist pelo ID.  
  **Respostas:**
  - `200 OK` com a playlist encontrada
  - `404 Not Found` se não existir

#### Atualizar Playlist

- **PUT /api/playlists/{id}**  
  Atualiza todos os dados de uma playlist existente.  
  **Body JSON:**  
  ```json
  {
    "nome": "Nova Playlist",
    "descricao": "Atualizada"
  }
  ```
  **Respostas:**
  - `200 OK` com a playlist atualizada
  - `400 Bad Request` com erros de validação
  - `404 Not Found` se não existir

#### Excluir Playlist

- **DELETE /api/playlists/{id}**  
  Remove uma playlist pelo ID.  
  **Respostas:**
  - `200 OK` com mensagem de sucesso
  - `404 Not Found` se não existir

---

## Como funciona cada rota (Parte 2 e 3)

- **POST /api/playlists**  
  Lê o JSON enviado, valida se o campo `nome` existe e não excede 50 caracteres, gera um ID único e adiciona ao array estático. Retorna erro detalhado se faltar algum campo ou se o dado for inválido.

- **GET /api/playlists/{id}**  
  Busca no array estático pela playlist com o ID informado. Se encontrar, retorna a playlist; se não, retorna erro 404.

- **PUT /api/playlists/{id}**  
  Busca a playlist pelo ID, valida os dados recebidos (nome obrigatório, limites de tamanho), atualiza os campos e retorna a playlist atualizada. Se não encontrar, retorna 404; se houver erro de validação, retorna 400 com detalhes.

- **DELETE /api/playlists/{id}**  
  Busca a playlist pelo ID e remove do array. Se não encontrar, retorna 404; se remover, retorna mensagem de sucesso.

- **Validação de Dados**  
  Todas as operações de criação e atualização passam por uma função de validação robusta, que verifica presença, tipo e tamanho dos campos. Os erros são retornados em formato JSON padronizado.

- **Tratamento de Erros**  
  Todos os endpoints retornam status HTTP apropriados (`200`, `201`, `400`, `404`) e mensagens de erro claras em JSON.

---

## Observações sobre Persistência

- As playlists são armazenadas em um array estático em memória, ou seja, os dados são resetados a cada nova requisição (simulação de banco de dados).
- Não há persistência real entre requisições. Para testes mais realistas, pode-se adaptar para usar `$_SESSION` ou banco de dados.

---

## Como testar

1. **Inicie o servidor PHP:**
   ```sh
   php -S localhost:8000 -t api/src
   ```

2. **Use ferramentas como Postman, Insomnia ou cURL para testar as rotas.**

   Exemplos:
   - Criar playlist:
     ```sh
     curl -X POST http://localhost:8000/api/playlists -H "Content-Type: application/json" -d '{"nome":"Minha Playlist"}'
     ```
   - Buscar playlist:
     ```sh
     curl http://localhost:8000/api/playlists/1
     ```
   - Atualizar playlist:
     ```sh
     curl -X PUT http://localhost:8000/api/playlists/1 -H "Content-Type: application/json" -d '{"nome":"Nova Playlist"}'
     ```
   - Excluir playlist:
     ```sh
     curl -X DELETE http://localhost:8000/api/playlists/1
     ```

## Observações

- A interface envia requisições para o backend PHP, que repassa para a API do Spotify.

- Você precisa de um token válido do Spotify para funcionar corretamente.

- Personalize o arquivo SpotifyService.php conforme suas necessidades.

## Grupo
  Gabriel Cordeiro Alves, Caio de Vasconcelos Ramalho, Diógenes Lópes Dias de Souza.