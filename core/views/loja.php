<!-------CAROSSEL------->
<div id="myCarousel" class="carousel slide" data-bs-ride="carousel" style="margin-top: -13px;">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">

        <div class="carousel-item active">
            <img src="assets/images/slider/slider02.jpg" width="100%" height="100%" class="bd-placeholder-img" aria-hidden="true">
            <div class="container">
                <div class="carousel-caption text-start">
                    <h1>Placas de Vídeo no melhor preço do mercado</h1>
                    <p>Some representative placeholder content for the first slide of the carousel.</p>
                    <p><a class="btn btn-lg btn-primary" href="#">Começar a comprar</a></p>
                </div>
            </div>
        </div>


        <div class="carousel-item">
            <img src="assets/images/slider/slider02.jpg" width="100%" height="100%" class="bd-placeholder-img" aria-hidden="true">
            <div class="container">
                <div class="carousel-caption text-start">
                    <h1>Placas de Vídeo no melhor preço do mercado</h1>
                    <p>Some representative placeholder content for the first slide of the carousel.</p>
                    <p><a class="btn btn-lg btn-primary" href="#">Começar a comprar</a></p>
                </div>
            </div>
        </div>


        <div class="carousel-item">
            <img src="assets/images/slider/slider02.jpg" width="100%" height="100%" class="bd-placeholder-img" aria-hidden="true">
            <div class="container">
                <div class="carousel-caption text-start">
                    <h1>Placas de Vídeo no melhor preço do mercado</h1>
                    <p>Some representative placeholder content for the first slide of the carousel.</p>
                    <p><a class="btn btn-lg btn-primary" href="#">Começar a comprar</a></p>
                </div>
            </div>
        </div>


    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>


<div class="container" style="margin-right: 150px;">


<!------------Produtos-------------->

    <?php if (count($produtos) == 0) { ?>
        <div class="text-center my-5">
            <h3>Não existe Produtos disponivel</h3>
        </div>
    <?php } else { ?>
        <div class="colunas">
            <?php foreach ($produtos as $produto) { ?>

                <div class="caixa">
                    <div class="imagem">
                        <img src="assets/images/placas/<?= $produto->imagem; ?>">
                    </div>

                    <div class="preco">
                        <p><?= $produto->nome_produto; ?></p>
                        <h3><?= number_format($produto->preco_venda,2,",",".")."kz" ?></h3>
                    </div>

                    <div class="icones">
                        <?php if ($produto->stock <= 0) { ?>
                            <button class="btn btn-danger">Esgotou o stock<i class="fas fa-shopping-cart"></i></button>
                        <?php } else { ?>
                            <i onclick="adicionar_carrinho(<?= $produto->id_produto ?>)" class="fas fa-shopping-cart"></i>
                            <i class="fas fa-eye"></i>
                        <?php } ?>
                    </div>

                </div>

            <?php } ?>

        </div>

    <?php } ?>

</div>