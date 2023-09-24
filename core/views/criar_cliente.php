<head>
    <style>
     .formulario {
        background-color: white;
        -webkit-box-shadow: 5px 5px 15px 5px #ddd; 
        box-shadow: 5px 5px 15px 5px #ddd;
        padding: 30px;
     }
    </style>
</head>

<div class="container-fluid">
    <div class="row my-5">
        <div class="col-sm-6 offset-sm-3 formulario">
            <h3 class="text-center">Registro de um novo cliente</h3>

            <?php if (isset($_SESSION['erro'])) { ?>
                 <div class="alert alert-danger text-center p-2">
                     <?= $_SESSION['erro'] ?>
                     <?php unset($_SESSION['erro'])?>
                 </div>
                 
            <?php } ?>
            
            <form action="?loja=criar_cliente" method="post">
            <!--Email--->
            <div class="form-group">
                <label for="text_email">Email:</label>
                <input class="form-control" type="email" name="text_email" placeholder="email" required>
            </div>

            <!--senha1--->
            <div class="form-group">
                <label for="text_senha_1">Senha</label>
                <input class="form-control" type="password" name="text_senha_1" placeholder="senha" required>
            </div>

            <!--senha2--->
            <div class="form-group">
                <label for="text_senha_2">Repete a senha</label>
                <input class="form-control" type="password" name="text_senha_2" placeholder="repetir a senha" required>
            </div>


            <!--Nome completo--->
            <div class="form-group">
                <label for="text_nome_completo">Nome completo</label>
                <input class="form-control" type="text" name="text_nome_completo" placeholder="Nome completo" required>
            </div>


            <!-------Morada----->
            <div class="form-group">
                <label for="text_morada">Morada</label>
                <input class="form-control" type="text" name="text_morada" placeholder="Sua morada" required>
            </div>


            <!----Cidade----->
            <div class="form-group">
                <label for="text_cidade">Cidade</label>
                <input class="form-control" type="text" name="text_cidade" placeholder="Cidade" required>
            </div>


             <!----Telefone----->
             <div class="form-group">
                <label for="text_telefone">Cidade</label>
                <input class="form-control" type="text" name="text_telefone" placeholder="Telefone" required>
            </div> <br>


             <!----Submit----->
             <div class="form-group">
               <input class="btn btn-primary" type="submit" value="Registrar">
            </div> <br>

            </form>
        </div>
    </div>
</div>