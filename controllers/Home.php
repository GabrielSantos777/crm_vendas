

<?php

function criarConexao()
{
    $host = "localhost";
    $usuario = "root";
    $senha = "1234";
    $banco = "crm_novo";

    $conexao = new mysqli($host, $usuario, $senha, $banco);

    if ($conexao->connect_error) {
        die("Falha na conexão: " . $conexao->connect_error);
    }

    return $conexao;
}


function totalVendas()
{
    $conexao = criarConexao();

    // QUERY PARA EFETUAR A SOMA DA COLUNA VALOR DA TABELA VENDAS
    $sql = "SELECT SUM(valor) AS total FROM vendas";
    $resultado = $conexao->query($sql);

    $total = 0;
    if ($resultado && $row = $resultado->fetch_assoc()) {
        $total = $row['total'];
    }

    $conexao->close();

    return $total;
}

function totalPedidos()
{
    $conexao = criarConexao();

    $sql = "SELECT COUNT(id) AS totalProdutos FROM vendas";
    $resultado = $conexao->query($sql);

    $totalProduct = 0;
    if ($resultado && $row = $resultado->fetch_assoc()) {
        $totalProduct = $row['totalProdutos'];
    }

    $conexao->close();

    return $totalProduct;
}
function produtoMaisPedido()
{
    $conexao = criarConexao();

    $sql = "SELECT produto, COUNT(*) AS quantidade FROM vendas GROUP BY produto ORDER BY quantidade DESC LIMIT 1";
    $resultado = $conexao->query($sql);

    $maisPedido = 0;
    if ($resultado && $row = $resultado->fetch_assoc()) {
        $maisPedido = [
            'produto' => $row['produto'],
            'quantidade' => $row['quantidade']
        ];
    }

    $conexao->close();

    return $maisPedido;
}

function dadosGraficoProdutos()
{
    $conexao = criarConexao();

    $sql = "SELECT produto, COUNT(*) AS quantidade FROM vendas GROUP BY produto";
    $resultado = $conexao->query($sql);

    $dados = [];

    if ($resultado) {
        while ($row = $resultado->fetch_assoc()) {
            $dados[] = $row;
        }
    }

    $conexao->close();

    return $dados;
}
function dadosGraficoVendas()
{
    $conexao = criarConexao();

    $sql = "SELECT 
                DATE(data_hora) AS data_venda, 
                COUNT(*) AS quantidade_vendas, 
                SUM(valor) AS total_vendas 
            FROM vendas 
            GROUP BY DATE(data_hora) 
            ORDER BY DATE(data_hora) ASC";
    $resultado = $conexao->query($sql);

    $dados = [];

    if ($resultado) {
        while ($row = $resultado->fetch_assoc()) {
            $dados[] = $row;
        }
    }

    $conexao->close();

    return $dados;
}

function ultimasVendas()
{
    $conexao = criarConexao();

    $sql = "SELECT id, data_hora, forma_pagamento, valor, produto FROM vendas ORDER BY data_hora DESC LIMIT 10";
    $result = $conexao->query($sql);

    $vendas = [];
    while ($row = $result->fetch_assoc()) {
        $vendas[] = $row;
    }
    return $vendas;
}
