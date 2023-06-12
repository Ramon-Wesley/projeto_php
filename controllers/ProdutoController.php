<?php

class ProdutoController extends Controller
{


    public function index()
    {
        session_start();
        // if (!isset($_SESSION['email'])) {
        //   header("Location: http://localhost/projeto_php/User");
        //}
        $productModel = new ProductModel();
        $data = array();
        $data = $productModel->getAll();
        if (empty($data['data'])) {
            $data2 = array("nome", "categoria", "quantidade", 'valor_unitario');
            $this->loadingTemplate("GeralTable", array(), ["title" => "produto", $data2]);
        } else {
            $this->loadingTemplate("GeralTable", $data, ["title" => "produto"]);
        }
    }

    public function cadastrar()
    {
        $data = array();
        $categoryController = new CategoriaController();
        $categories = $categoryController->getAll();

        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];

            $supplierModel = new ProductModel();
            $data = $supplierModel->getById($id);

            if (!empty($data)) {
                $values =
                    array(
                        "Nome" => $data[0]['nome'],
                        'Quantidade' => $data[0]['quantidade'],
                        'Valor_unitario' => $data[0]['valor_unitario'],
                        'categories' => $categories
                    );
            }
        }



        $inputs = array(
            "Nome" => 'text',
            'Categoria' => 'select',
            'Quantidade' => 'number',
            'Valor_unitario' => 'number'
        );
        if (!empty($data)) {
            $data[0] += ['categories' => $categories];
            $this->loadingTemplate("GeralForm", $data[0], $inputs);
        } else {
            $this->loadingTemplate("GeralForm", array('categories' => $categories), $inputs);
        }
    }

    public function create(
        $values = array()
    ) {

        if (empty($values['Nome'])) {
            $errors['Nome'] = 'Preencha o Nome do produto.';
        }

        if (empty($values['Categoria'])) {
            $errors['Categoria'] = 'Preencha o campo Categoria';
        }
        if (empty($values['Quantidade'])) {
            $errors['Quantidade'] = 'Preencha o campo de Quantidade';
        }
        if (empty($values['Valor_unitario'])) {
            $errors['Valor_unitario'] = 'Preencha o campo de Valor_unitario';
        }


        if (!empty($errors)) {
            return $errors;
        }
        $productModel = new ProductModel();
        $id = $this->data['id'];
        if ($id > 0) {
            $errorMessage = $productModel->updateById($id, $_POST);
        } else {
            $errorMessage = $productModel->create($values);
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

            $product = new ProductModel();
            $errorMessage = $product->deleteById($id);
            if ($errorMessage == "Registro excluido com sucesso!") {
                $success = array('success' => "Registro excluido com sucesso!");
                return $success;
            } else {
                $error = array('error' =>  "Erro ao excluir o resgistro!");
                return $error;
            }
        }
    }
}
