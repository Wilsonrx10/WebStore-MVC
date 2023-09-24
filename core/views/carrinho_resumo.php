<head>
    <style>
        img {
            width: 150px;
        }
    </style>
</head>
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="my-3">Resumo da sua Encomenda</h1>
            <hr>
        </div>
    </div>
</div>
<div class="container">
    <div class="rows">
        <div class="col-12">
            <div style="margin-bottom:140px">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Valor total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $index = 0;
                        $total_rows = count($carrinho);
                        ?>
                        <?php foreach ($carrinho as $produtos) { ?>
                            <?php if ($index < $total_rows - 1) { ?>

                                <!---Lista de produtos--->
                                <tr class="align-middle">
                                    <td><?= $produtos['titulo']; ?></td>
                                    <td><?= $produtos['quantidade']; ?></td>
                                    <td><?= number_format($produtos['preco'], 2, ",", ".") . "kz"; ?></td>
                                </tr>

                            <?php } else { ?>

                                <!---Total de Produtos--->
                                <tr>
                                    <td>Total: </td>
                                    <td><?= number_format($produtos['total'], 2, ",", ".") . "kz"; ?></td>
                                    <td></td>
                                </tr>

                            <?php } ?>
                            <?php $index++; ?>
                        <?php } ?>
                    </tbody>
                </table>


                <h4 class="bg-dark text-white p-2">Dados do cliente</h4>
                <div class="row">
                    <div class="col">
                        <p>Nome Completo: <strong><?= $cliente->nome_completo; ?></strong> </p>
                        <p>Morada: <strong><?= $cliente->morada; ?></strong> </p>
                        <p>Cidade: <strong><?= $cliente->cidade; ?></strong> </p>
                    </div>
                    <div class="col text-end">
                        <p>Email: <strong><?= $cliente->email; ?></strong> </p>
                        <p>telefone: <strong><?= $cliente->telefone; ?></strong> </p>
                    </div>
                </div>


                <!------Dados do Pagamento------>
                <h4 class="bg-dark text-white p-2">Dados de Pagamento</h4>
                <div class="row">
                    <div class="col">
                        <p>Conta Bancária : 123456789</p>
                        <p>Código da Encomenda : <?=$_SESSION['codigo_encomenda'];?></p>
                        <p>Total : <?=number_format($produtos['total'], 2,",", ".")?></p>
                    </div>
                </div>


                <!---------Morada Altenativa------------>
                <h4 class="bg-dark text-white p-2">Morada Altenativa</h4>
                <div>
                    <input type="checkbox" onchange="usar_morada_altenativa()" name="check_morada_altenativa" id="check_morada_altenativa" class="form-check-input">
                    <label class="form-check-label" for="check_morada_altenativa">Usar uma morada Altenativa</label>
                </div>
                

                <div class="nova-morada" style="display:none;">
                    <form>
                        <div class="mb-3">
                            <label for="text_morada_altenativa" class="form-label">Morada</label>
                            <input type="text" class="form-control" id="text_morada_altenativa" aria-describedby="emailHelp">
                        </div>

                        <div class="mb-3">
                            <label for="text_cidade_altenativa" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="text_cidade_altenativa" aria-describedby="emailHelp">
                        </div>

                        <div class="mb-3">
                            <label for="text_email_altenativa" class="form-label">Email</label>
                            <input type="email" class="form-control" id="text_email_altenativa">
                        </div>

                        <div class="mb-3">
                            <label for="text_telefone_altenativa" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="text_telefone_altenativa">
                        </div>

                    </form>
                </div>



                <div class="row my-5">
                    <div class="col">
                        <a href="?loja=carrinho" class="btn btn-primary">Cancelar encomenda</a>
                    </div>
                    <div class="col text-end">
                        <a href="?loja=confirmar_encomenda" onclick="morada_altenativa()" class="btn btn-primary">Finalizar encomenda</a>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>