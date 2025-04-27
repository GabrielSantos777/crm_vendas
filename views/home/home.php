<?php
require_once 'controllers/Home.php';
$totalVendas = totalVendas();
$totalProduct = totalPedidos();
$maisPedido = produtoMaisPedido();
$dadosGrafico = dadosGraficoProdutos();
$dadosVendas = dadosGraficoVendas();
$ultimasVendas = ultimasVendas();
?>
<section>
    <div class="container">
        <div class="d-flex row align-items-center justify-content-center">
            <div class="col-md-6 col-xl-3 mb-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-2">Vendas no mês</h6>
                        <h4 class="mb-3">R$ <?php echo number_format($totalVendas, 2, ',', '.') ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-2">Pedidos no mês</h6>
                        <h4 class="mb-3"><?php echo $totalProduct; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-2">Total de Clientes</h6>
                        <h4 class="mb-3">2.563</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-2">Produto mais pedido</h6>
                        <h4 class="mb-3"><?php echo $maisPedido['produto'] . " (" . $maisPedido['quantidade'] . ")"; ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row d-flex align-items-start justify-content-center">
        <div class="col-12 col-md-6 mb-4">
            <canvas id="myChart"></canvas>
        </div>
        <div class="col-12 col-md-6">
            <canvas id="myChartVendas"></canvas>
        </div>
    </div>





</section>

<h5>Vendas Recentes</h5>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Data da Venda</th>
                <th>Pagamento</th>
                <th>Valor</th>
                <th>Produto</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ultimasVendas as $venda): ?>
                <tr>
                    <td><?php echo $venda['id']; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($venda['data'])); ?></td>
                    <td><?php echo htmlspecialchars($venda['forma_pagamento']); ?></td>
                    <td>R$ <?php echo number_format($venda['valor'], 2, ',', '.'); ?></td>
                    <td><?php echo $venda['produto']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // <----GRÁFICO DE PRODUTOS MAIS VENDIDOS---->
    const ctx = document.getElementById('myChart').getContext('2d');

    const labelsProdutos = <?php echo json_encode(array_column($dadosGrafico, 'produto')); ?>;
    const dataProdutos = <?php echo json_encode(array_column($dadosGrafico, 'quantidade')); ?>;

    let graficoProdutos = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labelsProdutos,
            datasets: [{
                label: 'Quantidade Vendidas',
                data: dataProdutos,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }

        }
    });

    window.addEventListener('resize', function() {
        graficoProdutos.resize();
    });

    // <----GRÁFICO DE VENDAS POR DIA---->
    
    const ctxVendas = document.getElementById('myChartVendas').getContext('2d');

    const labelsVendas = <?php echo json_encode(array_column($dadosVendas, 'data_venda')); ?>;
    const dataVendas = <?php echo json_encode(array_column($dadosVendas, 'quantidade_vendas')); ?>;

    
    let graficoVendas = new Chart(ctxVendas, {
        type: 'line',
        data: {
            labels: labelsVendas,
            datasets: [{
                label: 'Quantidade Vendidas',
                data: dataVendas,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                fill: true, // deixa a linha com preenchimento, fica top!
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Vendas por Dia',
                    font: {
                        size: 18
                    }
                }
            }

        }
    });
</script>