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
Descritivo: Cria o banco de dados loja_bebidas, as tabelas categorias e produtos, o relacionamento entre elas e os dados iniciais da loja.
******************************************************************************
*/

-- Cria o banco de dados da loja, caso ele ainda não exista, com suporte para caracteres UTF-8 e regras de ordenação universais.
CREATE DATABASE IF NOT EXISTS loja_bebidas
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

-- Seleciona o banco de dados da loja para executar as próximas instruções SQL nele.
USE loja_bebidas;

-- Desativa temporariamente as verificações de chave estrangeira para permitir a remoção segura das tabelas antigas.
SET FOREIGN_KEY_CHECKS = 0;
-- Remove a tabela de produtos, caso já exista, para evitar duplicação de estrutura.
DROP TABLE IF EXISTS produtos;
-- Remove a tabela de categorias, caso já exista, para recriar a base do zero.
DROP TABLE IF EXISTS categorias;
-- Reativa novamente a validação de chaves estrangeiras após a limpeza da base.
SET FOREIGN_KEY_CHECKS = 1;

-- Cria a tabela de categorias, armazenando os grupos de produtos da loja e evitando nomes duplicados.
CREATE TABLE categorias (
    codigo_categoria INT UNSIGNED NOT NULL,
    nome VARCHAR(60) NOT NULL,
    descricao VARCHAR(255) NULL,
    PRIMARY KEY (codigo_categoria),
    UNIQUE KEY uq_categorias_nome (nome)
) ENGINE=InnoDB
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

-- Cria a tabela de produtos, armazenando os itens vendidos, seus preços, estoque e a categoria a que pertencem.
CREATE TABLE produtos (
    codigo_produto INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nome VARCHAR(150) NOT NULL,
    marca VARCHAR(80) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    quantidade_estoque INT UNSIGNED NOT NULL DEFAULT 0,
    validade DATE NOT NULL,
    categoria_codigo INT UNSIGNED NOT NULL,
    PRIMARY KEY (codigo_produto),
    KEY idx_produtos_categoria (categoria_codigo),
    CONSTRAINT fk_produtos_categorias
        FOREIGN KEY (categoria_codigo)
        REFERENCES categorias (codigo_categoria)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT chk_produtos_preco CHECK (preco >= 0),
    CONSTRAINT chk_produtos_estoque CHECK (quantidade_estoque >= 0)
) ENGINE=InnoDB
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

-- Insere os principais grupos de bebidas disponíveis na loja para organizar o catálogo de produtos.
INSERT INTO categorias (codigo_categoria, nome, descricao) VALUES
    (1, 'Cervejas', 'Cervejas tradicionais, premium e sem álcool.'),
    (2, 'Refrigerantes', 'Refrigerantes de diferentes sabores e tamanhos.'),
    (3, 'Destilados', 'Bebidas destiladas, como vodcas, uísques e cachaças.'),
    (4, 'Sucos', 'Sucos naturais, integrais e néctares.'),
    (5, 'Energéticos', 'Bebidas energéticas para consumo gelado ou natural.');

-- Cadastra os produtos da categoria de cervejas com seus preços, estoque e validade.
INSERT INTO produtos
    (nome, marca, preco, quantidade_estoque, validade, categoria_codigo)
VALUES
    ('Cerveja Pilsen Lata 350ml', 'Skol', 4.49, 120, '2027-06-15', 1),
    ('Cerveja Pilsen Lata 350ml', 'Brahma', 4.59, 100, '2027-05-20', 1),
    ('Cerveja Puro Malte Lata 350ml', 'Amstel', 5.49, 85, '2027-07-10', 1),
    ('Cerveja Pilsen Lata 350ml', 'Antarctica', 4.39, 90, '2027-04-18', 1),
    ('Cerveja Lager Lata 350ml', 'Heineken', 7.99, 75, '2027-08-12', 1),
    ('Cerveja Puro Malte Lata 350ml', 'Spaten', 6.99, 60, '2027-09-05', 1),
    ('Cerveja Premium Long Neck 330ml', 'Stella Artois', 8.49, 45, '2027-10-22', 1),
    ('Cerveja Pilsen Long Neck 355ml', 'Budweiser', 7.49, 55, '2027-11-11', 1),
    ('Cerveja Sem Álcool Long Neck 330ml', 'Brahma 0.0', 6.49, 40, '2027-03-30', 1),
    ('Cerveja Premium Lata 350ml', 'Original', 6.29, 70, '2027-06-28', 1);

-- Cadastra os produtos da categoria de refrigerantes com informações de preço, estoque e validade.
INSERT INTO produtos
    (nome, marca, preco, quantidade_estoque, validade, categoria_codigo)
VALUES
    ('Refrigerante Cola Lata 350ml', 'Coca-Cola', 5.49, 150, '2027-02-14', 2),
    ('Refrigerante Cola Lata 350ml', 'Pepsi', 4.99, 135, '2027-03-18', 2),
    ('Refrigerante Guaraná Lata 350ml', 'Guaraná Antarctica', 4.79, 125, '2027-04-25', 2),
    ('Refrigerante Cola Lata 350ml', 'Fanta', 4.89, 110, '2027-05-12', 2),
    ('Refrigerante Limão Lata 350ml', 'Sprite', 4.89, 105, '2027-05-30', 2),
    ('Refrigerante Cola Lata 350ml', 'Itubaína', 4.29, 80, '2027-06-17', 2),
    ('Refrigerante Guaraná Lata 350ml', 'Kuat', 4.69, 95, '2027-07-08', 2),
    ('Refrigerante Citrus Lata 350ml', 'Schweppes', 5.99, 65, '2027-08-21', 2),
    ('Refrigerante Cola Lata 350ml', 'Coca-Cola Zero', 5.69, 140, '2027-02-28', 2),
    ('Refrigerante Cola Lata 350ml', 'Pepsi Black', 5.19, 90, '2027-04-02', 2);

-- Cadastra os produtos da categoria de destilados com variedade de marcas, preços e validade.
INSERT INTO produtos
    (nome, marca, preco, quantidade_estoque, validade, categoria_codigo)
VALUES
    ('Vodka 998ml', 'Smirnoff', 39.90, 35, '2030-01-15', 3),
    ('Vodka 1L', 'Absolut', 119.90, 20, '2031-06-20', 3),
    ('Whisky 8 Anos 1L', 'Johnnie Walker Red Label', 109.90, 25, '2030-09-12', 3),
    ('Whisky 12 Anos 1L', 'Johnnie Walker Black Label', 189.90, 15, '2032-03-10', 3),
    ('Cachaça Prata 965ml', '51', 18.90, 50, '2029-11-18', 3),
    ('Cachaça Ouro 700ml', 'Ypióca', 29.90, 30, '2030-04-25', 3),
    ('Gin London Dry 750ml', 'Tanqueray', 149.90, 18, '2031-08-30', 3),
    ('Gin 750ml', 'Beefeater', 99.90, 22, '2030-12-05', 3),
    ('Tequila Silver 750ml', 'Jose Cuervo', 139.90, 12, '2032-02-14', 3),
    ('Licor de Café 750ml', 'Café 43', 159.90, 10, '2031-10-28', 3);

-- Cadastra os produtos da categoria de sucos com a lista de sabores, marcas e quantidades em estoque.
INSERT INTO produtos
    (nome, marca, preco, quantidade_estoque, validade, categoria_codigo)
VALUES
    ('Suco de Uva Integral 1L', 'Aurora', 14.90, 60, '2027-01-20', 4),
    ('Suco de Laranja 1L', 'Del Valle', 8.99, 75, '2027-02-11', 4),
    ('Néctar de Pêssego 1L', 'Maguary', 7.49, 80, '2027-03-07', 4),
    ('Suco de Uva Integral 1L', 'Casa Madeira', 19.90, 35, '2027-04-15', 4),
    ('Suco de Laranja 900ml', 'Prats', 12.90, 45, '2027-01-30', 4),
    ('Néctar de Goiaba 1L', 'Jandaia', 6.99, 70, '2027-05-19', 4),
    ('Suco de Maracujá 1L', 'Maguary', 7.99, 65, '2027-06-09', 4),
    ('Suco de Maçã Integral 1L', 'Eden', 16.90, 25, '2027-07-22', 4),
    ('Néctar de Manga 1L', 'Del Valle', 8.49, 55, '2027-08-16', 4),
    ('Suco de Uva 1L', 'Minalba', 9.90, 40, '2027-03-26', 4);

-- Cadastra os produtos da categoria de energéticos com foco em marcas, tamanhos e validade.
INSERT INTO produtos
    (nome, marca, preco, quantidade_estoque, validade, categoria_codigo)
VALUES
    ('Energético Lata 250ml', 'Red Bull', 9.49, 100, '2027-01-18', 5),
    ('Energético Lata 473ml', 'Monster', 12.99, 85, '2027-02-22', 5),
    ('Energético Lata 269ml', 'TNT', 6.99, 120, '2027-03-14', 5),
    ('Energético Lata 269ml', 'Baly', 5.99, 110, '2027-04-08', 5),
    ('Energético Lata 250ml', 'Fusion', 7.49, 90, '2027-05-25', 5),
    ('Energético Lata 473ml', 'Vibe', 8.99, 70, '2027-06-12', 5),
    ('Energético Lata 250ml', 'Burn', 8.49, 65, '2027-07-17', 5),
    ('Energético Lata 473ml', 'Flying Horse', 9.99, 55, '2027-08-29', 5),
    ('Energético Lata 250ml', 'Red Bull Sugarfree', 9.99, 60, '2027-09-19', 5),
    ('Energético Lata 473ml', 'Monster Ultra', 13.49, 50, '2027-10-31', 5);
