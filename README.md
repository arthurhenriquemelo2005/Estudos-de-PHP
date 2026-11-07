# 🐘 Estudos de PHP

Repositório onde registro minha evolução em **PHP e desenvolvimento web** durante o curso técnico de **Desenvolvimento de Sistemas**: dos primeiros formulários até sistemas completos com login e banco de dados.

---

## 📚 Estudos

**Cursos**
- Curso de PHP do **Gustavo Guanabara (Curso em Vídeo)**
- Unidades curriculares do curso técnico de Desenvolvimento de Sistemas

**Documentação**
- [Manual oficial do PHP](https://www.php.net/manual/pt_BR/): referência de funções, sintaxe e boas práticas
- [PHP: The Right Way](https://phptherightway.com/): guia de boas práticas da linguagem

---

## Projetos principais

- **[Assistência Técnica](./projeto1)**: CRUD de clientes, equipamentos, técnicos e serviços, com login e perfis de usuário.
- **[EcoPoint](./projeto2)**: gerenciamento de participantes e agendamentos de coleta, com busca por status.
- **[Pizzaria do BernaShow](./projeto3)**: clientes, pedidos e status de pedido, com acesso por perfil (`ADMIN` / `ATENDENTE`).
- **[Locadora de filmes](./exSaep)**: filmes, clientes e empréstimos, rodando com **Docker**.

Também há CRUDs menores (alunos e produtos), exercícios de fundamentos, uma **Pokédex** que consome a PokéAPI e um projeto com **Composer + Guzzle** para cotação de moedas.

---

## O que já pratiquei

- Formulários com `$_GET` e `$_POST`
- Arrays, condicionais e laços de repetição
- CRUD completo com MySQL e **PDO** (*prepared statements*)
- Login com sessões, cookies e `password_hash`
- Controle de acesso por perfil
- Relacionamentos entre tabelas e `JOIN`
- Consumo de APIs com cURL e Guzzle
- Composer e Docker

---

## 🛠️ Tecnologias

PHP · MySQL · HTML · CSS · JavaScript · Bootstrap · Composer · Docker · XAMPP · Git

---

## Como executar

**Com XAMPP**

1. Clone o repositório dentro de `htdocs`.
2. Inicie o Apache e o MySQL.
3. Crie o banco no phpMyAdmin e ajuste as credenciais no `conexao.php` do projeto.
4. Acesse `http://localhost/Estudos-de-PHP/<projeto>`.

**Com Docker** (projeto `exSaep`)

```bash
cd exSaep
docker compose up --build
```

Acesse `http://localhost:8080`.

---

## 🚧 Próximos passos

- Adicionar os scripts SQL dos projetos
- Usar variáveis de ambiente (`.env`) para credenciais
- Estudar orientação a objetos e MVC
- Criar um projeto com Laravel

---

## 👨‍💻 Autor

**Arthur Ribeiro**, estudante de Desenvolvimento de Sistemas
[GitHub](https://github.com/arthurhenriquemelo2005)
