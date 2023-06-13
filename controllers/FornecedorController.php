<?php

class FornecedorController extends Controller
{
    public function index()
    {
        session_start();

        /*
        if (!isset($_SESSION['email'])) {
            header("Location: http://localhost/projeto_php/User");
        }
        */

        $supplierModel = new SupplierModel();

        $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = 10; // Defina o número desejado de registros por página

        $data = $supplierModel->getAll("", "ASC", $currentPage, $limit);

        if (empty($data['data'])) {
            $data2 = array('id', 'id_endereco', 'cnpj', 'nome', 'email', 'telefone');
            $this->loadingTemplate("GeralTable", array(), ["title" => "fornecedor", $data2]);
        } else {
            $this->loadingTemplate("GeralTable", $data, ["title" => "fornecedor"]);
        }
    }


    public function cadastrar()
    {
        $data = array();

        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];

            $supplierModel = new SupplierModel();
            $data = $supplierModel->getById($id);

            if (!empty($data)) {
                $values = array(
                    'CNPJ' => $data['cnpj'],
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
            'CNPJ' => 'text',
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
        $data['title'] = 'fornecedor';
        $this->loadingTemplate("GeralForm", $data, $inputs);
    }

    public function create($values = array())
    {
        session_start();

        $errors = array();
        if (empty($values['CNPJ']) || !$this->validarCNPJ($values['CNPJ'])) {
            $errors['CNPJ'] = 'CNPJ invalido.';
        }
        if (empty($values['Nome'])) {
            $errors['Nome'] = 'Nome é obrigatório.';
        }

        if (empty($values['Email']) || !filter_var($values['Email'], FILTER_VALIDATE_EMAIL)) {
            $errors['Email'] = 'Email inválido.';
        }

        if (empty($values['telefone'])) {
            $errors['telefone'] = 'Telefone é obrigatório.';
        }

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

        $id = (int)($this->data['fornecedor_id'] ?? $this->data['fornecedor_id']);
        $id_endereco = (int)($this->data["endereco_id"] ?? $this->data["endereco_id"]);
        $supplierModel = new SupplierModel();

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

            $supplierModel = new SupplierModel();
            $errorMessage  = $supplierModel->deleteById($id);
            if ($errorMessage == "Registro excluido com sucesso!") {
                $success = array('success' => "Registro excluido com sucesso!");
                return $success;
            } else {
                $error = array('error' =>  "Erro ao excluir o resgistro!");
                return $error;
            }
        }
    }

    public function getByCnpj($cnpj)
    {
        $supplierModel = new SupplierModel();
        $supplierModel->getByCnpj($cnpj);
    }

    public function validarCNPJ($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        if (strlen($cnpj) != 14) {
            return false;
        }

        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        $soma1 = 0;
        $soma2 = 0;
        $multiplicador = 5;

        for ($i = 0; $i < 12; $i++) {
            $soma1 += $cnpj[$i] * $multiplicador;
            $multiplicador--;
            if ($multiplicador < 2) {
                $multiplicador = 9;
            }
        }

        $resto = $soma1 % 11;
        $digitoVerificador1 = ($resto < 2) ? 0 : 11 - $resto;

        $multiplicador = 6;
        for ($i = 0; $i < 13; $i++) {
            $soma2 += $cnpj[$i] * $multiplicador;
            $multiplicador--;
            if ($multiplicador < 2) {
                $multiplicador = 9;
            }
        }

        $resto = $soma2 % 11;
        $digitoVerificador2 = ($resto < 2) ? 0 : 11 - $resto;

        if ($cnpj[12] == $digitoVerificador1 && $cnpj[13] == $digitoVerificador2) {
            return true;
        } else {
            return false;
        }
    }

    public function validarCEP($cep)
    {
        $cep = preg_replace('/[^0-9]/', '', $cep);

        if (strlen($cep) !== 8) {
            return false;
        }

        return true;
    }
}
