<main class="content">
    <div class="container-fluid p-0">
        <div class="clientes">
            <div class="card flex-fill">
                <div class="card-header">

                    <h5 class="card-title mb-0">Clientes cadastrado</h5>
                </div>
                <div class="tabela" style="padding: 20px;">
                    <table class="table table-hover my-0" id="clientes">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th class="d-none d-xl-table-cell">Email</th>
                                <th class="d-none d-xl-table-cell">telefone</th>
                                <th class="d-none d-xl-table-cell">Morada</th>
                                <th>Status</th>
                                <th>Encomendas</th>
                                <th class="d-none d-md-table-cell">Data cadastro</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clientes as $cliente) {  ?>
                                <tr>
                                    <td><?= $cliente->nome_completo ?></td>
                                    <td class="d-none d-xl-table-cell"><?= $cliente->email ?></td>
                                    <td class="d-none d-xl-table-cell"><?= $cliente->telefone ?></td>
                                    <td class="d-none d-xl-table-cell"><?= $cliente->morada ?></td>
                                    <td><span class="badge bg-success">Online</span></td>
                                    <td class="d-none d-xl-table-cell text-center"><a href="?loja=buscar_encomendas_usuarios&cliente=<?=$cliente->id_cliente?>"><?=$cliente->total_encomendas?></a></td>
                                    <td class="d-none d-md-table-cell"><?= $cliente->created_at ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</main>

<script>
    $(document).ready(function() {
        $('#clientes').DataTable({
            info: false,
            language: {
                lengthMenu: 'Apresenta _MENU_ encomendas por páginas',
                zeroRecords: 'Não foi encontrado nenhuma encomenda',
                info: 'Mostrando página _PAGE_ de um total _PAGES_',
                infoEmpty: 'Não existe encomendas disponiveis',
                infoFiltered: '(Filtrado de um total _MAX_ encomendas)',
                search: "Pesquisar:",
                paginate: {
                    first: "Primeira",
                    last: "Ultima",
                    next: "Avançar",
                    previous: "Voltar"
                },
            }
        });
    });
</script>