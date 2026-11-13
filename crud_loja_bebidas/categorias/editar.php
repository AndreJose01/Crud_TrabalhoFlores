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
Descritivo: Carrega uma categoria existente e processa a atualização de seu nome e descrição.
******************************************************************************
*/

// Importa a conexão com o banco de dados para usar a variável $pdo.
require_once __DIR__ . "/../config/conexao.php";

// Captura o ID da categoria enviada pela URL e valida se é um número inteiro válido.
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

// Se o ID não existir ou for inválido, redireciona para a página inicial.
if (!$id) {
  header("Location: index.php");
  exit;
}

// Prepara a consulta para buscar a categoria pelo código informado.
$stmt = $pdo->prepare(
  "SELECT * FROM categorias WHERE codigo_categoria = ?"
);

// Executa a busca da categoria no banco.
$stmt->execute([$id]);
// Armazena os dados da categoria encontrada.
$categoria = $stmt->fetch();

// Se a categoria não existir, retorna para a página principal.
if (!$categoria) {
  header("Location: index.php");
  exit;
}

// Define o título da página e a variável de erro para feedback ao usuário.
$titulo = "Editar categoria";
$erro = "";

// Verifica se o formulário foi enviado via método POST para atualizar a categoria.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Obtém o nome informado e remove espaços extras.
  $nome = trim($_POST["nome"] ?? "");
  // Obtém a descrição informada e remove espaços extras.
  $descricao = trim($_POST["descricao"] ?? "");

  // Valida se o nome foi preenchido.
  if ($nome === "") {
    // Define a mensagem de erro caso o nome esteja vazio.
    $erro = "Informe o nome da categoria.";
  } else {
    try {
      // Prepara a instrução SQL para atualizar nome e descrição da categoria.
      $up = $pdo->prepare(
        "UPDATE categorias SET nome=?, descricao=? WHERE codigo_categoria=?"
      );

      // Executa a atualização com os novos valores.
      $up->execute([$nome, $descricao ?: null, $id]);

      // Salva uma mensagem de sucesso na sessão para exibir depois do redirect.
      $_SESSION["mensagem"] = "Categoria atualizada com sucesso!";

      // Redireciona para a página principal após salvar a atualização.
      header("Location: index.php");
      exit;
    } catch (PDOException $e) {
      // Captura erros de banco, como nome duplicado, e informa ao usuário.
      $erro =
        "Não foi possível atualizar. Verifique se o nome já está sendo utilizado.";
    }
  }
}

// Define os valores do formulário com os dados enviados em POST ou com os dados atuais da categoria.
$valores = $_POST ?: $categoria;

// Inclui o cabeçalho do sistema.
require __DIR__ . "/../includes/header.php";
?>

<?php
// Exibe o título da página de edição da categoria.
?>
<h1>Editar categoria</h1>

<?php if ($erro): ?>
  <!-- Exibe a mensagem de erro caso a validação falhe ou a atualização não seja possível. -->
  <div class="alerta erro">
    <?= htmlspecialchars($erro) ?>
  </div>
<?php endif; ?>

<?php
// Cria o formulário para editar os dados da categoria selecionada.
?>
<form class="formulario" method="post">
  <label>
    <!-- Mostra o código da categoria em um campo somente leitura. -->
    Código da categoria
    <input
      value="<?= (int) $categoria["codigo_categoria"] ?>"
      disabled
    >
  </label>

  <label>
    <!-- Campo para alterar o nome da categoria. -->
    Nome
    <input
      name="nome"
      maxlength="60"
      required
      value="<?= htmlspecialchars($valores["nome"]) ?>"
    >
  </label>

  <label>
    <!-- Campo para alterar a descrição da categoria. -->
    Descrição
    <textarea
      name="descricao"
      maxlength="255"
      rows="3"
    ><?= htmlspecialchars($valores["descricao"] ?? "") ?></textarea>
  </label>

  <div class="botoes">
    <!-- Botão para enviar as alterações para o banco de dados. -->
    <button class="botao" type="submit">
      Salvar alterações
    </button>

    <!-- Link para voltar à listagem sem salvar alterações. -->
    <a class="botao secundario" href="index.php">
      Cancelar
    </a>
  </div>
</form>

<?php
// Inclui o rodapé da aplicação para encerrar o layout da página.
require __DIR__ . "/../includes/footer.php";
?>

