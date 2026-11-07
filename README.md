# 🐘 Estudos de PHP

Repositório dedicado ao registro da minha evolução em **PHP e desenvolvimento web** durante minha formação em Desenvolvimento de Sistemas.

Aqui reúno estudos, exercícios e práticas que fazem parte da minha jornada de aprendizado, desde os fundamentos da linguagem até o desenvolvimento de aplicações web com integração a bancos de dados, autenticação e consumo de APIs.

Meu objetivo é compreender não apenas como desenvolver aplicações, mas também como funciona a comunicação entre cliente, servidor e banco de dados.

---

##  Estudos e referências

### Cursos
- Curso de PHP do **Gustavo Guanabara — Curso em Vídeo**.
- Unidades curriculares do curso técnico de Desenvolvimento de Sistemas.

### Documentação e materiais de consulta
- [Manual oficial do PHP](https://www.php.net/manual/pt_BR/) — referência oficial de sintaxe, funções e recursos da linguagem.
- [W3Schools — PHP Tutorial](https://www.w3schools.com/php/) — conteúdos e exemplos práticos para consulta.
- [PHP: The Right Way](https://phptherightway.com/) — boas práticas e recomendações para desenvolvimento com PHP.

---

##  Projetos e práticas

Ao longo dos estudos, desenvolvo aplicações para colocar em prática os conceitos aprendidos:

- **Assistência Técnica:** gerenciamento de clientes, equipamentos, técnicos e serviços, com autenticação e controle de acesso por perfil.
- **EcoPoint:** sistema de gerenciamento de participantes e agendamentos de coleta, com controle de status.
- **Pizzaria do BernaShow:** gerenciamento de clientes, pedidos e acompanhamento de status, com diferentes níveis de acesso (`ADMIN` e `ATENDENTE`).
- **Locadora de Filmes:** gerenciamento de filmes, clientes e empréstimos, com ambiente configurado utilizando Docker.

Também desenvolvo projetos menores, como CRUDs de alunos e produtos, exercícios de lógica e fundamentos e práticas com Composer e Guzzle para consumo de APIs.

---

## 📈 Conhecimentos praticados

- Fundamentos da linguagem PHP.
- Formulários e superglobais (`$_GET`, `$_POST` e `$_SESSION`).
- Arrays, funções, condicionais e estruturas de repetição.
- Operações CRUD com MySQL.
- Conexão com banco de dados utilizando PDO.
- Consultas preparadas (*Prepared Statements*).
- Autenticação, sessões e cookies.
- Criptografia de senhas com `password_hash()`.
- Controle de acesso por perfil de usuário.
- Relacionamentos entre tabelas e consultas com `JOIN`.
- Consumo de APIs com cURL e Guzzle.
- Gerenciamento de dependências com Composer.
- Ambientes de desenvolvimento com Docker.

---

## 🛠️ Tecnologias e ferramentas

**Back-End**

PHP · MySQL

**Front-End**

HTML5 · CSS3 · JavaScript · Bootstrap

**Ferramentas**

Composer · Docker · XAMPP · Git · GitHub

---

## Como executar os projetos

### Utilizando XAMPP

1. Clone o repositório dentro da pasta `htdocs` do XAMPP.
2. Inicie os serviços Apache e MySQL.
3. Crie o banco de dados necessário para o projeto utilizando o phpMyAdmin.
4. Configure as credenciais de conexão no arquivo `conexao.php`.
5. Acesse o projeto pelo navegador:

```text
http://localhost/Estudos-de-PHP/
```

### Utilizando Docker

Para executar o projeto `exSaep`:

```bash
cd exSaep
docker compose up --build
```

Acesse:

```text
http://localhost:8080
```

---

## Próximos passos

- Adotar variáveis de ambiente (`.env`) para configurações sensíveis.
- Aprofundar os estudos em Programação Orientada a Objetos (POO).
- Estudar arquitetura MVC e padrões de projeto.
- Desenvolver aplicações com Laravel.
- Aprimorar boas práticas, segurança e organização de código.

---

## 👨‍💻 Autor

**Arthur Ribeiro**

Estudante de Desenvolvimento de Sistemas, com foco em desenvolvimento Back-End e aprofundamento em PHP.

- [GitHub](https://github.com/arthurhenriquemelo2005)
- [LinkedIn](https://www.linkedin.com/in/arthur-ribeiro-0b1bb6388/)

---

*Este repositório está em constante atualização, acompanhando minha evolução nos estudos e na prática do desenvolvimento web.*
