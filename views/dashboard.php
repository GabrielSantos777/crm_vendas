<?php
require_once 'includes/header.php';
require_once 'controllers/Dashboard.php';

$controller = new Dashboard();
$filtro = $_GET['filtro'] ?? 'todos';

$resumo = $controller->obterResumo($filtro);
$grafico = $controller->obterVendasPorDia($filtro);
$ranking = $controller->produtoMaisVendidos($filtro);
$pagamentos = $controller->formasDePagamento($filtro);
$ultimas = $controller->ultimasVendas($filtro);
?>

<div class="container mt-5">
    <h2 class="mb-4">Dashboard</h2>

    <!-- Filtro -->
    <form method="GET" class="mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <label for="filtro" class="col-form-label">Filtrar por:</label>
            </div>
            <div class="col-auto">
                <select name="filtro" id="filtro" class="form-select" onchange="this.form.submit()">
                    <option value="todos" <?= $filtro === 'todos' ? 'selected' : '' ?>>Todos</option>
                    <option value="hoje" <?= $filtro === 'hoje' ? 'selected' : '' ?>>Hoje</option>
                    <option value="7dias" <?= $filtro === '7dias' ? 'selected' : '' ?>>Últimos 7 dias</option>
                    <option value="mes" <?= $filtro === 'mes' ? 'selected' : '' ?>>Mês atual</option>
                </select>
            </div>
        </div>
    </form>

    <!-- Cards de Resumo -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total de Vendas</h5>
                    <p class="card-text fs-4"><?= $resumo['quantidade'] ?? 0 ?> vendas</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Valor Total</h5>
                    <p class="card-text fs-4">R$ <?= number_format($resumo['total'] ?? 0, 2, ',', '.') ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Ticket Médio</h5>
                    <p class="card-text fs-4">R$ <?= number_format($resumo['media'] ?? 0, 2, ',', '.') ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Placeholder pro gráfico -->
    <div class="card mb-4">
        <div class="card-header">Gráfico de Vendas</div>
        <div class="card-body">
            <canvas id="graficoVendas"></canvas>
        </div>
    </div>

    <!-- Listagens -->
    <div class="row">
        <div class="col-md-4">
            <h5>Top Produtos</h5>
            <ul class="list-group mb-3">
                <?php foreach ($ranking as $produto): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= $produto['produto'] ?>
                        <span class="badge bg-primary rounded-pill"><?= $produto['total'] ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="col-md-4">
            <h5>Formas de Pagamento</h5>
            <ul class="list-group mb-3">
                <?php foreach ($pagamentos as $pg): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= ucfirst($pg['forma_pagamento']) ?>
                        <span class="badge bg-success rounded-pill"><?= $pg['total'] ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="col-md-4">
            <h5>Últimas Vendas</h5>
            <ul class="list-group mb-3">
                <?php foreach ($ultimas as $venda): ?>
                    <li class="list-group-item">
                        <?= date('d/m H:i', strtotime($venda['data_hora'])) ?> - 
                        <strong><?= $venda['produto'] ?></strong> - 
                        R$ <?= number_format($venda['valor'], 2, ',', '.') ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('graficoVendas').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode(array_column($grafico, 'dia')) ?>,
            datasets: [{
                label: 'R$ em Vendas',
                data: <?= json_encode(array_column($grafico, 'total')) ?>,
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.2)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php require_once 'includes/footer.php'; ?>
