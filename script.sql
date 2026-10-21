-- Estrutura e dados de exemplo do SGS.
-- No Docker este script roda sozinho na primeira subida do MySQL, já dentro do banco DB_NAME.
-- Fora do Docker: crie o banco e rode "mysql -u root -p sgs < script.sql".
-- Todos os dados abaixo são fictícios.

SET NAMES utf8mb4;

CREATE TABLE usuarios (
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nome       VARCHAR(100) NOT NULL,
    login      VARCHAR(50)  NOT NULL,
    senha      VARCHAR(255) NOT NULL COMMENT 'hash gerado por password_hash()',
    criado_em  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uk_usuarios_login (login)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE clientes (
    cl_id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
    cl_nome         VARCHAR(100) NOT NULL,
    cl_cpf          CHAR(11)     NULL,
    cl_telefone_01  VARCHAR(11)  NULL,
    cl_telefone_02  VARCHAR(11)  NULL,
    cl_endereco     VARCHAR(150) NULL,
    cl_cidade       VARCHAR(80)  NULL,
    cl_uf           CHAR(2)      NULL,
    cl_cep          CHAR(8)      NULL,
    cl_obs          VARCHAR(500) NULL,
    ativo           TINYINT(1)   NOT NULL DEFAULT 1,
    criado_em       TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (cl_id),
    UNIQUE KEY uk_clientes_cpf (cl_cpf)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Usuário de demonstração: admin / admin123 (só para rodar localmente)
INSERT INTO usuarios (nome, login, senha) VALUES
('Administrador', 'admin', '$2y$12$/fqf6KzOAH0WzkeZSLrXfOaV4KoETLHY/xCSLjopeRl/k9voL9qqK');

-- Clientes fictícios (CPFs gerados apenas com dígitos verificadores válidos)
INSERT INTO clientes (cl_nome, cl_cpf, cl_telefone_01, cl_telefone_02, cl_endereco, cl_cidade, cl_uf, cl_cep, cl_obs, ativo) VALUES
('Ana Beatriz Moura',      '49325620553', '11987650001', NULL,          'Rua das Acácias, 120',          'São Paulo',      'SP', '01000000', 'Prefere contato por WhatsApp.', 1),
('Bruno Henrique Tavares', '01977480071', '21987650002', '2132650002',  'Av. Atlântica, 455, apto 301',  'Rio de Janeiro', 'RJ', '22000000', NULL, 1),
('Carla Fernandes Lima',   '24175701656', '31987650003', NULL,          'Rua dos Ipês, 78',              'Belo Horizonte', 'MG', '30100000', NULL, 1),
('Diego Albuquerque',      '98687116225', '81987650004', NULL,          'Rua do Sol, 9',                 'Recife',         'PE', '50000000', 'Cliente desde a primeira versão.', 1),
('Eduarda Ramos Costa',    '61098592816', '41987650005', '4132650005',  'Rua XV de Novembro, 1500',      'Curitiba',       'PR', '80000000', NULL, 0),
('Felipe Nogueira',        '03987549424', '51987650006', NULL,          'Av. Ipiranga, 2020',            'Porto Alegre',   'RS', '90000000', NULL, 1),
('Gabriela Souza Prado',   '66121340118', '61987650007', NULL,          'SQS 308, bloco C',              'Brasília',       'DF', '70000000', NULL, 1),
('Henrique Matos',         '84259736191', '71987650008', NULL,          'Rua Chile, 33',                 'Salvador',       'BA', '40000000', 'Ligar apenas à tarde.', 1),
('Isabela Cardoso',        '74731741181', '85987650009', NULL,          'Av. Beira Mar, 800',            'Fortaleza',      'CE', '60000000', NULL, 0),
('João Pedro Martins',     '53431511244', '62987650010', '6232650010',  'Rua 10, 245, Setor Oeste',      'Goiânia',        'GO', '74000000', NULL, 1);
