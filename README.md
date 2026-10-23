# 📚 Sistema de Gestão de Biblioteca

Sistema web procedural desenvolvido em PHP, MySQL, HTML5 e CSS3 para o controle e gestão de acervos, clientes e empréstimos de livros, estruturado com separação entre a lógica de processamento e a apresentação visual.

---

## 🚀 Funcionalidades e Perfis de Usuário

### 👤 Assistente
- **Clientes:** Cadastro e atualização de dados dos clientes.
- **Empréstimos e Devoluções:** Registro de empréstimos com abatimento automático no estoque e baixa de devoluções com reposição automática da quantidade do livro.
- **Acervo:** Consulta do status e disponibilidade dos livros em tempo real.

### 👩‍💼 Bibliotecária
- **Todas as permissões do perfil Assistente.**
- **Gêneros Literários:** Cadastro e categorização de gêneros de livros.
- **Gestão do Acervo:** Adição e edição completa de livros.
- **Controle de Estoque:** Gestão manual e ajuste da quantidade de exemplares disponíveis.

---

## 🛠️ Tecnologias Utilizadas

- **Front-end:** HTML5 e CSS3 puro (com navegação integrando botões de ação e encerramento de sessão via `POST`).
- **Back-end:** PHP procedural (comunicação e envio de formulários exclusivamente por método `POST`).
- **Banco de Dados:** MySQL / MariaDB (gerenciado via phpMyAdmin).

---

## 🗄️ Estrutura do Banco de Dados (`biblioteca_db`)

```sql
CREATE DATABASE IF NOT EXISTS biblioteca_db;
USE biblioteca_db;

-- Tabela de Usuários
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome_usuario VARCHAR(100) NOT NULL,
    email_usuario VARCHAR(100) NOT NULL UNIQUE,
    senha_usuario VARCHAR(255) NOT NULL,
    tipo ENUM('bibliotecaria', 'assistente') NOT NULL
);

-- Tabela de Gêneros
CREATE TABLE generos (
    id_genero INT AUTO_INCREMENT PRIMARY KEY,
    nome_genero VARCHAR(50) NOT NULL
);

-- Tabela de Livros
CREATE TABLE livros (
    id_livro INT AUTO_INCREMENT PRIMARY KEY,
    titulo_livro VARCHAR(150) NOT NULL,
    autor_livro VARCHAR(100) NOT NULL,
    id_genero INT,
    quantidade_livro INT DEFAULT 0,
    FOREIGN KEY (id_genero) REFERENCES generos(id_genero)
);

-- Tabela de Clientes
CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nome_cliente VARCHAR(100) NOT NULL,
    cpf_cliente VARCHAR(14) NOT NULL UNIQUE,
    telefone_cliente VARCHAR(20)
);

-- Tabela de Empréstimos
CREATE TABLE emprestimos (
    id_emprestimo INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    id_livro INT NOT NULL,
    data_emprestimo DATE NOT NULL,
    data_devolucao DATE NULL,
    status ENUM('ativo', 'devolvido') DEFAULT 'ativo',
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente),
    FOREIGN KEY (id_livro) REFERENCES livros(id_livro)
);
```

---

## 📁 Estrutura de Arquivos do Projeto

```text
├── conexao.php               # Conexão com o banco MySQL e início de sessão
├── login.php                 # Formulário de acesso ao sistema
├── processa_login.php        # Validação de credenciais e redirecionamento por perfil
├── logout.php                # Encerramento de sessão
├── assistente_clientes.php   # Formulário e listagem de clientes
├── processa_cliente.php      # Inserção/edição de clientes
├── assistente_emprestimos.php# Painel de empréstimos e baixas de devolução
├── processa_emprestimo.php   # Novo empréstimo e decremento no estoque
├── processa_devolucao.php    # Devolução e incremento no estoque
├── assistente_livros.php     # Consulta do acervo para assistente
├── bibliotecaria_generos.php # Formulário e tabela de gêneros
├── processa_genero.php       # Inserção de gêneros no banco
├── bibliotecaria_livros.php  # Gestão do acervo e alteração de estoque
└── processa_livro.php        # Criação e atualização de livros
```

---

## ⚙️ Como Executar o Projeto

1. **Clonar o Repositório:**
   ```bash
   git clone https://github.com/seu-usuario/nome-do-repositorio.git
   ```

2. **Mover para o Servidor Web Local:**
   Copie a pasta do projeto para o diretório do servidor local (ex.: `htdocs` no XAMPP ou `www` no WAMP).

3. **Configurar o Banco de Dados:**
   - Acesse o **phpMyAdmin** (`http://localhost/phpmyadmin`).
   - Crie o banco de dados `biblioteca_db`.
   - Importe a estrutura SQL listada acima e insira usuários para teste na tabela `usuarios`.

4. **Acessar a Aplicação:**
   Abra o navegador e acesse:
   ```text
   http://localhost/nome-do-repositorio/login.php
   ```
