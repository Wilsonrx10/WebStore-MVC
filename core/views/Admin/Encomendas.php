<main class="content">
    <div class="container-fluid p-0">
        <!--Apresentar as informações sobre o total de encomendas-->
        <?php if ($total_encomenda_pendente == 0) { ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Não existe encomendas disponiveis
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } else { ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                Tens <strong><?= $total_encomenda_pendente ?></strong> encomenda para confirmar
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>


        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Escolher o Estado
            </button>
            <ul class="dropdown-menu">
                <li><a onclick="Selecionar_filtro('pendente')" class="dropdown-item" href="#">Pendente</a></li>
                <li><a onclick="Selecionar_filtro('em_processamento')" class="dropdown-item" href="#">Em processamento</a></li>
                <li><a onclick="Selecionar_filtro('cancelada')" class="dropdown-item" href="#">Canceladas</a></li>
                <li><a onclick="Selecionar_filtro('concluida')" class="dropdown-item" href="#">Concluido</a></li>
            </ul>
        </div> <br> <br>


        <?php if (isset($_GET['f'])) { ?>
            <div class="tabela">
                <table class="table table-striped" id="tabela-encomendas">
                    <thead>
                        <tr>
                            <th scope="col">Referência</th>
                            <th scope="col">Nome</th>
                            <th scope="col">telefone</th>
                            <th scope="col">Status</th>
                            <th scope="col">data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lista_encomendas_filtro as $filtro) { ?>
                            <tr>
                                <td><a href="#"><?=$filtro->codigo_encomenda ?></a></td>
                                <td><?= $filtro->nome_completo ?></td>
                                <td><?= $filtro->telefone ?></td>
                                <td><span class="badge bg-success"><?= $filtro->status ?></span></td>
                                <td><?= $filtro->data_encomenda ?></td>
                            </tr>
                        <?php  } ?>
                        <tr>
                    </tbody>
                </table>
            </div>

        <?php } else { ?>
            <div class="tabela">
                <table class="table table-striped" id="tabela-encomendas">
                    <thead>
                        <tr>
                            <th scope="col">Referência</th>
                            <th scope="col">Nome</th>
                            <th scope="col">telefone</th>
                            <th scope="col">Status</th>
                            <th scope="col">data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($encomendas_pendente as $pendente) { ?>
                            <tr>
                                <td><a href="?loja=detalhes_encomenda_geral&encomenda=<?= $pendente->id_encomenda ?>"><?= $pendente->codigo_encomenda ?></a></td>
                                <td><?= $pendente->nome_completo ?></td>
                                <td><?= $pendente->telefone ?></td>
                                <td><span class="badge bg-success"><?= $pendente->status ?></span></td>
                                <td><?= $pendente->data_encomenda ?></td>
                            </tr>
                        <?php  } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </div>
</main>

<script>
    $(document).ready(function() {
        $('#tabela-encomendas').DataTable({
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

<script>
    function Selecionar_filtro(filtro) {
        window.location.href = window.location.pathname + "?" + $.param({
            'loja': "encomendas",
            'f': filtro
        });
    }
</script>