<main class="content">
  <div class="tabela">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Imagem</th>
          <th scope="col">Nome</th>
          <th scope="col">preçoVenda</th>
          <th scope="col">preçoCusto</th>
          <th scope="col">Quantidade</th>
          <th scope="col">Lucro</th>
          <th>Alterar</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($produtos as $produto) { ?>
          <tr>
            <td><?= $produto->id_produto ?></td>
            <td><?= $produto->nome_produto ?></td>
            <td><?= number_format($produto->preco_venda,2,",",".")."kz" ?></td>
            <td><?= number_format($produto->preco_custo,2,",",".")."kz" ?></td>
            <td><?= $produto->stock ?></td>
            <td><?= number_format($produto->lucro,2,",",".")."kz" ?></td>
            <td><a class="produto" id="<?= $produto->id_produto ?>" href="#">editar</a></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</main>

<!---Informação do Produto , permitir alterar Stock---->
<div class="tela" id="tela">
  <div class="tela-content">
    <span id="fechar">&times;</span>
    <h2 style="font-family:Calibri; color: #818181; font-weight: normal;">Produto detalhe</h2>
    <div class="produtos">
      <div class="movimentos">

        <div>
          <p><i class="fas fa-cart-arrow-down"></i> Vendidos => 1982</p>
        </div>

        <div>
          <p><i class="fas fa-cart-plus"></i> Stock => 19</p>
        </div>

        <div>
          <p><i class="fas fa-shipping-fast"></i> movimentos => 1762</p>
        </div>
      </div>

      <hr>

      <div id="prod"></div>

      <div class="Editar_prod">

      </div>
    </div>
  </div>
</div>

<script>

$(document).ready(function() {
    $('.produto').click(function() {
      var id = $(this).attr('id')
      // Enviando para a modal o id e o nome do produto a ser eliminado
		  $('#prod').val(id)
      let modal = $('#tela');
      modal.addClass("show-modal");
      // Executar a requisição Ajax para levar o id do Produto no Modal 
      axios.defaults.widthCredentials = true;
      axios({
      method:"POST",
      url: "?loja=informacoes_produtos_alteracao",
      data: {
      id_produto: id
      }
      }).then(function(response) {
      $('.Editar_prod').html(response.data);
      }).catch(()=>{
      console.log("erro")
      })
    });
  });

  // Fechar o Modal
  let fechar = document.getElementById("fechar");
  fechar.addEventListener("click", fecharModal);

  function fecharModal() {
    let modal = document.getElementById("tela");
    modal.classList.remove("show-modal");
  }
</script>