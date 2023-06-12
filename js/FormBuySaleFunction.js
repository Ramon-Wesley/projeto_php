
    var arrComplet = [];
    var tabelaProdutos = document.getElementById("tabelaProdutos");
    var autocomplete = document.getElementById("autocomplete")
    var valor = document.getElementById("data1")
    valor.addEventListener("input", _.debounce(async event => {
        var xhr = new XMLHttpRequest();

        // Define a função de callback para tratar a resposta do servidor
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    exibirResultado(response);
                } else {
                    console.error("Ocorreu um erro na requisição: " + xhr.status);
                }
            }
        };
        xhr.open("POST", "/projeto_php/views/consultar_cliente.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("Valor= " + event.target.value);
        //<?php echo $this->data2[0]; ?>=
    }, 500))

    function exibirResultado(result) {
        console.log(result);
    }

    function adicionarProduto() {
        var nomeProduto = document.getElementById("product").value;
        var quantidade = document.getElementById("amount").value;
        var valorTotal = document.getElementById("partial_value").value;

        if (nomeProduto === "" || quantidade === "" || valorTotal === "") {
            alert("Preencha todos os campos do produto.");
            return;
        }

        if (produtoJaExiste(nomeProduto)) {
            alert("O produto já está na tabela.");
            return;
        }

        var objeto = {
            product: nomeProduto,
            amount: quantidade,
            partial_value: valorTotal
        }

        ;
        arrComplet.push(objeto);
        salvarDadosNoCookie();
        adicionarLinhaTabela(nomeProduto, quantidade, valorTotal);
        limparCampos();
        calcularValorTotalProdutos();
    }

    function produtoJaExiste(nomeProduto) {
        for (var i = 0; i < tabelaProdutos.rows.length; i++) {
            var nomeProdutoTabela = tabelaProdutos.rows[i].cells[0].innerHTML;

            if (nomeProdutoTabela === nomeProduto) {
                return true;
            }
        }

        return false;
    }

    function editarProduto(botaoEditar) {
        var linha = botaoEditar.parentNode.parentNode;
        var nomeProduto = linha.cells[0].innerHTML;
        var quantidade = linha.cells[1].innerHTML;
        var valorTotal = linha.cells[2].innerHTML;

        document.getElementById("product").value = nomeProduto;
        document.getElementById("amount").value = quantidade;
        document.getElementById("partial_value").value = valorTotal;

        linha.remove();
        calcularValorTotalProdutos();
    }

    function excluirProduto(botaoExcluir) {
        var linha = botaoExcluir.parentNode.parentNode;
        var posicao = Array.from(linha.parentNode.children).indexOf(linha);
        linha.remove();
        arrComplet.splice(posicao, 1);
        salvarDadosNoCookie();
        calcularValorTotalProdutos();
    }

    function calcularValorTotalProdutos() {
        var valorTotalProdutos = 0;

        for (var i = 0; i < tabelaProdutos.rows.length; i++) {
            valorTotalProdutos += parseFloat(tabelaProdutos.rows[i].cells[2].innerHTML);
        }

        document.getElementById("total_value").value = valorTotalProdutos.toFixed(2);
    }

    function obterCookie(nome) {
        var nomeCookie = nome + "=";
        var cookies = document.cookie.split(';')

        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i];

            while (cookie.charAt(0) == " ") {
                cookie = cookie.substring(1);
            }

            if (cookie.indexOf(nomeCookie) == 0) {
                return cookie.substring(nomeCookie.length, cookie.length);
            }
        }

        return null;
    }

    function salvarDadosNoCookie() {
        var jsonString = JSON.stringify(arrComplet);
        document.cookie = "<?php echo $this->data2[2] ?>=" + jsonString + "; SameSite=None; Secure; expires=Fri, 31 Dec 2023 23:59:59 GMT; path=/";
    }

    function carregarDadosDoCookie() {
        var valorCookie = obterCookie("<?php echo $this->data2[2] ?>");
        var valor = 0;

        if (valorCookie) {
            valorCookie = JSON.parse(valorCookie);
            arrComplet = valorCookie;
            var length = valorCookie.length;
            var keyObject = Object.keys(valorCookie[0]);

            for (let i = 0; i < length; i++) {
                var produto = valorCookie[i];
                adicionarLinhaTabela(produto[keyObject[0]], produto[keyObject[1]], produto[keyObject[2]]);
                valor += parseFloat(produto[keyObject[2]]);
            }

            document.getElementById("total_value").value = valor.toFixed(2);
        }
    }

    function adicionarLinhaTabela(nomeProduto, quantidade, valorTotal) {
        var novaLinha = tabelaProdutos.insertRow();

        var colunaNomeProduto = novaLinha.insertCell(0);
        var colunaQuantidade = novaLinha.insertCell(1);
        var colunaValorTotal = novaLinha.insertCell(2);
        var colunaAcoes = novaLinha.insertCell(3);

        colunaNomeProduto.innerHTML = nomeProduto;
        colunaQuantidade.innerHTML = quantidade;
        colunaValorTotal.innerHTML = valorTotal;
        colunaAcoes.innerHTML = '<button type="button" class="btn btn - sm btn - primary " onclick="editarProduto(this)">Editar</button> <button type="button " class="btn btn - sm btn - danger " onclick="excluirProduto(this)">Excluir</button>';
    }

    function limparCampos() {
        document.getElementById("product").value = "";
        document.getElementById("amount").value = "";
        document.getElementById("partial_value").value = "";
    }

    carregarDadosDoCookie();










