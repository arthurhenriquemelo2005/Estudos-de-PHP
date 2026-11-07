# 📁 Estudos de Envio de Arquivos com PHP

Esta pasta reúne exercícios práticos desenvolvidos para estudar o envio, o recebimento e o armazenamento de arquivos utilizando **HTML e PHP**.

O objetivo é compreender como os formulários enviam arquivos ao servidor, como o PHP recebe esses dados e como os arquivos podem ser armazenados no projeto.

## Formulários

### 1. Formulário inicial

Arquivos: `index.html` e `imagem.php`

Primeira prática de envio de imagens utilizando formulários HTML e processamento com PHP.

**Objetivo dos estudos:**
- Compreender como um formulário envia uma imagem.
- Conhecer a variável superglobal `$_FILES`.
- Entender o processamento de arquivos no PHP.

### 2. Formulário de envio de imagens

Pasta: `formulario2/`

Arquivos: `index.html` e `imagem.php`

Exercício voltado ao envio e processamento de imagens, explorando a transferência do arquivo do formulário HTML para o servidor e seu armazenamento na pasta `uploads/`.

**Objetivo dos estudos:**
- Trabalhar com `enctype="multipart/form-data"`.
- Acessar informações do arquivo através de `$_FILES`.
- Utilizar `move_uploaded_file()` para armazenar imagens.
- Trabalhar com caminhos de arquivos no PHP.

### 3. Formulário de envio de arquivos com validação

Pasta: `formulario3/`

Arquivos: `index.html` e `salvarArquivo.php`

Exercício que amplia os estudos de upload, trabalhando com o recebimento de arquivos e a aplicação de validações no processamento realizado pelo PHP.

**Objetivo dos estudos:**
- Receber arquivos enviados pelo formulário.
- Trabalhar com a variável `$_FILES`.
- Aplicar validações antes de armazenar os arquivos.
- Utilizar `move_uploaded_file()` para salvar os arquivos no servidor.
- Compreender a importância de verificar os arquivos recebidos.

## Diferenças entre os formulários

| Formulário | Foco principal |
|---|---|
| Inicial | Primeiros conceitos de envio de imagens. |
| Formulário 2 | Processamento e armazenamento de imagens. |
| Formulário 3 | Envio de arquivos com validação. |

## 🛠️ Tecnologias e recursos utilizados

- HTML5
- PHP
- Formulários HTML
- `enctype="multipart/form-data"`
- `$_FILES`
- `move_uploaded_file()`
- Armazenamento de arquivos em pastas locais.

## Objetivo geral

Registrar a evolução prática dos estudos sobre upload de arquivos com PHP, compreendendo desde o envio pelo formulário HTML até o processamento e armazenamento no servidor.
