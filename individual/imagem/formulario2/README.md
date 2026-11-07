# 📂 Formulários HTML e Envio de Arquivos com PHP

Este projeto faz parte dos meus estudos de **PHP e desenvolvimento web**. O objetivo é compreender, na prática, como funciona o envio de arquivos por meio de formulários HTML e como o PHP recebe e processa esses arquivos no servidor.

A proposta é explorar o funcionamento do envio de arquivos, desde a construção do formulário até o armazenamento dos arquivos enviados.

## Objetivo

Entender como HTML e PHP trabalham juntos para permitir que um usuário envie arquivos para uma aplicação web.

## Conceitos estudados

- **HTML Forms:** criação de formulários para envio de arquivos.
- **`method="POST"`:** envio de dados ao servidor por meio de requisições HTTP.
- **`enctype="multipart/form-data"`:** configuração necessária para permitir o envio de arquivos pelo formulário.
- **`input type="file"`:** campo utilizado para selecionar arquivos no computador.
- **`$_FILES`:** superglobal do PHP responsável por disponibilizar informações sobre os arquivos enviados.
- **`move_uploaded_file()`:** função utilizada para mover um arquivo recebido para o diretório de destino.
- **Manipulação de diretórios:** organização e armazenamento dos arquivos enviados.

## 🛠️ Tecnologias utilizadas

- HTML5
- PHP
- CSS
- XAMPP

## 📁 Estrutura do projeto

```text
formulario2/
├── uploads/
├── imagem.php
└── index.html
```

- `index.html`: formulário HTML utilizado para selecionar e enviar arquivos.
- `imagem.php`: responsável pelo processamento do arquivo recebido.
- `uploads/`: diretório destinado ao armazenamento dos arquivos enviados.

## Executando o projeto

1. Inicie o Apache pelo XAMPP.
2. Coloque o projeto dentro do diretório `htdocs`.
3. Acesse pelo navegador:

```text
http://localhost/individual/imagem/formulario2/
```

4. Selecione um arquivo no formulário e envie para testar o processamento em PHP.

## 🔐 Próximos aprendizados

Além de entender o funcionamento básico do envio de arquivos, pretendo aprofundar os estudos em:

- Validação de extensões permitidas.
- Verificação do tamanho dos arquivos.
- Validação do tipo MIME.
- Tratamento de erros durante o upload.
- Geração de nomes únicos para os arquivos.
- Boas práticas de segurança no armazenamento de arquivos.

---

**Objetivo principal:** aprender como os dados e arquivos enviados por um formulário percorrem o caminho entre o navegador, o servidor e o armazenamento da aplicação.