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
Descritivo: Configura e abre a conexão PDO com o banco de dados MySQL loja_bebidas.
******************************************************************************
*/

// Define o endereço do servidor MySQL usado pela aplicação.
$host = "localhost";
// Define o nome do banco de dados que será acessado.
$banco = "loja_bebidas";
// Define o usuário do banco de dados com permissão para acessar a base.
$usuario = "root";
// Define a senha do usuário do banco; no XAMPP geralmente é vazia.
$senha = ""; // Senha padrão do XAMPP.

try {
  // Tenta abrir a conexão PDO com o MySQL usando os dados configurados.
  $pdo = new PDO(
    "mysql:host=$host;dbname=$banco;charset=utf8mb4",
    $usuario,
    $senha,
    [
      // Configura o PDO para lançar exceções em caso de erro.
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      // Define o modo padrão de retorno dos resultados como array associativo.
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
  );
} catch (PDOException $e) {
  // Se a conexão falhar, interrompe a execução e exibe uma mensagem útil ao usuário.
  die(
    "Erro ao conectar ao banco de dados. Verifique o arquivo config/conexao.php e se o MySQL está ligado."
  );
}

