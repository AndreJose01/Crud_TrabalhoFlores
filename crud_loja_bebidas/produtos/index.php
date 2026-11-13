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
Descritivo: Lista os produtos cadastrados com suas marcas, preços, estoque, validade e categorias relacionadas.
******************************************************************************
*/

// Importa a conexão com o banco de dados para consultar os produtos.
require_once __DIR__ . "/../config/conexao.php";

// Define o título da página para exibir no layout do sistema.
$titulo = "Produtos";

// Busca todos os produtos com o nome da categoria relacionada, ordenando os mais recentes primeiro.
$sql = "SELECT p.*, c.nome AS categoria
        FROM produtos p
        INNER JOIN categorias c ON c.codigo_categoria = p.categoria_codigo
        ORDER BY p.codigo_produto DESC";

// Executa a consulta SQL e guarda os produtos em um array.
$produtos = $pdo->query($sql)->fetchAll();

// Inclui o cabeçalho da aplicação para manter a estrutura visual padrão.
require __DIR__ . "/../includes/header.php";
?>

<?php
// Exibe o título da página e o botão para cadastrar um novo produto.
?>
<div class="titulo-pagina">
  <div>
    <h1>Produtos</h1>
    <p>Consulte e gerencie os produtos cadastrados.</p>
  </div>

  <!-- Link para abrir a tela de cadastro de um novo produto. -->
  <a class="botao" href="cadastrar.php">
    + Novo produto
  </a>
</div>

<?php if (!empty($_SESSION["mensagem"])): ?>
  <!-- Mostra a mensagem de sucesso ou aviso enviada pela operação anterior. -->
  <div class="alerta">
    <?= htmlspecialchars($_SESSION["mensagem"]); unset($_SESSION["mensagem"]); ?>
  </div>
<?php endif; ?>

<?php
// Cria a tabela responsiva para exibir os produtos em formato de listagem.
?>
<div class="tabela-responsiva">
  <table>
    <thead>
      <tr>
        <th>Código</th>
        <th>Produto</th>
        <th>Marca</th>
        <th>Categoria</th>
        <th>Preço</th>
        <th>Estoque</th>
        <th>Validade</th>
        <th>Ações</th>
      </tr>
    </thead>

    <tbody>
      <?php if (!$produtos): ?>
        <!-- Exibe uma linha indicando que ainda não há registros de produtos. -->
        <tr>
          <td colspan="8" class="vazio">
            Nenhum produto cadastrado.
          </td>
        </tr>
      <?php else: ?>
        <?php foreach ($produtos as $p): ?>
          <tr>
            <!-- Mostra o código do produto. -->
            <td><?= (int) $p["codigo_produto"] ?></td>
            <!-- Mostra o nome do produto. -->
            <td><?= htmlspecialchars($p["nome"]) ?></td>
            <!-- Mostra a marca do produto. -->
            <td><?= htmlspecialchars($p["marca"]) ?></td>
            <!-- Mostra o nome da categoria vinculada ao produto. -->
            <td><?= htmlspecialchars($p["categoria"]) ?></td>
            <td>
              <!-- Formata o preço para o padrão monetário brasileiro. -->
              R$ <?= number_format((float) $p["preco"], 2, ",", ".") ?>
            </td>
            <!-- Exibe a quantidade disponível em estoque. -->
            <td><?= (int) $p["quantidade_estoque"] ?></td>
            <td>
              <!-- Converte a data de validade para o formato visual do sistema. -->
              <?= date("d/m/Y", strtotime($p["validade"])) ?>
            </td>

            <td class="acoes">
              <!-- Link para abrir a página de edição do produto. -->
              <a
                class="link-editar"
                href="editar.php?id=<?= (int) $p["codigo_produto"] ?>"
              >
                Editar
              </a>

              <!-- Formulário para enviar a exclusão do produto para o arquivo responsável. -->
              <form
                method="post"
                action="excluir.php"
                onsubmit="return confirm('Deseja realmente excluir este produto?');"
              >
                <input
                  type="hidden"
                  name="id"
                  value="<?= (int) $p["codigo_produto"] ?>"
                >

                <button class="link-excluir" type="submit">
                  Excluir
                </button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php
// Inclui o rodapé da página para fechar o layout da aplicação.
require __DIR__ . "/../includes/footer.php";
?>
