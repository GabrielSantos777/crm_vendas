<?php
require_once 'includes/header.php';
require_once 'controllers/Dashboard.php';

$controller = new Dashboard();
$resumo = $controller->obterResumo();

?>

<div class="container">
    <h1 class="mt-4">Dashboard</h1>
    <div class="row mt-5">
        <div class="col-md-3">
            <div class="card bg-light p-3">
                <h4>Total de Vendas</h4>
                <p>R$ <?= number_format($resumo['total'], 2, ',', '.') ?></p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light p-3">
                <h4>Quantidade de Vendas</h4>
                <p><?= $resumo['quantidade'] ?> vendas</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light p-3">
                <h4>Média por Venda</h4>
                <p>R$ <?= number_format($resumo['media'], 2, ',', '.') ?></p>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
