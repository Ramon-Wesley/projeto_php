function buscardado() {
  var cpf = document.getElementById('CPF') ? document.getElementById('CPF').value : null;
  if (cpf && cpf.length > 11) {
    axios
      .get(`/projeto_php/views/consultar_cliente.php?cpf=${cpf}`)
      .then(function(response) {
        var data = response.data;
        console.log(data + 'kjjkh');
        if (data.error) {
          console.log(data.error);
        } else {
          document.getElementById('Nome').value = data.nome;
          document.getElementById('Email').value = data.email;
          document.getElementById('telefone').value = data.telefone;
        }
      })
      .catch(function(error) {
        console.log(error);
      });
  }
}

function buscarEnderecoPorCEP() {
  const cep = document.getElementById('Cep') ? document.getElementById('Cep').value : null;
  if (cep && cep.length === 8) {
    // Faz a requisição à API dos correios
    axios
      .get(`https://viacep.com.br/ws/${cep}/json/`)
      .then(response => {
        const data = response.data;
        if (data) {
          // Preenche os campos de endereço com os dados retornados pela API
          document.getElementById('estado').value = data.uf;
          document.getElementById('cidade').value = data.localidade;
          document.getElementById('bairro').value = data.bairro;
          document.getElementById('rua').value = data.logradouro;
        }
      })
      .catch(error => {
        console.log("Sem resultado");
      });
  }
}

document.getElementById('Cep')?.addEventListener('input', _.debounce(buscarEnderecoPorCEP, 1000));
document.getElementById('CPF')?.addEventListener('input', _.debounce(buscardado, 1000));

$(document).ready(function() {
  // Máscara para CPF
  $('#CPF').mask('000.000.000-00', {reverse: true});
  $('#Cep').mask('00000-000');

  // Máscara para CEP
});
