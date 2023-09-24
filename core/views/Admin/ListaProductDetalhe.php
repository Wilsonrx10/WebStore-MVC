<div class="container text-center">
    <div class="row">
        <div class="col">
            <a class="produto" name="informacao" href="#">Informação Produto</a>
        </div>
        <div class="col">
            <a class="produto" name="stock" href="#">Entrada em Stock</a>
        </div>
        <div class="col">
            <a class="produto" name="preco" href="#">Alterar preço</a>
        </div>
    </div>
</div>

<hr>

<div class="informacao">
    <input type="text" class="form-control nome" placeholder="nome do produto" 
    value="<?=$produtos_alteracao->nome_produto?>"> <br>

    <select class="form-control categoria">
    <option selected>Seleciona a categoria</option>
    <option value="<?=$produtos_alteracao->categoria?>"></option>
    </select> <br>

    <select class="form-control visibilidade">
    <option selected>Desativar este produto</option>
    <option value="SIM">SIM</option>
    <option value="NAO">NÃO</option>
    </select> <br>

    <button class="btn btn-primary atualizar">Efetuar Atualização</button>
</div>

<div class="entrada_stock">
    <input type="number" class="form-control qtd" placeholder="digita a quantidade" value="0"> <br>
    <button class="btn btn-primary atualizar">Efetuar Atualização</button>
</div>

<div class="alterar_preco">
    <input type="number" class="form-control precoCusto" placeholder="preço de custo"
    value="<?=$produtos_alteracao->preco_custo?>"> <br>
    <input type="number" class="form-control precoVenda" placeholder="preço de venda"
    value="<?=$produtos_alteracao->preco_venda?>"> <br>
    <button class="btn btn-primary atualizar">Efetuar Atualização</button>
</div>


<script>
$(document).ready(function() {
let informacao = document.querySelector(".informacao");
let entrada_stock = document.querySelector(".entrada_stock");
let alterar_preco = document.querySelector(".alterar_preco");

informacao.style.display = 'block';
entrada_stock.style.display = 'none';
alterar_preco.style.display = 'none';

$('.produto').click(function(){
evento = $(this).attr('name');
if (evento == "informacao") {
informacao.style.display = 'block';
entrada_stock.style.display = 'none';
alterar_preco.style.display = 'none';
} else if (evento == "stock") {
informacao.style.display = 'none';
entrada_stock.style.display = 'block';
alterar_preco.style.display = 'none';
} else {
informacao.style.display = 'none';
entrada_stock.style.display = 'none';
alterar_preco.style.display = 'block';
}
})

// Fazer a requisição para atualização do produto
$('.atualizar').click(function(event){
event.preventDefault();
axios.defaults.widthCredentials = true;
axios({
method:"POST",
url:"?loja=Editar_informacao_produto",
data:{
id: $('#prod').val(),
nome: $('.nome').val(),
categoria:$('.categoria').val(),
visibilidade:$('.visibilidade').val(),
quantidade:$('.qtd').val(),
precoCusto:$('.precoCusto').val(),
precoVenda:$('.precoVenda').val()
} 
}).then((response)=>{
console.log(response.data)
setInterval(()=>{
// Carregar o loading durante 3 segundos 
},3000);
}).catch((erro)=>{
console.log(erro)
})
})
});
</script>