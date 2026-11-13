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
Descritivo: Exibe e processa o formulário de cadastro de produtos, incluindo marca, preço, estoque, validade e categoria.
******************************************************************************
*/

// Importa a conexão com o banco de dados para acessar a variável $pdo.
require_once __DIR__ . "/../config/conexao.php";

// Define o título da página para o layout do sistema.
$titulo = "Cadastrar produto";

// Busca todas as categorias cadastradas para preencher o campo de seleção do formulário.
$categorias = $pdo
  ->query(
    "SELECT codigo_categoria, nome FROM categorias ORDER BY nome"
  )
  ->fetchAll();

// Inicializa a variável de erro para mostrar mensagens de validação.
$erro = "";

// Verifica se o formulário foi enviado via método POST.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Obtém e limpa os dados do formulário: nome, marca, preço, estoque, validade e categoria.
  $nome = trim($_POST["nome"] ?? "");
  $marca = trim($_POST["marca"] ?? "");
  $preco = str_replace(",", ".", trim($_POST["preco"] ?? ""));
  $estoque = $_POST["quantidade_estoque"] ?? "";
  $validade = $_POST["validade"] ?? "";
  $categoria = $_POST["categoria_codigo"] ?? "";

  // Valida se todos os campos obrigatórios foram preenchidos com valores corretos.
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
    // Define uma mensagem de erro caso algum dado seja inválido.
    $erro = "Preencha todos os campos com valores válidos.";
  } else {
    // Prepara a instrução SQL para inserir o produto no banco.
    $stmt = $pdo->prepare(
      "INSERT INTO produtos (nome, marca, preco, quantidade_estoque, validade, categoria_codigo)
       VALUES (?, ?, ?, ?, ?, ?)"
    );

    // Executa a inserção do novo produto com os dados recebidos.
    $stmt->execute([
      $nome,
      $marca,
      $preco,
      $estoque,
      $validade,
      $categoria,
    ]);

    // Salva uma mensagem de sucesso na sessão para mostrar depois do redirecionamento.
    $_SESSION["mensagem"] = "Produto cadastrado com sucesso!";

    // Redireciona para a listagem de produtos.
    header("Location: index.php");
    exit;
  }
}

// Inclui o cabeçalho do sistema para manter a estrutura visual padrão.
require __DIR__ . "/../includes/header.php";
?>

<?php
// Exibe o título da página de cadastro de produto.
?>
<h1>Cadastrar produto</h1>

<?php if ($erro): ?>
  <!-- Exibe a mensagem de erro quando os dados do formulário são inválidos. -->
  <div class="alerta erro">
    <?= htmlspecialchars($erro) ?>
  </div>
<?php endif; ?>

<?php if (!$categorias): ?>
  <!-- Informa ao usuário que é necessário cadastrar uma categoria antes de criar produtos. -->
  <div class="alerta erro">
    Cadastre uma categoria antes de cadastrar produtos.
  </div>
<?php else: ?>
  <!-- Cria o formulário para preenchimento dos dados do produto. -->
  <form class="formulario" method="post">
    <label>
      <!-- Campo para informar o nome do produto. -->
      Nome do produto
      <input
        name="nome"
        maxlength="150"
        required
        value="<?= htmlspecialchars($_POST["nome"] ?? "") ?>"
      >
    </label>

    <label>
      <!-- Campo para informar a marca do produto. -->
      Marca
      <input
        name="marca"
        maxlength="80"
        required
        value="<?= htmlspecialchars($_POST["marca"] ?? "") ?>"
      >
    </label>

    <div class="grade-form">
      <label>
        <!-- Campo para informar o preço do produto em reais. -->
        Preço (R$)
        <input
          type="number"
          name="preco"
          min="0"
          step="0.01"
          required
          value="<?= htmlspecialchars($_POST["preco"] ?? "") ?>"
        >
      </label>

      <label>
        <!-- Campo para informar a quantidade de itens em estoque. -->
        Quantidade em estoque
        <input
          type="number"
          name="quantidade_estoque"
          min="0"
          step="1"
          required
          value="<?= htmlspecialchars($_POST["quantidade_estoque"] ?? "0") ?>"
        >
      </label>
    </div>

    <div class="grade-form">
      <label>
        <!-- Campo para informar a data de validade do produto. -->
        Validade
        <input
          type="date"
          name="validade"
          required
          value="<?= htmlspecialchars($_POST["validade"] ?? "") ?>"
        >
      </label>

      <label>
        <!-- Campo para selecionar a categoria do produto. -->
        Categoria
        <select name="categoria_codigo" required>
          <option value="">Selecione</option>

          <?php foreach ($categorias as $c): ?>
            <option
              value="<?= (int) $c["codigo_categoria"] ?>"
              <?= (
                ($_POST["categoria_codigo"] ?? "") ==
                $c["codigo_categoria"]
              ) ? "selected" : "" ?>
            >
              <?= htmlspecialchars($c["nome"]) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </label>
    </div>

    <div class="botoes">
      <!-- Botão para enviar os dados do formulário para cadastro do produto. -->
      <button class="botao" type="submit">
        Salvar produto
      </button>

      <!-- Link para cancelar o cadastro e voltar à listagem de produtos. -->
      <a class="botao secundario" href="index.php">
        Cancelar
      </a>
    </div>
  </form>
<?php endif; ?>

<?php
// Inclui o rodapé da página para encerrar o layout.
require __DIR__ . "/../includes/footer.php";
?>

