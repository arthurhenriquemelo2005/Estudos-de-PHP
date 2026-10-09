# Cadastro de Produtos

Este projeto é uma atividade prática para desenvolver e reforçar os conceitos de CRUD em PHP com MySQL.

## Objetivo

O sistema tem como foco cadastrar, listar e visualizar produtos em um fluxo simples de aplicação web, com o propósito de praticar:

- conexão com banco de dados
- envio de dados via formulário
- inserção de registros
- leitura de registros
- estrutura de páginas em PHP
- organização de arquivos por pasta

## Tecnologias utilizadas

- PHP
- MySQL
- HTML
- CSS
- Bootstrap
- PDO para acesso ao banco

## Estrutura do projeto

```text
cadastroProdutos/
├── cadastrarProduto/
│   └── cadastrar.php
├── conexao/
│   └── conexao.php
├── produtosCadastrados/
│   └── index.php
├── telaCadastro/
│   └── cadastro.html
├── README.md
└── ...
```

## Funcionalidades atuais

- Cadastro de produto
- Redirecionamento após cadastro
- Listagem dos produtos cadastrados
- Interface básica com Bootstrap

## Status do projeto

Este projeto está em desenvolvimento e foi criado como exercício de estudo para praticar o fluxo de CRUD em aplicações web.

## Como executar

1. Inicie o Apache e o MySQL no XAMPP.
2. Crie o banco de dados e a tabela de produtos conforme necessário.
3. Ajuste as credenciais de acesso no arquivo de conexão em `conexao/conexao.php`.
4. Acesse a página de cadastro pelo navegador.

## Observação

Este é um projeto de aprendizagem, então a estrutura e as funcionalidades podem ser ajustadas, expandidas e melhoradas conforme o aprendizado evolui.
