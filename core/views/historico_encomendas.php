<style>
    .historico {
        background-color: white;
        -webkit-box-shadow: 5px 5px 15px 5px #ddd;
        box-shadow: 5px 5px 15px 5px #ddd;
        padding: 20px;
    }
</style>

<div class="container">

    <div class="historico" id="historico">
        <h3>Histórico de Encomendas</h3>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Data_encomenda</th>
                    <th scope="col">Codigo_encomenda</th>
                    <th scope="col">Status</th>
                    <th scope="col">Detalhes</th>
                </tr>
            </thead>
            <tbody>
                <?php

                use core\classes\Store;

                foreach ($dados['historico_encomenda'] as $dados) { ?>
                    <tr>
                        <td><?= $dados->data_encomenda ?></td>
                        <td><?= $dados->codigo_encomenda ?></td>
                        <td><?= $dados->status ?></td>
                        <td><a href="?loja=detalhes_encomenda&id=<?= Store::aesEncriptar($dados->id_encomenda) ?>">detalhes</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>


</div>