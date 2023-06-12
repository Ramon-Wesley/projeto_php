<?php

class CompraController extends Controller
{
    public function index()
    {
        session_start();
        // if (!isset($_SESSION['email'])) {
        //   header("Location: http://localhost/projeto_php/User");
        //}
        $buyModel = new BuyModel();
        $data = $buyModel->getAll();
        if (empty($data['data'])) {
            $data2 = array('id', 'id_fornecedor', 'valor_total', 'data_compra');
            $this->loadingTemplate("GeralTable", array(), ["title" => "compra", $data2]);
        } else {
            $this->loadingTemplate("GeralTable", $data, ["title" => "compra"]);
        }
    }

    public function cadastrar()
    {
        $labels = array('CNPJ', 'Fornecedor', 'Compra');
        $this->loadingTemplate("FormBuy-Sale", array(), $labels);
    }

    public function create(

        $valuesBuy = array(),
        $valuesBuyItems
    ) {
        $test = json_decode($valuesBuyItems);

        $buyModel = new BuyModel();
        $errorMessage = $buyModel->buy($valuesBuy, $test);
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
            $buyModel = new BuyModel();
            $errorMessage =  $buyModel->deleteById($id);
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
