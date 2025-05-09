<?php
require_once('controllers/Vendas.php');
$vendas = listarVendas();

?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Vendas</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalVenda">+ Nova Venda</button>
    </div>




    <!-- Tabela de vendas -->
    <div class="table-responsive">
        <table class="table table-striped" id="tabelaVendas">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Cliente</th>
                    <th>Pedido</th>
                    <th>Quantidade</th>
                    <th>Valor Total</th>
                    <th>Forma de Pagamento</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vendas as $venda): ?>
                    <tr>
                        <td><?= date('d/m/Y H:i', strtotime($venda['data_hora'])) ?></td>
                        <td><?= htmlspecialchars($venda['cliente']) ?></td>
                        <td><?= htmlspecialchars($venda['produto']) ?></td>
                        <td><?= htmlspecialchars($venda['quantidade']) ?></td>
                        <td>R$ <?= number_format($venda['total'], 2, ',', '.') ?></td>
                        <td><?= ucfirst($venda['forma_pagamento']) ?></td>
                        <td><?= ucwords($venda['status']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


    <!-- Tabela de reservas -->
    <div class="class mt-5">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Reservas</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalReserva">+ Nova Reserva</button>
        </div>
        <div class="table-responsive">
            <table class="table table-responsive" id="tabelaReservas">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Data/Hora</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dados -->
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal Nova Venda -->
<div class="modal fade" id="modalVenda" tabindex="-1" aria-labelledby="modalVendaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" id="formNovaVenda" method="post">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVendaLabel">Nova Venda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Cliente</label>
                    <input type="text" class="form-control" name="cliente" required>
                </div>

                <div class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Produto</label>
                        <input type="text" class="form-control" name="produto" id="produto" placeholder="Nome do produto">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Preço Unit.</label>
                        <input type="number" class="form-control" name="preco" id="preco" step="0.01" placeholder="0.00">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Qtd</label>
                        <input type="number" class="form-control" name="quantidade" id="quantidade" placeholder="1">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-success w-100" id="btnAdicionarProduto">Adicionar</button>
                    </div>
                </div>


                <div class="mt-3">
                    <table class="table table-sm table-bordered" id="tabelaProdutos">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Preço Unit.</th>
                                <th>Qtd</th>
                                <th>Subtotal</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <div class="text-end fw-bold">Total: R$ <span id="totalVenda">0.00</span></div>
                </div>


                <div class="mt-3">
                    <div class="mb-3">
                        <label class="form-label">Forma de Pagamento</label>
                        <select class="form-select" name="forma_pagamento">
                            <option value="card">Card</option>
                            <option value="money">Money</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="pago">Pago</option>
                            <option value="pendente">Pendente</option>
                            <option value="reservado">Reservado</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL NOVA RESERVA -->
<div class="modal fade" id="modalReserva" tabindex="-1" aria-labelledby="modalReservaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" class="modal-content" id="formNovaReserva">
            <div class="modal-header">
                <h5 class="modal-title" id="modalReservaLabel">Nova Reserva</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Cliente</label>
                    <input type="text" class="form-control" name="cliente" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Produto</label>
                    <input type="text" class="form-control" name="produto" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Data/Hora desejada</label>
                    <input type="datetime-local" name="data_hora" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="reservado">Reservado</option>
                        <option value="pendente">Pendente</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Salvar Reserva</button>
            </div>
        </form>
    </div>
</div>

<style>
    #tabelaVendas tbody {
        display: block;
        max-height: 400px;
        overflow-y: auto;
    }

    #tabelaVendas td {
        text-wrap: nowrap;
        text-align: center;
    }

    #tabelaVendas thead,
    #tabelaVendas tbody tr {
        display: table;
        text-align: center;
        width: 100%;
        table-layout: fixed;
    }
</style>
<script>
    let produtos = [];


    function atualizarTabela() {
        const tbody = document.querySelector("#tabelaProdutos tbody");
        tbody.innerHTML = "";
        let total = 0;

        produtos.forEach((p, i) => {
            const subtotal = p.preco * p.quantidade;
            total += subtotal;

            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${p.nome}</td>
                <td>R$ ${p.preco.toFixed(2)}</td>
                <td>${p.quantidade}</td>
                <td>R$ ${(subtotal).toFixed(2)}</td>
                <td><button class="btn btn-sm btn-danger" onclick="removerProduto(${i})">Remover</button></td>
            `;
            tbody.appendChild(tr);
        });

        document.getElementById("totalVenda").innerText = total.toFixed(2);
    }

    function removerProduto(index) {
        produtos.splice(index, 1);
        atualizarTabela();
    }

    document.getElementById("btnAdicionarProduto").addEventListener("click", () => {
        const nome = document.getElementById("produto").value;
        const preco = parseFloat(document.getElementById("preco").value);
        const quantidade = parseInt(document.getElementById("quantidade").value);

        if (!nome || isNaN(preco) || isNaN(quantidade)) {
            alert("Preencha os campos corretamente.");
            return;
        }

        produtos.push({
            nome,
            preco,
            quantidade
        });
        atualizarTabela();

        document.getElementById("produto").value = "";
        document.getElementById("preco").value = "";
        document.getElementById("quantidade").value = "";
    });



    document.getElementById("formNovaVenda").addEventListener("submit", function(e) {
        e.preventDefault();

        const cliente = this.querySelector('input[name="cliente"]').value;
        const forma_pagamento = this.querySelector('select[name="forma_pagamento"]').value;
        const status = this.querySelector('select[name="status"]').value;

        const total = produtos.reduce((acc, p) => acc + (p.preco * p.quantidade), 0);

        const jsonData = JSON.stringify({
            cliente,
            forma_pagamento,
            status,
            produtos,
            total
        });


        fetch("/controllers/Vendas.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: jsonData
            })

            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Venda cadastrada com sucesso!");
                    this.reset();
                    produtos = [];
                    atualizarTabela();
                } else {
                    alert("Erro ao cadastrar venda.");
                }
            })
            .catch(err => {
                console.error("Erro na requisição:", err);
                alert("Erro ao enviar os dados.");
            });
    });

    const modalVenda = document.getElementById('modalVenda');
    modalVenda.addEventListener('shown.bs.modal', () => {
        modalVenda.removeAttribute('aria-hidden');
        modalVenda.querySelector('input[name="cliente"]').focus();
    });



    document.getElementById("formNovaReserva").addEventListener("submit", function(e) {
        e.preventDefault();

        const cliente = this.querySelector('input[name="cliente"]').value;
        const produto = this.querySelector('input[name="produto"]').value;
        const data_hora = this.querySelector('input[name="data_hora"]').value;
        const status = this.querySelector('select[name="status"]').value;

        const jsonData = JSON.stringify({
            cliente,
            produto,
            data_hora,
            status,
            tipo: "reserva"
        });

        fetch("/controllers/Reservas.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: jsonData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Reserva salva com sucesso!");
                    this.reset();
                    // Ideal: atualizar a tabela de reservas automaticamente
                } else {
                    alert("Erro ao salvar reserva.");
                }
            })
            .catch(err => {
                console.error("Erro ao enviar os dados:", err);
                alert("Erro no envio.");
            });
    });
</script>