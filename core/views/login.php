<div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5">
        <div class="col-lg-7 text-center text-lg-start">
            <h1 class="display-4 fw-bold lh-1 mb-3">Loja de Materias Electronico</h1>
            <p class="col-lg-10 fs-4">Faça seu login para ter acesso ao diversos produtos disponivel na nossa loja , desfruta do melhores
                produtos tecnologia disponivel no mercado.
            </p>
        </div>
        <div class="col-md-10 mx-auto col-lg-5">
            <form class="p-4 p-md-5 border rounded-3 bg-light" action="?loja=login_submit" method="POST">
                <div class="form-floating mb-3">
                    <input name="text_usuario" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput">Email</label>
                </div>
                <div class="form-floating mb-3">
                    <input name="text_senha" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Senha</label>
                </div>
                <div class="checkbox mb-3">
                    <label>
                        <input type="checkbox" value="remember-me"> Lembrar
                    </label>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Iniciar Sessão</button>
                <hr class="my-4">
                <small class="text-muted">Ao clicar em Cadastre-se, você concorda com os termos de uso.</small>
            </form>
            <?php if (isset($_SESSION['erro'])) { ?>
                <div class="alert alert-danger text-center">
                    <?php
                    echo $_SESSION['erro'];
                    unset($_SESSION['erro']);
                    ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>