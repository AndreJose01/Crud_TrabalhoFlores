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
Descritivo: Lista as categorias cadastradas e mostra a quantidade de produtos associada a cada uma.
******************************************************************************
*/

// Importa a conexão com o banco de dados para consultar as categorias cadastradas.
require_once __DIR__ . "/../config/conexao.php";

// Define o título da página exibido no layout da aplicação.
$titulo = "Categorias";

// Consulta todas as categorias com a contagem de produtos de cada uma, usando junção à tabela produtos.
$categorias = $pdo
  ->query(
    "SELECT c.*, COUNT(p.codigo_produto) AS total_produtos
     FROM categorias c
     LEFT JOIN produtos p
       ON p.categoria_codigo = c.codigo_categoria
     GROUP BY c.codigo_categoria
     ORDER BY c.codigo_categoria"
  )
  ->fetchAll();

// Inclui o cabeçalho da página para manter o layout padrão do sistema.
require __DIR__ . "/../includes/header.php";
?>

<?php
// Exibe o cabeçalho da página com o título e o botão para cadastrar uma nova categoria.
?>
<div class="titulo-pagina">
  <div>
    <h1>Categorias</h1>
    <p>Gerencie os tipos de bebidas da loja.</p>
  </div>

  <!-- Link que leva para a tela de cadastro de uma nova categoria. -->
  <a class="botao" href="cadastrar.php">
    + Nova categoria
  </a>
</div>

<?php if (!empty($_SESSION["mensagem"])): ?>
  <!-- Mostra a mensagem de sucesso ou erro enviada pela operação anterior. -->
  <div class="alerta">
    <?= htmlspecialchars($_SESSION["mensagem"]); unset($_SESSION["mensagem"]); ?>
  </div>
<?php endif; ?>

<?php
// Cria a tabela responsiva para listar todas as categorias e seus detalhes.
?>
<div class="tabela-responsiva">
  <table>
    <thead>
      <tr>
        <th>Código</th>
        <th>Nome</th>
        <th>Descrição</th>
        <th>Produtos</th>
        <th>Ações</th>
      </tr>
    </thead>

    <tbody>
      <?php if (!$categorias): ?>
        <!-- Exibe uma linha informando que ainda não há categorias cadastradas. -->
        <tr>
          <td colspan="5" class="vazio">
            Nenhuma categoria cadastrada.
          </td>
        </tr>
      <?php else: ?>
        <?php foreach ($categorias as $c): ?>
          <tr>
            <!-- Mostra o código da categoria. -->
            <td><?= (int) $c["codigo_categoria"] ?></td>
            <!-- Mostra o nome da categoria. -->
            <td><?= htmlspecialchars($c["nome"]) ?></td>
            <!-- Mostra a descrição da categoria ou um valor vazio caso não exista. -->
            <td><?= htmlspecialchars($c["descricao"] ?? "") ?></td>
            <!-- Mostra a quantidade de produtos vinculados à categoria. -->
            <td><?= (int) $c["total_produtos"] ?></td>

            <td class="acoes">
              <!-- Link para abrir a página de edição da categoria. -->
              <a
                class="link-editar"
                href="editar.php?id=<?= (int) $c["codigo_categoria"] ?>"
              >
                Editar
              </a>

              <!-- Formulário para enviar a exclusão da categoria para a página de processamento. -->
              <form
                method="post"
                action="excluir.php"
                onsubmit="return confirm('Deseja excluir esta categoria? Ela não pode ter produtos vinculados.');"
              >
                <input
                  type="hidden"
                  name="id"
                  value="<?= (int) $c["codigo_categoria"] ?>"
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
// Inclui o rodapé da página para finalizar o layout.
require __DIR__ . "/../includes/footer.php";
?>

