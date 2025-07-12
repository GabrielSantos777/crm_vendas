<?php
require_once('controllers/Reservas.php');
$listaReservas = listarReservas();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cliente'], $_POST['forma_pagamento'], $_POST['status'])) {
    cadastrarReservas();
}

?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Reservas</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalReserva">+ Nova Reserva</button>
    </div>




    <!-- Tabela de reservas -->
    <div class="table">
        <table class="table table-striped" id="tabelaReservas">
            <thead>
                <tr>
                    <th>CPF</th>
                    <th>Cliente</th>
                    <th>Pedido</th>
                    <th>Quantidade</th>
                    <th>Valor Total</th>
                    <th>Data</th>
                    <th>Forma de Pagamento</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaReservas as $reserva): ?>
                    <tr>
                        <td><?= htmlspecialchars($reserva['cpf']) ?></td>
                        <td><?= htmlspecialchars($reserva['cliente']) ?></td>
                        <td><?= htmlspecialchars($reserva['produto']) ?></td>
                        <td><?= htmlspecialchars($reserva['quantidade']) ?></td>
                        <td>R$ <?= number_format($reserva['total'], 2, ',', '.') ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($reserva['data_hora'])) ?></td>
                        <td><?= ucfirst($reserva['forma_pagamento']) ?></td>
                        <td><?= ucwords($reserva['status']) ?></td>
                        <td>
                            <button
                                class="btn btn-sm btn-primary btn-editar-reserva"
                                data-reserva='<?= json_encode($reserva) ?>'
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditarReserva">
                                <span class="material-icons">
                                    info
                                </span>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<!-- Modal Nova Reserva -->
<div class="modal fade" id="modalReserva" tabindex="-1" aria-labelledby="modalReservaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" id="formNovaReserva" method="post">
            <div class="modal-header">
                <h5 class="modal-title" id="modalReservaLabel">Reservas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">CPF</label>
                    <input type="text" class="form-control" maxlength="11" name="cpf" required>
                </div>
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
                    <div class="text-end fw-bold">Total: R$ <span id="totalReserva">0.00</span></div>
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
                <button type="submit" class="btn gravarReserva btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>


<!-- Modal Editar Reserva -->
<div class="modal fade" id="modalEditarReserva" tabindex="-1" aria-labelledby="modalEditarReservaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" id="formEditarReserva" method="post">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarReservaLabel">Editar Reserva</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">

                <input type="hidden" name="id" id="edit_id">

                <div class="mb-3">
                    <label class="form-label">CPF</label>
                    <input type="text" class="form-control" name="cpf" id="edit_cpf" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Cliente</label>
                    <input type="text" class="form-control" name="cliente" id="edit_cliente" required>
                </div>
                <div class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Produto</label>
                        <input type="text" class="form-control" name="produto" id="edit_produto" placeholder="Nome do produto">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Preço Unit.</label>
                        <input type="number" class="form-control" name="preco" id="preco" step="0.01" placeholder="0.00">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Qtd</label>
                        <input type="number" class="form-control" name="quantidade" id="edit_quantidade" placeholder="1">
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
                    <div class="text-end fw-bold">Total: R$ <span id="totalReserva">0.00</span></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Data</label>
                    <input type="datetime-local" class="form-control" disabled name="data_hora" id="edit_data_hora" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Forma de Pagamento</label>
                    <select class="form-select" name="forma_pagamento" id="edit_forma_pagamento">
                        <option value="card">Card</option>
                        <option value="money">Money</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status" id="edit_status">
                        <option value="pago">Pago</option>
                        <option value="pendente">Pendente</option>
                        <option value="reservado">Reservado</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <button type="button" class="btn btn-danger" id="btnExcluirReserva">Excluir</button>
            </div>
        </form>
    </div>
</div>




<style>
    #tabelaReservas tbody {
        display: block;
        max-height: 700px;
        overflow-y: auto;
    }

    #tabelaReservas td {
        text-wrap: nowrap;
        text-align: center;
    }

    #tabelaReservas thead,
    #tabelaReservas tbody tr {
        display: table;
        text-align: center;
        width: 100%;
        table-layout: fixed;
    }
</style>
<script>
    // MODAL PRODUTOS (NOVA VENDA)
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

        document.getElementById("totalReserva").innerText = total.toFixed(2);
    }
    // REMOVER PRODUTOS
    function removerProduto(index) {
        produtos.splice(index, 1);
        atualizarTabela();
    }
    // ADICIONAR PRODUTOS(MODAL)
    document.getElementById("btnAdicionarProduto").addEventListener("click", () => {
        const nome = document.getElementById("produto").value;
        const preco = parseFloat(document.getElementById("preco").value);
        const quantidade = parseInt(document.getElementById("quantidade").value);

        if (!nome || preco <= 0 || quantidade <= 0) {
            alert("Preencha os campos corretamente.");
            return;
        }

        produtos.push({
            nome: nome,
            preco: parseFloat(preco),
            quantidade: parseInt(quantidade)
        });

        atualizarTabela();

        // Limpa os campos após adicionar
        document.getElementById("produto").value = "";
        document.getElementById("preco").value = "";
        document.getElementById("quantidade").value = "";
    });

    // ENVIO DO FORMULÁRIO DE VENDA
    document.getElementById("formNovaReserva").addEventListener("submit", function(e) {
        if (produtos.length === 0) {
            alert("Adicione pelo menos um produto.");
            e.preventDefault();
            return;
        }

        // Cria input escondido para enviar os produtos em JSON
        const inputProdutos = document.createElement("input");
        inputProdutos.type = "hidden";
        inputProdutos.name = "produtos";
        inputProdutos.value = JSON.stringify(produtos);
        this.appendChild(inputProdutos);

        window.location.reload()
    });

    document.querySelector('.gravarReserva').addEventListener('click', function() {
        window.location.reload()
    });


    document.addEventListener('DOMContentLoaded', function() {
        const botoesEditar = document.querySelectorAll('.btn-editar-reserva');
        const formEditar = document.getElementById('formEditarReserva');

        botoesEditar.forEach(btn => {
            btn.addEventListener('click', () => {
                const reserva = JSON.parse(btn.getAttribute('data-reserva'));

                document.getElementById('edit_id').value = reserva.id || ''; // só se tiver um ID
                document.getElementById('edit_cpf').value = reserva.cpf;
                document.getElementById('edit_cliente').value = reserva.cliente;
                document.getElementById('edit_produto').value = reserva.produto;
                document.getElementById('edit_quantidade').value = reserva.quantidade;
                document.getElementById('edit_total').value = reserva.total;
                document.getElementById('edit_data_hora').value = new Date(reserva.data_hora).toISOString().slice(0, 16);
                document.getElementById('edit_forma_pagamento').value = reserva.forma_pagamento;
                document.getElementById('edit_status').value = reserva.status;
            });
        });

        // Ação de exclusão
        document.getElementById('btnExcluirReserva').addEventListener('click', function() {
            if (confirm('Tem certeza que deseja excluir esta reserva?')) {
                const id = document.getElementById('edit_id').value;

                fetch(`excluir_reserva.php?id=${id}`, {
                    method: 'GET'
                }).then(res => location.reload());
            }
        });

        // Submissão do formulário (edição)
        formEditar.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(formEditar);
            fetch('editar_reserva.php', {
                method: 'POST',
                body: formData
            }).then(res => location.reload());
        });
    });
</script>