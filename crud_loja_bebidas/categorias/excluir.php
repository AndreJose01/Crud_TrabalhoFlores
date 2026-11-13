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
Descritivo: Processa a exclusão de uma categoria e informa quando ela possui produtos vinculados.
******************************************************************************
*/

// Importa a conexão com o banco para executar a exclusão da categoria.
require_once __DIR__ . "/../config/conexao.php";

// Verifica se a requisição foi feita por envio de formulário via POST.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Captura e valida o ID da categoria enviado no formulário.
  $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

  // Se o ID for válido, tenta remover a categoria do banco.
  if ($id) {
    try {
      // Prepara a instrução SQL para excluir a categoria pelo código.
      $stmt = $pdo->prepare(
        "DELETE FROM categorias WHERE codigo_categoria = ?"
      );

      // Executa a exclusão no banco de dados.
      $stmt->execute([$id]);

      // Salva uma mensagem de sucesso na sessão para exibir na página seguinte.
      $_SESSION["mensagem"] = "Categoria excluída com sucesso.";
    } catch (PDOException $e) {
      // Se houver relacionamento com produtos, exibe uma mensagem informando o impedimento.
      $_SESSION["mensagem"] =
        "Não foi possível excluir: existem produtos vinculados a esta categoria.";
    }
  }
}

// Redireciona o usuário de volta para a página principal após o processamento.
header("Location: index.php");
exit;
