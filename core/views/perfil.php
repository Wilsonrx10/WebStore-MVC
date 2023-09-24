<head>
    <style>
        .principal {
            max-width: 1600px;
        }

        ul.lista {
            width: 100%;
            background-color: #ddd;
            padding: 20px;
        }

        ul li {
            display: inline-block;
            margin: 10px;
            list-style: none;
        }

        ul.lista li a {
            text-decoration: none;
        }
    </style>
</head>

<div class="container">
    <ul class="lista">
        <li><a href="#" onclick="alterar_menu('1')">Alterar os Dados do pessoais <i class="fas fa-user"></i></a></li>
        <li><a href="#" onclick="alterar_menu('2')">Alterar sua Senha <i class="fas fa-lock"></i></a></li>
        <li><a href="?loja=historico_encomendas">Histórico da Encomendas <i class="fas fa-clipboard-list"></i></a></li>
    </ul>
    <div class="principal">

        <div class="dados" id="dados">
            <h2>Atualizar Dados Pessoais</h2>
            <form method="POST" action="?loja=alterar_dados_perfil&acao=alterar_dados">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email</label>
                    <input type="text" name="email" class="form-control" value="<?= $dados_cliente->email ?>">
                </div>

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Nome</label>
                    <input type="text" name="nome" class="form-control" value="<?= $dados_cliente->nome_completo ?>">
                </div>

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Morada</label>
                    <input type="text" name="morada" class="form-control" value="<?= $dados_cliente->morada ?>">
                </div>

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Cidade</label>
                    <input type="text" name="cidade" class="form-control" value="<?= $dados_cliente->cidade ?>">
                </div>

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Telefone</label>
                    <input type="text" name="telefone" class="form-control" value="<?= $dados_cliente->telefone ?>">
                </div>

                <button type="submit" class="btn btn-primary">Atualizar os Dados</button>
            </form> <br>
            <?php if (isset($_SESSION['erro'])) { ?>
                <div class="alert alert-danger">
                    <?php
                    echo $_SESSION['erro'];
                    unset($_SESSION['erro']);
                    ?>
                </div>
            <?php } ?>

            <?php if (isset($_SESSION['sucesso'])) { ?>
                <div class="alert alert-success">
                    <?php
                    echo $_SESSION['sucesso'];
                    unset($_SESSION['sucesso']);
                    ?>
                </div>
            <?php } ?>
        </div>

        <div class="senha" id="senha">
            <h2>Alterar sua Senha</h2>
            <form method="POST" action="?loja=alterar_dados_perfil&acao=alterar_senha">
                <div class="mb-3">
                    <label for="senha_atual" class="form-label">Senha Atual</label>
                    <input type="password" class="form-control" id="senha_atual" name="senha_atual" placeholder="digita sua senha atual">
                </div>

                <div class="mb-3">
                    <label for="senha1" class="form-label">Nova Senha</label>
                    <input type="password" class="form-control" id="senha1" name="nova_senha" placeholder="digita sua senha atual">
                </div>

                <div class="mb-3">
                    <label for="senha2" class="form-label">Repete sua Senha</label>
                    <input type="password" class="form-control" id="senha2" name="nova_senha_repete" placeholder="repete sua senha">
                </div>

                <button type="submit" class="btn btn-primary">Atualizar Senha</button>
            </form>
        </div>
    </div>
</div>


<script>
    let dados = document.getElementById("dados");
    let senha = document.getElementById("senha");

    dados.style.display = "block";
    senha.style.display = "none";

    function alterar_menu(menu) {
        if (menu == 1) {
            dados.style.display = "block";
            senha.style.display = "none";
        } else if (menu == 2) {
            dados.style.display = "none";
            senha.style.display = "block";
        } 
    }
</script>