<main class="content">
    <div class="formulario">
        <h2 class="Light">Adicionar Produto => </h2>
        <form class="row g-3" method="POST" action="?loja=AdicionarProductSubmit"
        enctype="multipart/form-data">
            <div class="col-md-6">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" name="product_nome">
            </div>

            <div class="col-md-6">
                <label for="precoCusto" class="form-label">Preço de Custo</label>
                <input type="number" class="form-control" id="precoCusto" name="product_precoCusto">
            </div>


            <div class="col-md-6">
                <label for="precoVenda" class="form-label">Preço de Venda</label>
                <input type="number" class="form-control" id="precoVenda" name="product_precoVenda">
            </div>

            <div class="col-md-6">
                <label for="desconto" class="form-label">Desconto</label>
                <input type="number" class="form-control" id="desconto" name="product_desconto">
            </div>
            
          
            <div class="col-md-6">
                <label for="quantidade" class="form-label">Quantidade</label>
                <input type="number" class="form-control" id="quantidade" name="product_quantidade">
            </div>

            <div class="col-md-4">
                <label for="TipoProduct" class="form-label">Tipo de Produto</label>
                <select id="TipoProduct" class="form-select" name="TipoProduct">
                    <option selected>Tipo de Produto</option>
                    <option value="gpu">GPU</option>
                    <option value="notebook">Notebook</option>
                </select>
            </div>

            <div class="col-md-2">
                <label for="foto" class="form-label">Foto Produto</label>
                <input type="file" class="form-control" id="foto" name="foto">
            </div>

            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Aceito todos os termos e direitos dessse formulário
                    </label>
                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Cadastrar Produto</button>
            </div>

        </form> <br> <br>

        <div class="erro">
            <?php if (isset($_SESSION['erro'])) { ?>
                <div class="alert alert-danger">
                     <?= $_SESSION['erro'] ?>
                     <?php unset($_SESSION['erro'])?>
                 </div>
            <?php } ?>
        </div>


        <div class="sucesso">
            <?php if (isset($_SESSION['sucess'])) { ?>
                <div class="alert alert-danger">
                     <?= $_SESSION['success'] ?>
                     <?php unset($_SESSION['success'])?>
                 </div>
            <?php } ?>
        </div>
    </div>
</main>