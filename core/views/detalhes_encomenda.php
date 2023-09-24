<head>
    <style>
        .tabela {
            background-color: white;
            -webkit-box-shadow: 5px 5px 15px 5px #ccc;
            box-shadow: 5px 5px 15px 5px #ccc;
            padding: 20px;
        }
    </style>
</head>
<div class="container">
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
                <td><?= $dados_encomenda->data_encomenda ?></td>
                <td><?= $dados_encomenda->cidade ?></td>
                <td><?= $dados_encomenda->email ?></td>
                <td><?= $dados_encomenda->telefone ?></td>
                <td><?= $dados_encomenda->codigo_encomenda ?></td>
                <td style="color:green; font-weight:600;"><?= $dados_encomenda->status ?></td>

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
            <?php
            foreach ($produtos_encomenda as $dados_produto_encomenda) { ?>
                <tr>
                    <td><?= $dados_produto_encomenda->designacao_produto ?></td>
                    <td><?= number_format($dados_produto_encomenda->preco_unidade, 2, ",", ".")."kz" ?></td>
                    <td><?= $dados_produto_encomenda->quantidade ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div>
        <p><strong>Total de Encomendas : <?= number_format($total_encomenda, 2, ",", ".")."kz" ?></strong></p>
    </div>
</div>
</div>