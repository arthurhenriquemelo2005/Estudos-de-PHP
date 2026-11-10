# 🍰 Doce Encanto — Sistema de Gerenciamento de Encomendas

Sistema web desenvolvido para gerenciamento de encomendas de uma confeitaria, com funcionalidades de cadastro de clientes, controle de pedidos, cálculo automático de valores e programa de fidelidade baseado em pontos.

O projeto tem como objetivo aplicar conceitos de desenvolvimento web, modelagem de banco de dados, lógica de negócio e persistência de dados.

## 🎯 Objetivo do Projeto

Desenvolver uma aplicação que facilite o gerenciamento das encomendas da confeitaria, automatizando cálculos financeiros, aplicação de descontos e controle do programa de fidelidade **Doce Pontos**.

## ⚙️ Funcionalidades planejadas

- Cadastro e gerenciamento de clientes.
- Registro e acompanhamento de encomendas.
- Controle de categorias e preços dos produtos.
- Cálculo automático do valor bruto e líquido.
- Aplicação de taxa de urgência.
- Aplicação de cupons de desconto.
- Acúmulo e resgate de Doce Pontos.
- Identificação automática do Combo Festa.
- Histórico de encomendas e movimentações de pontos.
- Painel administrativo para gerenciamento dos pedidos.

## 📋 Regras de Negócio

### RN01 — Dados obrigatórios da encomenda

Todo pedido deverá conter:
- Nome do cliente.
- Telefone de contato.
- Data de retirada.
- Categoria do item.
- Quantidade.

### RN02 — Antecedência e taxa de urgência

Pedidos de bolos confeitados exigem antecedência mínima de 2 dias.

Pedidos com prazo inferior poderão ser bloqueados ou receber uma taxa de urgência de 15% sobre o valor bruto, conforme a política definida pela confeitaria.

### RN03 — Formação do valor bruto

O cálculo deverá respeitar rigorosamente a tabela de preços:

| Produto | Preço | Pedido mínimo |
|---|---:|---:|
| Bolo tradicional | R$ 65,00/kg | 1 kg |
| Bolo especial/festa | R$ 90,00/kg | 1,5 kg |
| Bolo tradicional (cento) | R$ 110,00/cento | 50 unidades |
| Doces finos (cento) | R$ 160,00/cento | 50 unidades |

### RN04 — Programa de fidelidade Doce Pontos

A cada R$ 10,00 completos pagos no valor líquido da encomenda, o cliente recebe 1 Doce Ponto.

Encomendas que contenham simultaneamente pelo menos 2 kg de bolo e 1 cento de doces recebem um bônus adicional de 5 pontos (Combo Festa).

### RN05 — Resgate de pontos por cupons

O cliente poderá trocar seus pontos por descontos:

| Cupom | Pontos necessários | Desconto |
|---|---:|---:|
| Degustação | 10 | R$ 15,00 |
| Festa Doce | 20 | R$ 35,00 |
| Mestre Confeiteiro | 35 | R$ 70,00 |

Restrições:
- Apenas um cupom por encomenda.
- O valor líquido nunca poderá ser negativo.
- O valor bruto da encomenda deverá ser de, no mínimo, R$ 50,00.
- Os pontos utilizados serão descontados do saldo do cliente.

## 🗄️ Banco de Dados

O projeto utiliza o banco de dados relacional **MySQL**, composto por sete tabelas:

| Tabela | Responsabilidade |
|---|---|
| `clientes` | Cadastro de clientes e saldo de pontos |
| `categorias` | Produtos, preços e quantidades mínimas |
| `encomendas` | Dados gerais e valores dos pedidos |
| `itens_encomenda` | Itens associados a cada encomenda |
| `cupons` | Cadastro dos cupons de fidelidade |
| `historico_cupons` | Registro dos cupons utilizados |
| `historico_doce_pontos` | Histórico de créditos, débitos e estornos |

### Diagrama Entidade-Relacionamento (DER)

O diagrama abaixo representa a estrutura do banco de dados do Doce Encanto, apresentando as sete entidades, seus atributos e os relacionamentos estabelecidos por meio de chaves primárias e estrangeiras.

<img width="872" height="951" alt="Captura de tela 2026-11-10 154534" src="https://github.com/user-attachments/assets/9a5f7045-7005-4402-a620-b44f73322bcf" />


### Relacionamentos

- Clientes possuem várias encomendas.
- Encomendas possuem vários itens.
- Categorias podem estar presentes em vários itens de encomendas.
- Encomendas podem possuir um cupom aplicado.
- Clientes possuem um histórico de movimentações de pontos.
- Encomendas podem gerar movimentações de pontos.

## 🛠️ Tecnologias

- PHP — Desenvolvimento Back-end.
- MySQL — Gerenciamento do banco de dados.
- PDO — Comunicação entre PHP e banco de dados.
- HTML5 — Estrutura das páginas.
- CSS3 — Estilização.
- JavaScript — Interatividade.
- Bootstrap — Construção da interface.
- XAMPP — Ambiente de desenvolvimento local.

## 📁 Estrutura do Projeto

```text
doce-encanto/
│
├── assets/
│   ├── css/
│   ├── js/
│   └── imagens/
│
├── config/
│   └── conexao.php
│
├── database/
│   └── db_doceecanto.sql
│
├── docs/
│   └── der-doce-encanto.png
│
├── clientes/
├── encomendas/
├── cupons/
├── admin/
│
├── index.php
└── README.md
```

*Estrutura prevista para organização dos arquivos durante o desenvolvimento.*

## 🚀 Instalação

1. Instale o XAMPP.
2. Inicie os serviços Apache e MySQL.
3. Clone ou copie o projeto para a pasta `htdocs`.
4. Acesse o phpMyAdmin.
5. Importe o arquivo `database/db_doceecanto.sql`.
6. Configure a conexão com o banco de dados em `config/conexao.php`.
7. Acesse o projeto pelo navegador:

```text
http://localhost/doce-encanto/
```

## 📚 Conceitos aplicados

- Modelagem de banco de dados relacional.
- Chaves primárias e estrangeiras.
- Integridade referencial.
- Operações CRUD.
- Consultas SQL e relacionamentos com JOIN.
- Validação de dados.
- Regras de negócio.
- Transações com PDO.
- Controle de saldo e histórico de movimentações.

## Status do Projeto

🚧 Em desenvolvimento.

---

**Doce Encanto** — Gerenciamento de encomendas e fidelização de clientes.
