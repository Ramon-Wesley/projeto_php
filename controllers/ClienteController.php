<?php

class ClienteController extends Controller
{
    public $errors = array();

    public function index()
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            $_SESSION['email'];
            header("Location: http://localhost/projeto_php/login");
        }
        $clientModel = new ClientModel();
        $data = $clientModel->getAll();
        if (empty($data['data'])) {
            $data2 = array('id', 'id_endereco', 'cpf', 'nome', 'email', 'telefone');
            $this->loadingTemplate("GeralTable", array(), ["title" => "cliente", $data2]);
        } else {
            $this->loadingTemplate("GeralTable", $data, ["title" => "cliente"]);
        }
    }
    public function getAll()
    {
        $client = new ClientModel();
        return $client->getAll();
    }

    public function cadastrar()
    {
        $data = array();

        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];

            $clientModel = new ClientModel();
            $data = $clientModel->getById($id);

            if (!empty($data)) {
                $values = array(
                    'CPF' => $data['cpf'],
                    'Nome' => $data['nome'],
                    'Email' => $data['email'],
                    'telefone' => $data['telefone'],
                    'Cep' => $data['cep'],
                    'estado' => $data['estado'],
                    'cidade' => $data['cidade'],
                    'bairro' => $data['bairro'],
                    'rua' => $data['rua'],
                    'numero' => $data['numero'],
                    'complemento' => $data['complemento']
                );
            }
        }

        $inputs = array(
            'CPF' => 'text',
            "Nome" => 'text',
            "Email" => 'email',
            "telefone" => 'tel',
            'Cep' => 'text',
            'estado' => 'text',
            'cidade' => 'text',
            'bairro' => 'text',
            'rua' => 'text',
            'numero' => 'text',
            'complemento' => 'text'
        );
        $this->loadingTemplate("GeralForm", $data, $inputs);
    }
    public function create($values = array())
    {
        // Validação dos campos


        // Verifica se o CPF é válido
        if (empty($values['CPF']) || !$this->validarCPF($values['CPF'])) {
            $errors['CPF'] = 'CPF inválido.';
        }

        // Verifica se o Nome é válido
        if (empty($values['Nome'])) {
            $errors['Nome'] = 'Nome é obrigatório.';
        }

        // Verifica se o Email é válido
        if (empty($values['Email']) || !filter_var($values['Email'], FILTER_VALIDATE_EMAIL)) {
            $errors['Email'] = 'Email inválido.';
        }

        // Verifica se o Telefone é válido
        if (empty($values['telefone'])) {
            $errors['telefone'] = 'Telefone é obrigatório.';
        }

        // Verifica se o CEP é válido
        if (empty($values['Cep']) || !$this->validarCEP($values['Cep'])) {
            $errors['Cep'] = 'CEP inválido.';
        }
        if (empty($values['estado'])) {
            $errors['estado'] = 'Preencha o campo Estado.';
        }

        if (empty($values['cidade'])) {
            $errors['cidade'] = 'Preencha o campo Cidade.';
        }

        if (empty($values['bairro'])) {
            $errors['bairro'] = 'Preencha o campo Bairro.';
        }

        if (empty($values['rua'])) {
            $errors['rua'] = 'Preencha o campo Rua.';
        }

        if (empty($values['numero'])) {
            $errors['numero'] = 'Preencha o campo Número.';
        }
        if (empty($values['complemento'])) {
            $errors['complemento'] = 'Preencha o campo de complemento.';
        }


        if (!empty($errors)) {
            return $errors;
        }

        $id = (int)($this->data['cliente_id'] ?? $this->data['cliente_id']);
        $id_endereco = (int)($this->data["endereco_id"] ?? $this->data["endereco_id"]);
        $supplierModel = new ClientModel();

        if ($id > 0) {
            $errorMessage = $supplierModel->updateById($id, $id_endereco, $values);
        } else {
            $errorMessage = $supplierModel->create($values);
        }


        if ($errorMessage == "Registro atualizado com sucesso!") {
            $success = array('success' => "Registro atualizado com sucesso!");
            return $success;
        } else {
            $error = array('error' =>  "Erro ao cadastrar o resgistro!");
            return $error;
        }
    }

    public function deleteById(int $id)
    {

        if ($id > 0) {
            $clientModel = new ClientModel();
            $errorMessage =  $clientModel->deleteById($id);
            if ($errorMessage == "Registro excluido com sucesso!") {
                $success = array('success' => "Registro excluido com sucesso!");
                return $success;
            } else {
                $error = array('error' =>  "Erro ao excluir o resgistro!");
                return $error;
            }
        }
    }

    public function validarCPF($cpf)
    {
        // Remove caracteres não numéricos
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // Verifica se o CPF possui 11 dígitos
        if (strlen($cpf) !== 11) {
            return false;
        }

        // Verifica se todos os dígitos são iguais
        if (preg_match('/^(\d)\1*$/', $cpf)) {
            return false;
        }

        // Calcula o primeiro dígito verificador
        $soma = 0;
        for ($i = 0; $i < 9; $i++) {
            $soma += (int) $cpf[$i] * (10 - $i);
        }
        $resto = $soma % 11;
        $digitoVerificador1 = ($resto < 2) ? 0 : 11 - $resto;

        // Calcula o segundo dígito verificador
        $soma = 0;
        for ($i = 0; $i < 10; $i++) {
            $soma += (int) $cpf[$i] * (11 - $i);
        }
        $resto = $soma % 11;
        $digitoVerificador2 = ($resto < 2) ? 0 : 11 - $resto;

        // Verifica se os dígitos verificadores estão corretos
        if ($cpf[9] != $digitoVerificador1 || $cpf[10] != $digitoVerificador2) {
            return false;
        }

        return true;
    }

    public function validarCEP($cep)
    {
        // Remove caracteres não numéricos
        $cep = preg_replace('/[^0-9]/', '', $cep);

        // Verifica se o CEP possui 8 dígitos
        if (strlen($cep) !== 8) {
            return false;
        }

        return true;
    }
}
