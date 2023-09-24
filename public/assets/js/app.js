//===================================================
function adicionar_carrinho(id_produto) {
    // Executar o AXIOS 
    axios.defaults.widthCredentials = true;
    axios.get('?loja=adicionar_carrinho&id_produto=' + id_produto)
        .then(function (response) {
            let total_produtos = response.data;
            document.getElementById("carrinho").innerText = total_produtos;
        })
        .catch(function (error) {
            console.log(error);
        });
}

//===================================================
function limpar_carrinho() {
    // Executar o AXIOS 
    axios.defaults.widthCredentials = true;
    axios.get('?loja=apagar_carrinho')
        .then(function (response) {
            document.getElementById("carrinho").innerText = 0;
        })
        .catch(function (error) {
            console.log(error);
        });
}
//===================================================
function usar_morada_altenativa() {
    let e = document.getElementById("check_morada_altenativa");
    let formulario = document.querySelector(".nova-morada");
    // verificar se o elemento está checked
    if (e.checked == true) {
        formulario.style.display = "block";
    } else {
        formulario.style.display = "none";
    }
}
//===================================================
function morada_altenativa() {
    axios({
        method: "POST",
        url: "?loja=morada_altenativa",
        data: {
            text_morada: document.getElementById("text_morada_altenativa").value,
            text_cidade: document.getElementById("text_cidade_altenativa").value,
            text_email: document.getElementById("text_email_altenativa").value,
            text_telefone: document.getElementById("text_telefone_altenativa").value
        }
    }).then(function (response) {
    console.log(response);
    });
}