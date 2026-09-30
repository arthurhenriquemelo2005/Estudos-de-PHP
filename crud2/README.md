# CRUD de Alunos

Este projeto é um sistema simples de cadastro, listagem, atualização e exclusão de alunos, desenvolvido em PHP com banco de dados MySQL.

O objetivo principal foi criar um CRUD funcional para praticar conceitos de conexão com banco de dados, manipulação de dados com PDO, envio de formulários e navegação entre páginas em PHP.

---

## O que este projeto faz

O sistema permite:

- cadastrar novos alunos
- visualizar todos os alunos cadastrados
- editar as informações de um aluno
- excluir um aluno do banco de dados

Ele é uma base excelente para quem está começando a aprender PHP e banco de dados.

---

## 🛠️ Tecnologias utilizadas

- PHP
- MySQL
- PDO (PHP Data Objects)
- HTML
- CSS
- XAMPP (ambiente de desenvolvimento local)

---

##  Estrutura do projeto

```text
crud2/
├── conexao.php
├── index.html
├── cadastrar.php
├── painel.php
├── editar.php
├── atualizar.php
├── deletar.php
└── README.md
```

### Descrição dos arquivos

- `conexao.php`: realiza a conexão com o banco de dados MySQL.
- `index.html`: página inicial para cadastrar um aluno.
- `cadastrar.php`: recebe os dados do formulário e insere no banco.
- `painel.php`: lista todos os alunos cadastrados.
- `editar.php`: carrega os dados do aluno para edição.
- `atualizar.php`: atualiza os dados no banco.
- `deletar.php`: confirma e remove o aluno.

---

##  Banco de dados

O projeto usa um banco chamado `escola2` e uma tabela chamada `alunos`.

Estrutura sugerida da tabela:

```sql
CREATE TABLE alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255),
    email VARCHAR(255),
    cidade VARCHAR(255)
);
```

---



---

##  Fluxo do sistema

### 1. Cadastro
O usuário preenche o nome, e-mail e cidade no formulário da página inicial. Esses dados são enviados para `cadastrar.php`, que insere o registro no banco.

### 2. Listagem
A página `painel.php` consulta todos os alunos e os exibe em uma tabela.

### 3. Edição
Ao clicar em “Atualizar”, o sistema leva o usuário para a página `editar.php`, que carrega os dados do aluno selecionado e permite alterar as informações.

### 4. Exclusão
Ao clicar em “Excluir”, o usuário é levado para uma página de confirmação em `deletar.php`. Depois da confirmação, o registro é removido do banco.

---

##  Aprendizados praticados

Este projeto ajuda a entender:

- manipulação de formulários em PHP
- conexão com banco de dados
- uso de Prepared Statements com PDO
- operações CRUD completas
- organização de arquivos em um projeto web simples
- uso de HTML e CSS para melhorar a interface

---

##  Observação

Este é um projeto de estudo e foi desenvolvido como prática de programação em PHP. Ele demonstra de forma simples como um sistema básico de gerenciamento de dados funciona.

---

## 👨‍💻 Autor

Arthur Ribeiro

