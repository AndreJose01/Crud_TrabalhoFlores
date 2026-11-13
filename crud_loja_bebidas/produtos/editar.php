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
Descritivo: Carrega um produto existente e processa a atualização de seus dados e de sua categoria.
******************************************************************************
*/

// Importa a conexão com o banco de dados para acessar a variável $pdo.
require_once __DIR__ . "/../config/conexao.php";

// Captura o ID do produto vindo pela URL e valida se é um número inteiro válido.
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

// Se o ID não for informado ou for inválido, volta para a listagem de produtos.
if (!$id) {
  header("Location: index.php");
  exit;
}

// Prepara a consulta para buscar o produto pelo código informado.
$stmt = $pdo->prepare(
  "SELECT * FROM produtos WHERE codigo_produto = ?"
);

// Executa a busca do produto no banco.
$stmt->execute([$id]);
// Armazena os dados do produto encontrado.
$produto = $stmt->fetch();

// Se o produto não existir, redireciona para a página inicial.
if (!$produto) {
  header("Location: index.php");
  exit;
}

// Busca todas as categorias para preencher o select de categoria na edição.
$categorias = $pdo
  ->query(
    "SELECT codigo_categoria, nome FROM categorias ORDER BY nome"
  )
  ->fetchAll();

// Define o título da página e a variável para mensagens de erro.
$titulo = "Editar produto";
$erro = "";

// Verifica se o formulário foi enviado via POST para atualizar o produto.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Obtém e prepara os dados enviados no formulário.
  $nome = trim($_POST["nome"] ?? "");
  $marca = trim($_POST["marca"] ?? "");
  $preco = str_replace(",", ".", trim($_POST["preco"] ?? ""));
  $estoque = $_POST["quantidade_estoque"] ?? "";
  $validade = $_POST["validade"] ?? "";
  $categoria = $_POST["categoria_codigo"] ?? "";

  // Valida todos os campos obrigatórios antes de atualizar.
  if (
    $nome === "" ||
    $marca === "" ||
    !is_numeric($preco) ||
    $preco < 0 ||
    filter_var($estoque, FILTER_VALIDATE_INT) === false ||
    $estoque < 0 ||
    $validade === "" ||
    filter_var($categoria, FILTER_VALIDATE_INT) === false
  ) {
    // Define uma mensagem de erro quando os campos forem inválidos.
    $erro = "Preencha todos os campos com valores válidos.";
  } else {
    // Prepara a instrução SQL para atualizar os dados do produto.
    $up = $pdo->prepare(
      "UPDATE produtos
       SET nome=?, marca=?, preco=?, quantidade_estoque=?, validade=?, categoria_codigo=?
       WHERE codigo_produto=?"
    );

    // Executa a atualização com os novos valores do produto.
    $up->execute([
      $nome,
      $marca,
      $preco,
      $estoque,
      $validade,
      $categoria,
      $id,
    ]);

    // Salva uma mensagem de sucesso na sessão.
    $_SESSION["mensagem"] = "Produto atualizado com sucesso!";

    // Redireciona para a listagem após a atualização.
    header("Location: index.php");
    exit;
  }
}

// Mantém os valores do formulário preenchidos com os dados enviados ou com os dados atuais.
$valores = $_POST ?: $produto;

// Inclui o cabeçalho do sistema.
require __DIR__ . "/../includes/header.php";
?>

<?php
// Exibe o título da página de edição do produto.
?>
<h1>Editar produto</h1>

<?php if ($erro): ?>
  <!-- Mostra a mensagem de erro caso a validação dos dados falhe. -->
  <div class="alerta erro">
    <?= htmlspecialchars($erro) ?>
  </div>
<?php endif; ?>

<?php
// Cria o formulário para editar os dados do produto.
?>
<form class="formulario" method="post">
  <label>
    <!-- Campo para alterar o nome do produto. -->
    Nome do produto
    <input
      name="nome"
      maxlength="150"
      required
      value="<?= htmlspecialchars($valores["nome"]) ?>"
    >
  </label>

  <label>
    <!-- Campo para alterar a marca do produto. -->
    Marca
    <input
      name="marca"
      maxlength="80"
      required
      value="<?= htmlspecialchars($valores["marca"]) ?>"
    >
  </label>

  <div class="grade-form">
    <label>
      <!-- Campo para atualizar o preço do produto. -->
      Preço (R$)
      <input
        type="number"
        name="preco"
        min="0"
        step="0.01"
        required
        value="<?= htmlspecialchars((string) $valores["preco"]) ?>"
      >
    </label>

    <label>
      <!-- Campo para atualizar a quantidade em estoque. -->
      Quantidade em estoque
      <input
        type="number"
        name="quantidade_estoque"
        min="0"
        required
        value="<?= htmlspecialchars((string) $valores["quantidade_estoque"]) ?>"
      >
    </label>
  </div>

  <div class="grade-form">
    <label>
      <!-- Campo para alterar a data de validade do produto. -->
      Validade
      <input
        type="date"
        name="validade"
        required
        value="<?= htmlspecialchars($valores["validade"]) ?>"
      >
    </label>

    <label>
      <!-- Campo para escolher a categoria do produto. -->
      Categoria
      <select name="categoria_codigo" required>
        <?php foreach ($categorias as $c): ?>
          <option
            value="<?= (int) $c["codigo_categoria"] ?>"
            <?= ($valores["categoria_codigo"] == $c["codigo_categoria"]) ? "selected" : "" ?>
          >
            <?= htmlspecialchars($c["nome"]) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </label>
  </div>

  <div class="botoes">
    <!-- Botão para enviar as alterações para o banco. -->
    <button class="botao" type="submit">
      Salvar alterações
    </button>

    <!-- Link para cancelar a edição e voltar para a listagem. -->
    <a class="botao secundario" href="index.php">
      Cancelar
    </a>
  </div>
</form>

<?php
// Inclui o rodapé da página ao final da estrutura HTML.
require __DIR__ . "/../includes/footer.php";
?>

