<?php
require_once __DIR__ . '/banco.php';

class Cliente extends Banco
{
    // Colunas gravadas a partir do formulário (lista fixa, nunca vem do usuário).
    private const CAMPOS = [
        'cl_nome', 'cl_cpf', 'cl_telefone_01', 'cl_telefone_02',
        'cl_endereco', 'cl_cidade', 'cl_uf', 'cl_cep', 'cl_obs', 'ativo',
    ];

    public const UFS = [
        'AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA',
        'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO',
    ];

    public function listar(): array
    {
        $stmt = $this->pdo->prepare('SELECT cl_id, cl_nome, cl_cpf, cl_cidade, cl_uf, ativo FROM clientes ORDER BY cl_nome');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function buscar(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM clientes WHERE cl_id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function incluir(array $dados): int
    {
        $colunas = implode(', ', self::CAMPOS);
        $parametros = ':' . implode(', :', self::CAMPOS);
        $stmt = $this->pdo->prepare("INSERT INTO clientes ($colunas) VALUES ($parametros)");
        $stmt->execute($this->parametros($dados));
        return (int) $this->pdo->lastInsertId();
    }

    public function atualizar(int $id, array $dados): void
    {
        $atribuicoes = implode(', ', array_map(fn ($campo) => "$campo = :$campo", self::CAMPOS));
        $stmt = $this->pdo->prepare("UPDATE clientes SET $atribuicoes WHERE cl_id = :cl_id");
        $stmt->execute($this->parametros($dados) + ['cl_id' => $id]);
    }

    public function excluir(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM clientes WHERE cl_id = ?');
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    private function parametros(array $dados): array
    {
        return array_intersect_key($dados, array_flip(self::CAMPOS));
    }

    // Valida e normaliza os dados do formulário. Retorna [dados, erros].
    public static function validar(array $entrada): array
    {
        $texto = fn (string $campo) => trim((string) ($entrada[$campo] ?? ''));

        $dados = [
            'cl_nome'        => $texto('cl_nome'),
            'cl_cpf'         => somenteDigitos($texto('cl_cpf')),
            'cl_telefone_01' => somenteDigitos($texto('cl_telefone_01')),
            'cl_telefone_02' => somenteDigitos($texto('cl_telefone_02')),
            'cl_endereco'    => $texto('cl_endereco'),
            'cl_cidade'      => $texto('cl_cidade'),
            'cl_uf'          => strtoupper($texto('cl_uf')),
            'cl_cep'         => somenteDigitos($texto('cl_cep')),
            'cl_obs'         => $texto('cl_obs'),
            'ativo'          => empty($entrada['ativo']) ? 0 : 1,
        ];

        $erros = [];
        $tamanhoNome = mb_strlen($dados['cl_nome']);
        if ($tamanhoNome < 3 || $tamanhoNome > 100) {
            $erros['cl_nome'] = 'Informe o nome completo (3 a 100 caracteres).';
        }
        if ($dados['cl_cpf'] !== '' && !self::cpfValido($dados['cl_cpf'])) {
            $erros['cl_cpf'] = 'CPF inválido.';
        }
        foreach (['cl_telefone_01', 'cl_telefone_02'] as $campo) {
            if ($dados[$campo] !== '' && !preg_match('/^\d{10,11}$/', $dados[$campo])) {
                $erros[$campo] = 'Use DDD + número (10 ou 11 dígitos).';
            }
        }
        if (mb_strlen($dados['cl_endereco']) > 150) {
            $erros['cl_endereco'] = 'Máximo de 150 caracteres.';
        }
        if (mb_strlen($dados['cl_cidade']) > 80) {
            $erros['cl_cidade'] = 'Máximo de 80 caracteres.';
        }
        if ($dados['cl_uf'] !== '' && !in_array($dados['cl_uf'], self::UFS, true)) {
            $erros['cl_uf'] = 'UF inválida.';
        }
        if ($dados['cl_cep'] !== '' && strlen($dados['cl_cep']) !== 8) {
            $erros['cl_cep'] = 'O CEP tem 8 dígitos.';
        }
        if (mb_strlen($dados['cl_obs']) > 500) {
            $erros['cl_obs'] = 'Máximo de 500 caracteres.';
        }

        // campos opcionais em branco são gravados como NULL
        $dados = array_map(fn ($valor) => $valor === '' ? null : $valor, $dados);

        return [$dados, $erros];
    }

    // Confere os dois dígitos verificadores do CPF.
    private static function cpfValido(string $cpf): bool
    {
        if (strlen($cpf) !== 11 || preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false;
        }
        for ($posicao = 9; $posicao < 11; $posicao++) {
            $soma = 0;
            for ($i = 0; $i < $posicao; $i++) {
                $soma += (int) $cpf[$i] * ($posicao + 1 - $i);
            }
            $digito = ($soma * 10) % 11 % 10;
            if ((int) $cpf[$posicao] !== $digito) {
                return false;
            }
        }
        return true;
    }
}
