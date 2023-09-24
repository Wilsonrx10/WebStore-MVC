<head>
    <style>
        img {
            width: 60px;
            background-color: transparent;
        }

        .tabela {
            background-color: white;
            -webkit-box-shadow: 5px 5px 15px 5px #ccc;
            box-shadow: 5px 5px 15px 5px #ccc;
            padding: 20px;
        }
    </style>
</head>
<div class="container tabela">
    <div class="rows">
        <div class="col-12">
            <?php if ($carrinho == null) { ?>
                <h4 class="text-center">Não existe encomendas nesse Carrinho</h4>
            <?php } else { ?>
                <table class="table table-hover">
                    <h1 class="Light">Minhas Encomendas</h1>
                    <thead>
                        <tr>
                            <th>Imagem</th>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Valor total</th>
                            <th>Alterar</th>
                            <th>Eliminar</th>
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
                                    <td><img src="assets/images/placas/<?= $produtos['imagem']; ?>"></td>
                                    <td><?= $produtos['titulo']; ?></td>
                                    <td><?= $produtos['quantidade']; ?></td>
                                    <td><?= number_format($produtos['preco'], 2, ",", ".") . "kz"; ?></td>
                                    <td>
                                        <a class="quantidade" name="reduzir" id="<?=$produtos['id_produto']?>" href="#"><i class="fas fa-minus"></i></a>
                                        <a class="quantidade" name="aumentar" id="<?=$produtos['id_produto']?>" href="#"><i class="fas fa-plus"></i></a>
                                    </td>
                                    <td>
                                        <a href="?loja=eliminar_produto_carrinho&id_produto=<?= $produtos['id_produto']; ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>

                            <?php } else { ?>

                                <!---Total de Produtos--->
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>Total: </td>
                                    <td><?= number_format($produtos['total'], 2, ",", ".") . "kz"; ?></td>
                                    <td></td>
                                </tr>
                            <?php } ?>
                            <?php $index++; ?>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col">
                        <a href="#" class="botoes" data-bs-toggle="modal" data-bs-target="#exampleModal">Limpar carrinho <i class="fas fa-cart-arrow-down"></i></a>
                    </div>
                    <div class="col text-end">
                        <a href="?loja=loja" class="botoes">Continuar a comprar <i class="fas fa-cart-plus"></i></a>
                        <a href="?loja=finalizar_encomenda" class="botoes">Finalizar a encomenda <i class="fas fa-clipboard-check"></i></a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Carrinho</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Tens certeza que desejas limpar todos os produtos
                do seu carrinho ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button onclick="limpar_carrinho();" class="btn btn-primary">Limpar Carrinho</button>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/jquery.js"></script>
<script>
$(document).ready(function(){
$('.quantidade').click(function(){
let id = $(this).attr('id')
let acao = $(this).attr('name')
axios({
method:"POST",
url:"?loja=alterar_quantidade_carrinho",
data:{
id_produto:id,
acao:acao
}
}).then((response)=>{
location.reload(true);
}).catch((erro)=>{
console.log("ocorreu um erro");
})
});
});
</script>