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
Descritivo: Processa a exclusão de um produto pelo código e redireciona para a listagem.
******************************************************************************
*/

// Importa a conexão com o banco para permitir a exclusão do produto.
require_once __DIR__ . "/../config/conexao.php";

// Verifica se a requisição veio por método POST, indicando envio do formulário de exclusão.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Captura e valida o ID do produto enviado no formulário.
  $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

  // Se o ID for válido, realiza a exclusão do produto no banco.
  if ($id) {
    // Prepara a instrução SQL para apagar o produto pelo código.
    $stmt = $pdo->prepare(
      "DELETE FROM produtos WHERE codigo_produto = ?"
    );

    // Executa a exclusão do produto informado.
    $stmt->execute([$id]);

    // Salva uma mensagem de sucesso na sessão para mostrar após o redirect.
    $_SESSION["mensagem"] = "Produto excluído com sucesso.";
  }
}

// Redireciona o usuário de volta para a listagem de produtos após a operação.
header("Location: index.php");
exit;
