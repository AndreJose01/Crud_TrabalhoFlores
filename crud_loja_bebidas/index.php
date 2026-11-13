<?php
/*
******************************************************************************
Curso: Tecnologia em Análise e Desenvolvimento de Sistemas
Disciplina: Linguagem e Técnicas de Programação
Professor: Flores
Turma: ADS2A
Componentes:
 26007590-2 - Ana Carolyne Basiewics Sprada
 26013429-2 - Andre Jose Rosa Neto
 26003158-2 - Pamela Gabriele Pereira
 26005480-2 - Paulo Henrique Sordo Carlim
 26011000-2 - Pedro Henrique Damazio de Arruda
 26013857-2 - Pedro Leonardo de Assis Barbosa
 26007980-2 - Victor Hugo Gonçalves dos Santos
Data: 11 de Novembro de 2026
Descritivo: Apresenta a página inicial do sistema com os cartões de resumo de produtos e categorias.
******************************************************************************
*/

// Importa a conexão com o banco de dados para consultar totais de registros.
require_once __DIR__ . "/config/conexao.php";

// Define o título da página exibido no navegador e no layout do sistema.
$titulo = "Início | Loja de Bebidas";

// Conta quantos produtos existem cadastrados no banco.
$totalProdutos = (int) $pdo
  ->query("SELECT COUNT(*) FROM produtos")
  ->fetchColumn();

// Conta quantas categorias existem cadastradas no banco.
$totalCategorias = (int) $pdo
  ->query("SELECT COUNT(*) FROM categorias")
  ->fetchColumn();

// Inclui o cabeçalho compartilhado da aplicação.
require __DIR__ . "/includes/header.php";
?>

<?php
// Exibe a área de boas-vindas com a mensagem inicial do sistema.
?>
<section class="boas-vindas">
  <span class="etiqueta">
    Sistema de gerenciamento
  </span>

  <h1>Bem-vindo ao CRUD da Loja de Bebidas</h1>

  <p>
    Gerencie os produtos e as categorias da loja em um só lugar.
  </p>
</section>

<?php
// Cria os cartões de resumo com os totais de produtos e categorias cadastrados.
?>
<section class="cards">
  <article class="card">
    <p class="card-legenda">
      Produtos cadastrados
    </p>

    <strong><?= $totalProdutos ?></strong>

    <!-- Link para acessar a listagem e gestão de produtos. -->
    <a href="produtos/index.php">
      Gerenciar produtos →
    </a>
  </article>

  <article class="card">
    <p class="card-legenda">
      Categorias cadastradas
    </p>

    <strong><?= $totalCategorias ?></strong>

    <!-- Link para acessar a listagem e gestão de categorias. -->
    <a href="categorias/index.php">
      Gerenciar categorias →
    </a>
  </article>
</section>

<?php
// Exibe atalhos rápidos para criar novos registros no sistema.
?>
<section class="atalhos">
  <h2>Acesso rápido</h2>

  <!-- Link para abrir o formulário de cadastro de produto. -->
  <a class="botao" href="produtos/cadastrar.php">
    + Cadastrar produto
  </a>

  <!-- Link para abrir o formulário de cadastro de categoria. -->
  <a class="botao secundario" href="categorias/cadastrar.php">
    + Cadastrar categoria
  </a>
</section>

<?php
// Inclui o rodapé da página para fechar o layout da aplicação.
require __DIR__ . "/includes/footer.php";
?>

