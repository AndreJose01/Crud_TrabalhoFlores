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
Descritivo: Inicializa a sessão e monta o cabeçalho HTML, o título, os estilos e o menu de navegação compartilhado.
******************************************************************************
*/

// Inicia a sessão somente se ela ainda não estiver ativa, permitindo usar mensagens temporárias entre páginas.
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <!-- Define a codificação da página para aceitar caracteres especiais e acentos. -->
    <meta charset="UTF-8">
    <!-- Configura a visualização responsiva para celulares e tablets. -->
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0"
    >

    <!-- Define o título da página usando a variável $titulo, ou um valor padrão caso ela não exista. -->
    <title>
      <?= htmlspecialchars($titulo ?? "CRUD Loja de Bebidas") ?>
    </title>

    <!-- Carrega o arquivo de estilos principal do sistema para aplicar a identidade visual. -->
    <link
      rel="stylesheet"
      href="/crud_loja_bebidas/assets/style.css"
    >
  </head>

  <body>
    <!-- Cria o cabeçalho fixo do sistema com a marca e o menu de navegação. -->
    <header class="topo">
      <div class="container topo-conteudo">
        <!-- Link para a página inicial da loja, exibindo o nome da marca. -->
        <a class="marca" href="/crud_loja_bebidas/index.php">
          Loja de Bebidas
        </a>

        <!-- Menu principal da aplicação com links para início, produtos e categorias. -->
        <nav>
          <a href="/crud_loja_bebidas/index.php">Início</a>
          <a href="/crud_loja_bebidas/produtos/index.php">Produtos</a>
          <a href="/crud_loja_bebidas/categorias/index.php">Categorias</a>
        </nav>
      </div>
    </header>

    <!-- Abre a área principal do conteúdo para inserir os módulos da página atual. -->
    <main class="container conteudo">
