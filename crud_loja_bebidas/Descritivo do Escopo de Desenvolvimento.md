# Descritivo do Escopo de Desenvolvimento

## Sistema CRUD para Loja de Bebidas

**Curso:** Tecnologia em Análise e Desenvolvimento de Sistemas  
**Disciplina:** Linguagem e Técnicas de Programação  
**Professor:** Flores  
**Turma:** ADS2A  
**Data:** 11 de Novembro de 2026

## 1. Finalidade do desenvolvimento

O projeto tem como finalidade desenvolver um sistema web para gerenciamento dos produtos e das categorias de uma loja de bebidas. A aplicação será construída em PHP, utilizando MySQL como banco de dados, e deverá disponibilizar as operações de cadastro, consulta, alteração e exclusão dos registros.

O sistema será desenvolvido para substituir o controle manual ou descentralizado das informações da loja por uma aplicação organizada, permitindo que os dados dos produtos sejam armazenados em um banco de dados e consultados por meio de páginas web.

## 2. Escopo da solução a ser desenvolvida

O desenvolvimento abrangerá a criação de uma aplicação CRUD com os seguintes módulos:

- página inicial do sistema;
- módulo de categorias;
- módulo de produtos;
- conexão com o banco de dados;
- script de criação e carga inicial do banco;
- estrutura visual em HTML e CSS;
- documentação de instalação, utilização e escopo.

A aplicação será executada em ambiente local utilizando Apache, PHP e MySQL, preferencialmente por meio do XAMPP.

## 3. Módulos do sistema

### 3.1 Página inicial

Será desenvolvida uma página inicial para apresentar o sistema e facilitar a navegação entre os módulos. A página exibirá informações resumidas, como a quantidade de produtos e categorias cadastrados.

Também serão disponibilizados links para acessar o cadastro e a consulta de produtos e categorias.

### 3.2 Módulo de categorias

O módulo de categorias será desenvolvido para organizar os tipos de bebidas comercializados pela loja.

As funcionalidades previstas são:

- listar as categorias cadastradas;
- cadastrar uma nova categoria;
- editar uma categoria existente;
- excluir uma categoria sem produtos vinculados;
- informar a quantidade de produtos associada a cada categoria.

Cada categoria possuirá um código primário, um nome e uma descrição opcional.

As categorias utilizadas na primeira versão são:

- Cervejas;
- Refrigerantes;
- Destilados;
- Sucos;
- Energéticos.

### 3.3 Módulo de produtos

O módulo de produtos será desenvolvido para controlar o catálogo e as informações básicas do estoque da loja.

As funcionalidades previstas são:

- listar os produtos cadastrados;
- cadastrar um novo produto;
- editar um produto existente;
- excluir um produto;
- selecionar uma categoria para o produto;
- exibir marca, preço, quantidade em estoque e validade;
- apresentar o nome da categoria relacionada ao produto.

Cada produto possuirá código gerado automaticamente, nome, marca, preço, quantidade em estoque, validade e código da categoria.

## 4. Estrutura do banco de dados

Será desenvolvido o banco de dados `loja_bebidas`, composto pelas tabelas `categorias` e `produtos`.

A tabela `categorias` terá os seguintes campos principais:

- `codigo_categoria`: chave primária da categoria;
- `nome`: nome da categoria;
- `descricao`: descrição da categoria.

A tabela `produtos` terá os seguintes campos principais:

- `codigo_produto`: chave primária gerada automaticamente;
- `nome`: nome do produto;
- `marca`: marca da bebida;
- `preco`: preço de venda;
- `quantidade_estoque`: quantidade disponível;
- `validade`: data de validade;
- `categoria_codigo`: chave estrangeira relacionada à tabela `categorias`.

O relacionamento será do tipo um para muitos. Uma categoria poderá possuir vários produtos, mas cada produto deverá pertencer a uma única categoria.

## 5. Atividades de desenvolvimento

O desenvolvimento do projeto compreenderá as seguintes atividades:

1. Definição das entidades e dos campos necessários.
2. Modelagem do relacionamento entre categorias e produtos.
3. Criação do script SQL do banco de dados.
4. Criação da conexão entre PHP e MySQL usando PDO.
5. Desenvolvimento da página inicial.
6. Desenvolvimento das telas de listagem, cadastro, edição e exclusão de categorias.
7. Desenvolvimento das telas de listagem, cadastro, edição e exclusão de produtos.
8. Implementação das consultas SQL para leitura e gravação dos dados.
9. Implementação da validação dos campos dos formulários.
10. Implementação das mensagens de sucesso e erro.
11. Desenvolvimento do layout visual com CSS.
12. Organização dos arquivos em pastas de configuração, páginas, componentes e banco de dados.
13. Realização de testes básicos das operações CRUD.
14. Elaboração da documentação do projeto.

## 6. Regras de desenvolvimento

Durante o desenvolvimento, serão aplicadas as seguintes regras:

- os campos obrigatórios deverão ser validados antes da gravação;
- os valores de preço não poderão ser negativos;
- a quantidade de estoque não poderá ser negativa;
- cada categoria deverá possuir um código único;
- cada categoria deverá possuir um nome único;
- todo produto deverá estar associado a uma categoria válida;
- os comandos SQL deverão utilizar consultas preparadas por meio do PDO;
- uma categoria não poderá ser excluída enquanto houver produtos associados;
- as mensagens apresentadas ao usuário deverão informar o resultado das operações;
- os dados exibidos nas páginas deverão ser tratados para evitar a inserção direta de HTML.

## 7. Requisitos funcionais

**RF01 —** O sistema deverá permitir visualizar a página inicial.  
**RF02 —** O sistema deverá permitir cadastrar categorias.  
**RF03 —** O sistema deverá permitir listar categorias.  
**RF04 —** O sistema deverá permitir editar categorias.  
**RF05 —** O sistema deverá permitir excluir categorias sem produtos vinculados.  
**RF06 —** O sistema deverá permitir cadastrar produtos.  
**RF07 —** O sistema deverá permitir listar produtos.  
**RF08 —** O sistema deverá permitir editar produtos.  
**RF09 —** O sistema deverá permitir excluir produtos.  
**RF10 —** O sistema deverá relacionar cada produto a uma categoria.  
**RF11 —** O sistema deverá exibir preço, estoque e validade dos produtos.  
**RF12 —** O sistema deverá informar erros de validação ou de operação.

## 8. Requisitos não funcionais

**RNF01 —** O sistema deverá ser desenvolvido em PHP.  
**RNF02 —** O sistema deverá utilizar banco de dados MySQL.  
**RNF03 —** A conexão com o banco deverá utilizar PDO.  
**RNF04 —** A interface deverá utilizar HTML e CSS.  
**RNF05 —** As páginas deverão ser organizadas em estrutura modular.  
**RNF06 —** O sistema deverá funcionar em um servidor Apache com PHP habilitado.  
**RNF07 —** O layout deverá permitir a visualização em telas menores.  
**RNF08 —** O código deverá ser acompanhado de comentários e documentação.

## 9. Tecnologias e ferramentas

- PHP;
- MySQL;
- PDO;
- HTML5;
- CSS3;
- Apache;
- XAMPP;
- phpMyAdmin;
- Git/GitHub para armazenamento e entrega do código-fonte.

## 10. Organização dos arquivos desenvolvidos

Os códigos foram organizados em pastas de acordo com a responsabilidade de cada parte do sistema. Essa divisão facilita a manutenção, a localização dos arquivos e a separação entre configuração, interface, regras de processamento e banco de dados.

```text
crud_loja_bebidas/
├── assets/
│   └── style.css
├── banco/
│   └── loja_bebidas.sql
├── categorias/
│   ├── cadastrar.php
│   ├── editar.php
│   ├── excluir.php
│   └── index.php
├── config/
│   └── conexao.php
├── includes/
│   ├── footer.php
│   └── header.php
├── produtos/
│   ├── cadastrar.php
│   ├── editar.php
│   ├── excluir.php
│   └── index.php
├── index.php
├── LEIA-ME.txt
└── DESCRITIVO_ESCOPO_DESENVOLVIMENTO.md
```

### `assets/`

A pasta `assets` armazena os arquivos responsáveis pela aparência visual do sistema. O arquivo `style.css` define cores, fontes, espaçamentos, tabelas, formulários, botões, mensagens e regras de adaptação para telas menores.

### `banco/`

A pasta `banco` contém o arquivo `loja_bebidas.sql`. Esse script cria o banco de dados, recria as tabelas, configura as chaves primárias e estrangeiras e insere os dados iniciais das categorias e dos produtos.

### `config/`

A pasta `config` contém o arquivo `conexao.php`, responsável por configurar e abrir a conexão entre o PHP e o banco de dados MySQL por meio do PDO. Os demais arquivos incluem esse arquivo sempre que precisam consultar ou alterar dados.

### `categorias/`

A pasta `categorias` concentra todos os códigos relacionados ao CRUD de categorias:

- `index.php`: consulta e lista as categorias cadastradas;
- `cadastrar.php`: exibe o formulário e grava uma nova categoria;
- `editar.php`: carrega e atualiza uma categoria existente;
- `excluir.php`: processa a exclusão de uma categoria.

### `produtos/`

A pasta `produtos` concentra todos os códigos relacionados ao CRUD de produtos:

- `index.php`: consulta e lista os produtos junto com suas categorias;
- `cadastrar.php`: exibe o formulário e grava um novo produto;
- `editar.php`: carrega e atualiza um produto existente;
- `excluir.php`: processa a exclusão de um produto.

### `includes/`

A pasta `includes` contém partes reutilizáveis das páginas. O arquivo `header.php` inicia a sessão, define o cabeçalho HTML, carrega o CSS e apresenta o menu de navegação. O arquivo `footer.php` encerra a página e exibe o rodapé.

### Arquivo `index.php`

O arquivo `index.php` localizado na raiz é a página inicial do sistema. Ele apresenta a tela de boas-vindas e consulta os totais de produtos e categorias para exibir um resumo da loja.

### Arquivos de documentação

O arquivo `LEIA-ME.txt` apresenta as instruções básicas de instalação e execução. O arquivo `DESCRITIVO_ESCOPO_DESENVOLVIMENTO.md` documenta o objetivo, o escopo, os requisitos, as regras e a organização do desenvolvimento.

### Fluxo de execução dos códigos

O fluxo básico de uma operação é o seguinte:

1. O usuário acessa uma página PHP pelo navegador.
2. A página inclui `config/conexao.php` para obter a conexão PDO.
3. O código valida os dados recebidos pelo formulário ou pela URL.
4. A página executa uma consulta preparada no banco MySQL.
5. O resultado é exibido utilizando o cabeçalho, o conteúdo da página e o rodapé.
6. Após uma inclusão, alteração ou exclusão, o usuário é redirecionado para a listagem correspondente.

## 11. Fora do escopo de desenvolvimento

Não serão desenvolvidos nesta versão:

- módulo de login e autenticação de usuários;
- níveis de permissão ou controle de acesso;
- cadastro de clientes;
- cadastro de fornecedores;
- módulo de vendas e carrinho de compras;
- integração com meios de pagamento;
- emissão de notas fiscais;
- sistema de delivery;
- atualização automática do estoque após uma venda;
- relatórios financeiros avançados;
- integração com serviços externos;
- aplicativo mobile;
- hospedagem em ambiente de produção.

Essas funcionalidades poderão ser analisadas e implementadas em uma etapa futura.

## 12. Entregas do desenvolvimento

Ao final do desenvolvimento, serão entregues:

- arquivos PHP do sistema;
- arquivo CSS da interface;
- script SQL de criação do banco;
- dados iniciais para teste;
- estrutura organizada de pastas;
- documentação de instalação e uso;
- descritivo do escopo de desenvolvimento;
- repositório contendo os códigos e demais arquivos do projeto.

## 13. Critérios de conclusão

O desenvolvimento será considerado concluído quando:

1. O banco puder ser criado por meio do script SQL.
2. O sistema conseguir se conectar ao banco MySQL.
3. O módulo de categorias executar as operações de cadastro, consulta, edição e exclusão.
4. O módulo de produtos executar as operações de cadastro, consulta, edição e exclusão.
5. O relacionamento entre produtos e categorias funcionar corretamente.
6. Os campos de preço, estoque e validade forem armazenados e exibidos.
7. As validações básicas impedirem dados inválidos.
8. A exclusão de categorias vinculadas a produtos for impedida.
9. As páginas apresentarem navegação e layout consistentes.
10. O código-fonte e a documentação estiverem organizados no repositório.

## 14. Resultado esperado

O resultado esperado é uma aplicação web CRUD funcional para o gerenciamento de uma loja de bebidas. O sistema deverá permitir o controle básico do catálogo, das categorias e das informações de estoque, utilizando uma estrutura simples, organizada e adequada aos objetivos da disciplina de Linguagem e Técnicas de Programação.
