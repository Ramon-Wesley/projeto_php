<?php
class Validation
{

    public function validateSupplier($values = array())
    {

        // Verifica se o CPF é válido
        if (empty($values['CNPJ']) || !$this->validarCNPJ($values['CNPJ'])) {
            $errors['CNPJ'] = 'CNPJ inválido.';
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
        return $errors;
    }

    public function validateClient($values)
    {

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
        return $errors;
    }
    public function validarCNPJ($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj); // Remove caracteres não numéricos
        if (strlen($cnpj) != 14) {
            return false;
        }

        // Verifica se todos os dígitos são iguais, o que configura um CNPJ inválido
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        $soma1 = 0;
        $soma2 = 0;
        $multiplicador = 5;

        // Calcula o primeiro dígito verificador
        for ($i = 0; $i < 12; $i++) {
            $soma1 += $cnpj[$i] * $multiplicador;
            $multiplicador--;
            if ($multiplicador < 2) {
                $multiplicador = 9;
            }
        }

        $resto = $soma1 % 11;
        $digitoVerificador1 = ($resto < 2) ? 0 : 11 - $resto;

        // Calcula o segundo dígito verificador
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

        // Verifica se os dígitos verificadores calculados são iguais aos informados no CNPJ
        if ($cnpj[12] == $digitoVerificador1 && $cnpj[13] == $digitoVerificador2) {
            return true;
        } else {
            return false;
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
