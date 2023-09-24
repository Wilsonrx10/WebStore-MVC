<main class="content">
    <div class="container-fluid p-0">
        <div class="tabela">
            <table class="table table-striped" id="tabela-encomendas">
                <thead>
                    <tr>
                        <th scope="col">Referência</th>
                        <th scope="col">telefone</th>
                        <th scope="col">Status</th>
                        <th scope="col">data feita a encomenda</th>
                        <th>Detalhes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($encomendas_cliente as $encomenda_cliente) { ?>
                        <tr>
                            <td><?= $encomenda_cliente->codigo_encomenda ?></td>
                            <td><?= $encomenda_cliente->telefone ?></td>
                            <td><span class="badge bg-success"><?= $encomenda_cliente->status ?></span></td>
                            <td><?= $encomenda_cliente->data_encomenda ?></td>
                            <td><a class="encomenda_detalhe"  id="<?= $encomenda_cliente->id_encomenda ?>" href="#">detalhar</a></td>
                        </tr>
                    <?php  } ?>
                    <tr>
                </tbody>
            </table>
        </div>
    </div>
</main>


<!------Modal para Detalhar os Produtos------>

<div class="modal fade" id="encomenda" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-xxl-down">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel">Encomendas Cliente</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="encomendas_cliente">
                    <div class="tabela">

                        <table class="table table-hover">
                            <h2>Dados da Encomenda</h2>
                            <thead>
                                <tr>
                                    <th scope="col">data_encomenda</th>
                                    <th scope="col">cidade</th>
                                    <th scope="col">email</th>
                                    <th scope="col">telefone</th>
                                    <th scope="col">codigo_encomenda</th>
                                    <th scope="col">status</th>
                                </tr>
                            </thead>
                            <tbody>

                                    <tr>
                                    <td><?= $_SESSION['dados_encomenda']->data_encomenda ?></td>
                                    <td><?= $_SESSION['dados_encomenda']->cidade ?></td>
                                    <td><?= $_SESSION['dados_encomenda']->telefone ?></td>
                                    <td><?= $_SESSION['dados_encomenda']->email ?></td>
                                    <td><?= $_SESSION['dados_encomenda']->codigo_encomenda ?></td>
                                    <td style="color:green; font-weight:600;"><?= $_SESSION['dados_encomenda']->status ?></td>
                                </tr>
                            </tbody>
                        </table>


                        <table class="table table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">designacao_produto</th>
                                    <th scope="col">preco_unidade</th>
                                    <th scope="col">quantidade</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($_SESSION['detalhe_encomenda_usuario'] as $detalhe) { ?>
                                    <tr>
                                        <td><?= $detalhe->designacao_produto ?></td>
                                        <td><?= $detalhe->preco_unidade ?></td>
                                        <td><?= $detalhe->quantidade ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <div>
                        <h3><strong>Total de Encomendas : <?= number_format($_SESSION['total_encomenda_detalhe'], 2, ",", ".") . "kz" ?></strong></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
$('.encomenda_detalhe').click(function(){
var id = $(this).attr('id')
new bootstrap.Modal('#encomenda').show();
// Executar a requisição Ajax para levar o id da encomenda no Modal 
axios.defaults.widthCredentials = true;
axios({
method:"POST",
url: "?loja=buscar_encomendas_usuarios_detalhada",
data: {
id_encomenda_detalhe: id
}
}).then(function(response) {
console.log(response.data);
});
});
});
</script>

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