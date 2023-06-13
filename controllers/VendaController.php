<?php

class VendaController extends Controller
{


    public function index()
    {
        session_start();
        // if (!isset($_SESSION['email'])) {
        //   header("Location: http://localhost/projeto_php/User");
        //}
        $saleModel = new SaleModel();
        $data = array();
        $data = $saleModel->getAll();

        if (empty($data['data'])) {
            $data2 = array("id", "cpf", "nome", "email", "telefone", "valor_total", "data_compra");
            $this->loadingTemplate("GeralTable", array(), ["title" => "venda", $data2]);
        } else {
            $this->loadingTemplate("GeralTable", $data, ["title" => "venda"]);
        }
    }

    public function cadastrar()
    {
        $data = array();
        $categoryController = new CategoriaController();
        $categories = $categoryController->getAll();

        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];

            $sale = new SaleModel();
            $data = $sale->getItemsSale($id);

            if (!empty($data)) {
                $values =
                    array(
                        "CPF" => $data[0]['nome'],
                        'Nome' => $data[0]['quantidade'],
                        'venda' => $data[0]['valor_unitario'],
                        'quantidade' => $sale
                    );
            }
        }



        $inputs = array(
            "Nome" => 'text',
            'Categoria' => 'select',
            'Quantidade' => 'number',
            'Valor_unitario' => 'number'
        );
        //     $data[0] += ['categories' => $categories];
        //   $this->loadingTemplate("GeralForm", $data[0], $inputs);
        $labels = array('CPF', 'Cliente', 'Venda');
        $data['title'] = 'venda';
        $this->loadingTemplate("FormBuy-Sale", $data, $labels);
    }
    public function create(
        $valuesBuy = array(),
        $valuesBuyItems
    ) {

        $res = json_decode($valuesBuyItems);
        $buyModel = new SaleModel();
        $errorMessage = $buyModel->sale($valuesBuy, $res);
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
            $sale = new SaleModel();
            $errorMessage = $sale->deleteById($id);
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
