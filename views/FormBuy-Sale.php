<?php
session_start();
if (!empty($this->data2)) {
    $keys = array_keys($this->data2);
    $lengthKey = count($keys);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $value = $_COOKIE[$this->data2[2]];
    $res = array();
    $postData = array_map('sanitizeString', $_POST);
    unset($postData['submit']);
    $res = $this->create($postData, $value);
}

function sanitizeString($value)
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>

<script src="https://cdn.jsdelivr.net/npm/underscore@1.13.6/underscore-umd-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js" integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<style>
    li:hover {
        background-color: beige;
        cursor: pointer;
    }

    #autocomplete ul li a {
        text-decoration: none;
        color: blue;
    }

    #autocomplete ul {
        padding: 2px;
        list-style: none;
    }

    #autocomplete li {
        border-bottom: 1px solid black;
    }

    li {
        list-style: none;
    }

    a {
        text-decoration: none;
    }
</style>
<div class="container">
    <div id="error-message" class="alert alert-danger" style="display: none;"></div>
    <div id="success-message" class="alert alert-success" style="display: none;"></div>
    <h2>Formulário de <?php echo $this->data2[2] ?></h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="cnpj"><?php echo $this->data2[0]; ?></label>
            <input type="text" class="form-control" id="cpf" name="<?php echo $this->data2[0]; ?>" placeholder="Digite o <?php echo $this->data2[0]; ?> do <?php echo $this->data2[1]; ?>" required autocomplete="off">
            <div id="autocomplete" class="d-none bg-white border border-light-subtle position-absolute overflow-y-scroll w-50" style="height: 150px;"></div>
        </div>
        <div class="form-group">
            <label for="nome">Nome do <?php echo $this->data2[1]; ?>:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Digite o nome do <?php echo $this->data2[1]; ?>" required>
        </div>
        <div class="form-group">
            <label for="produto">Nome do Produto:</label>
            <input type="text" class="form-control" id="product" name="product" placeholder="Digite o nome do produto">
            <div id="productAutocomplete" class="d-none bg-white border border-light-subtle position-absolute overflow-y-scroll w-50" style="height: 150px;"></div>
        </div>
        <div class="form-group">
            <label for="quantidade">Quantidade:</label>
            <input type="number" class="form-control" id="amount" min=1 name="amount" placeholder="Digite a quantidade">
        </div>
        <div class="form-group">
            <label for="valor">Valor:</label>
            <input type="text" class="form-control" id="partial_value" <?php echo $this->data2[2] == 'Venda' ?? 'disabled'; ?> name="partial_value" placeholder="Digite o valor total">
        </div>
        <button type="button" class="btn btn-primary" onclick="adicionarProduto()">Adicionar Produto</button>
        <h3>Lista de produtos:</h3>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome do Produto</th>
                        <th>Quantidade</th>
                        <th>Valor</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="tabelaProdutos"></tbody>
            </table>
        </div>
        <div class="form-group">
            <label for="valorTotalProdutos">Valor Total dos Produtos:</label>
            <input type="text" class="form-control" id="total_value" name="total_value" readonly>
        </div>
        <input type="submit" class="btn btn-success" name="submit" value="Confirmar <?php echo $this->data2[2] ?>" />
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var errorMessageElement = document.getElementById('<?php echo $res['error'] ? 'error' : 'success' ?>-message');
        var errorMessage = '<?php if (!empty($res)) {
                                echo $res['error'] ? $res['error'] : $res['success'];
                            } ?>';

        if (errorMessage !== '') {
            errorMessageElement.innerText = errorMessage;
            errorMessageElement.style.display = 'block';
            errorMessageElement.classList.add('show');

            setTimeout(function() {
                errorMessageElement.classList.remove('show');
                errorMessageElement.style.display = 'none';
            }, 2000);
        }
    })
    $(document).ready(function() {
        var amountInput = $('#amount');
        var partialValueInput = $('#partial_value');
        var previousAmount = parseFloat(amountInput.val());

        $('#btnAdicionar').on('click', function() {
            previousAmount = 1;
            amountInput.val(1);
        });

        amountInput.on('input', (function() {
            var currentAmount = parseFloat(amountInput.val());
            var partialValue = parseFloat(partialValueInput.val());
            if (currentAmount > 1 && isNaN(partialValue)) {
                amountInput.val(1);
                previousAmount = 1;
            }
            if (!isNaN(currentAmount) && !isNaN(partialValue)) {
                if (currentAmount > previousAmount) {
                    var totalValue = partialValue * (currentAmount / previousAmount);
                    partialValueInput.val(totalValue.toFixed(2));
                } else if (currentAmount < previousAmount) {
                    var totalValue = partialValue / (previousAmount / currentAmount);
                    partialValueInput.val(totalValue.toFixed(2));
                }
                previousAmount = currentAmount;
            }
        }));
        var productInput = $('#product');
        var productAutocomplete = $('#productAutocomplete');
        var valor_unitario = $('#partial_value')
        var amount = $('#amount');

        productInput.on('input', _.debounce(async function() {
            var searchTerm = productInput.val();

            try {
                var response = await axios.get(`/projeto_php/views/consultar_produtos.php?valor=${searchTerm}`, );

                if (response.status === 200) {
                    var suggestions = response.data;
                    exibirResultadoproduct(suggestions);
                } else {
                    console.error("Ocorreu um erro na requisição.");
                }
            } catch (error) {
                console.error("Ocorreu um erro na requisição: " + error);
            }
        }, 500));

        function exibirResultadoproduct(suggestions) {
            productAutocomplete.html(""); // Limpar as sugestões anteriores
            console.log(suggestions);
            if (suggestions.length > 0) {
                suggestions.forEach(function(suggestion) {
                    var li = $("<li></li>");
                    var a = $("<a></a>").attr("href", "#").text(suggestion.nome);
                    a.on("click", function() {
                        productInput.val(suggestion.nome);
                        valor_unitario.val(suggestion.valor_unitario)
                        amount.attr('max', suggestion.quantidade);
                        amount.val(1);
                        previousAmount = 1;
                        productAutocomplete.html(""); // Limpar as sugestões ao selecionar uma
                        productAutocomplete.addClass("d-none");
                    });
                    li.append(a);
                    productAutocomplete.append(li);
                });

                productAutocomplete.removeClass("d-none"); // Exibir as sugestões
            } else {
                productAutocomplete.addClass("d-none"); // Ocultar as sugestões se não houver nenhuma
            }
        }
    });

    var valor = document.getElementById('<?php $this->data2[0]  ?>')
    $(document).ready(function() {
        var cpfInput = $('#cpf');
        var nameInput = $('#name')
        var autocomplete = $('#autocomplete');

        cpfInput.on('input', _.debounce(async function() {
            var searchTerm = cpfInput.val();

            try {
                var response = await axios.get(`/projeto_php/views/consultar_<?php echo $this->data2[1]; ?>.php?valor=${searchTerm}`);

                if (response.status === 200) {
                    var suggestions = response.data;
                    exibirResultadocpf(suggestions);
                } else {
                    console.error("Ocorreu um erro na requisição.");
                }
            } catch (error) {
                console.error("Ocorreu um erro na requisição: " + error);
            }
        }, 500));

        function exibirResultadocpf(suggestions) {
            autocomplete.html(""); // Limpar as sugestões anteriores
            console.log(suggestions);
            if (suggestions.length > 0) {
                suggestions.forEach(function(suggestion) {
                    var li = $("<li></li>");
                    var a = $("<a></a>").attr("href", "#").text(suggestion["<?php echo strtolower($this->data2[0]); ?>"]);
                    a.on("click", function() {
                        cpfInput.val(suggestion["<?php echo strtolower($this->data2[0]); ?>"]);
                        nameInput.val(suggestion['nome']);
                        previousAmount = 1
                        nameInput.focus();
                        autocomplete.html(""); // Limpar as sugestões ao selecionar uma
                        autocomplete.addClass("d-none");

                    });
                    li.append(a);
                    autocomplete.append(li);
                });

                autocomplete.removeClass("d-none"); // Exibir as sugestões
            } else {
                autocomplete.addClass("d-none"); // Ocultar as sugestões se não houver nenhuma
            }
        }

    });

    $(document).ready(function() {

    });
    //Neste código, adicionamos um evento de input ao campo de CPF(cpfInput) para acionar a requisição AJAX e obter as sugestões de autocomplete.Em seguida, usamos a função exibirResultado() para mostrar as sugestões retornadas pelo servidor.Quando o usuário seleciona uma sugestão, o valor é preenchido no campo de CPF(cpfInput) e o foco é movido para o campo de nome(nameInput).Além disso, também atualizamos o CSS para mostrar e ocultar corretamente a lista de sugestões de autocomplete.

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
        var indice = linha.querySelector("button[data-index]").getAttribute("data-index");
        var nomeProduto = linha.cells[0].innerHTML;
        var quantidade = linha.cells[1].innerHTML;
        var valorTotal = linha.cells[2].innerHTML;

        document.getElementById("product").value = nomeProduto;
        document.getElementById("amount").value = quantidade;
        document.getElementById("partial_value").value = valorTotal;

        arrComplet.splice(indice, 1);
        salvarDadosNoCookie();
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
        var cookies = document.cookie.split(';');
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
        colunaAcoes.innerHTML = '<button type="button" class="btn btn-sm btn-primary " onclick="editarProduto(this)" data-index="0">Editar</button> <button type="button " class="btn btn-sm btn-danger " onclick="excluirProduto(this)">Excluir</button>';
    }

    function limparCampos() {
        document.getElementById("product").value = "";
        document.getElementById("amount").value = "";
        document.getElementById("partial_value").value = "";
    }
    carregarDadosDoCookie();
</script>