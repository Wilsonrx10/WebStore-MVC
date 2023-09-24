<main class="content">
    <div class="tabela">

        <table class="table table-hover">
            <h2>Dados da Encomenda</h2>

            <div class="estado_encomenda">
            <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            Mudar Estado
            </button>
            <ul class="dropdown-menu">
            <li><a onclick="MudarEstado('PENDENTE')" class="dropdown-item" href="#">Pendente</a></li>
            <li><a onclick="MudarEstado('EM_PROCESSO')" class="dropdown-item" href="#">Em processo</a></li>
            <li><a onclick="MudarEstado('APROVADA')" class="dropdown-item" href="#">Aprovada</a></li>
            <li><a onclick="MudarEstado('CANCELADA')" class="dropdown-item" href="#">Cancelada</a></li>
            </ul>
            </div>
            </div>

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
                        <td><?= number_format($dados_produto_encomenda->preco_unidade, 2, ",", ".") . "kz" ?></td>
                        <td><?= $dados_produto_encomenda->quantidade ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div>
            <h2><strong>Total de Encomendas : <?= number_format($total_encomenda, 2, ",", ".") . "kz" ?></strong></h2>
        </div>
    </div>
</main>


<!------Modal para confirmação------>

<div class="modal fade" id="estado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmação</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Tens certeza que desejas Mudar o estado dessa encomenda ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary confirmar">Confirmar</button>
      </div>
    </div>
  </div>
</div>

<script>
function MudarEstado(event) {
    const valor = event;
    const modalDetalhe = new bootstrap.Modal('#estado');
    modalDetalhe.show();
    
    let confirmar = document.querySelector(".confirmar");
    confirmar.addEventListener("click",trocarEstado);
    function trocarEstado() {
    var url_string = window.location.href;
    var url = new URL(url_string);
    var id = url.searchParams.get("encomenda");
    axios.defaults.widthCredentials = true;
    axios({
    method:"POST",
    url:"?loja=Mudar_Estado_encomenda",
    data: {
    estado_atual:valor,
    id_encomenda:id
    }
    }).then((response)=>{
    modalDetalhe.hide();
    console.log(response.data)
    }).catch((erro)=>{
    console.log(erro)
    })
    }
    }
</script>