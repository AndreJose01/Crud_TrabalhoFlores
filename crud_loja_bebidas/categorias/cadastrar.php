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
Descritivo: Exibe e processa o formulário de cadastro de uma nova categoria de bebidas.
******************************************************************************
*/

// Importa a conexão com o banco de dados para acessar a variável $pdo e realizar operações no banco.
require_once __DIR__ . "/../config/conexao.php";

// Define o título da página para ser exibido no layout da aplicação.
$titulo = "Cadastrar categoria";
// Inicializa a variável de erro para mostrar mensagens de validação ao usuário.
$erro = "";

// Verifica se a página foi acessada por meio de envio de formulário via método POST.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Captura e valida o código da categoria enviado no formulário, convertendo para inteiro.
  $codigo = filter_input(INPUT_POST, "codigo_categoria", FILTER_VALIDATE_INT);
  // Obtém o nome digitado e remove espaços extras no início e no fim.
  $nome = trim($_POST["nome"] ?? "");
  // Obtém a descrição digitada e remove espaços extras.
  $descricao = trim($_POST["descricao"] ?? "");

  // Valida se o código foi informado corretamente e se o nome não ficou vazio.
  if (!$codigo || $nome === "") {
    // Define a mensagem de erro para o usuário preencher os dados obrigatórios.
    $erro = "Informe um código numérico e o nome da categoria.";
  } else {
    try {
      // Prepara a instrução SQL para inserir a categoria na tabela categorias.
      $stmt = $pdo->prepare(
        "INSERT INTO categorias (codigo_categoria, nome, descricao) VALUES (?, ?, ?)"
      );

      // Executa a inserção dos dados, convertendo descrição vazia em null para respeitar a regra do banco.
      $stmt->execute([$codigo, $nome, $descricao ?: null]);

      // Armazena uma mensagem de sucesso na sessão para exibir na próxima página.
      $_SESSION["mensagem"] = "Categoria cadastrada com sucesso!";

      // Redireciona o usuário para a página de listagem de categorias.
      header("Location: index.php");
      // Interrompe a execução do script para evitar que o restante da página continue.
      exit;
    } catch (PDOException $e) {
      // Captura erros de banco, como código ou nome duplicado, e exibe uma mensagem amigável.
      $erro =
        "Não foi possível cadastrar. Verifique se o código ou nome já existe.";
    }
  }
}

// Inclui o cabeçalho do sistema para manter o padrão visual da aplicação.
require __DIR__ . "/../includes/header.php";
?>

<?php
// Exibe o título da página de cadastro para o usuário.
?>
<h1>Cadastrar categoria</h1>

<?php if ($erro): ?>
  <!-- Mostra uma mensagem de erro caso os dados enviados sejam inválidos ou o cadastro falhe. -->
  <div class="alerta erro">
    <?= htmlspecialchars($erro) ?>
  </div>
<?php endif; ?>

<?php
// Cria o formulário responsável por receber os dados da nova categoria.
?>
<form class="formulario" method="post">
  <label>
    <!-- Define o campo para informar o código da categoria. -->
    Código da categoria
    <input
      type="number"
      name="codigo_categoria"
      min="1"
      required
      value="<?= htmlspecialchars($_POST["codigo_categoria"] ?? "") ?>"
    >
  </label>

  <label>
    <!-- Define o campo para informar o nome da categoria. -->
    Nome
    <input
      name="nome"
      maxlength="60"
      required
      value="<?= htmlspecialchars($_POST["nome"] ?? "") ?>"
    >
  </label>

  <label>
    <!-- Define o campo opcional para descrever a categoria. -->
    Descrição
    <textarea
      name="descricao"
      maxlength="255"
      rows="3"
    ><?= htmlspecialchars($_POST["descricao"] ?? "") ?></textarea>
  </label>

  <div class="botoes">
    <!-- Cria o botão que envia o formulário para salvar a categoria. -->
    <button class="botao" type="submit">
      Salvar categoria
    </button>

    <!-- Cria o link para cancelar o cadastro e voltar para a listagem. -->
    <a class="botao secundario" href="index.php">
      Cancelar
    </a>
  </div>
</form>

<?php
// Inclui o rodapé da página para finalizar o layout da aplicação.
require __DIR__ . "/../includes/footer.php";
?>
