<?php

class CategoriaController extends Controller
{


    public function index()
    {
        session_start();
        // if (!isset($_SESSION['email'])) {
        //   header("Location: http://localhost/projeto_php/User");
        //}
        $categoryModel = new CategoryModel();
        $data = $categoryModel->getAll();
        if (empty($data['data'])) {
            $data2 = array("id", "nome");
            $this->loadingTemplate("GeralTable", array(), ["title" => "categoria", $data2]);
        } else {
            $this->loadingTemplate("GeralTable", $data, ["title" => "categoria"]);
        }
    }

    public function cadastrar(
        $values = array()
    ) {
        // print_r($values);
        //$clientModel = new ClientModel();
        //$clientModel->create($values);
    }
    public function deleteById(int $id)
    {

        if ($id > 0) {
            $categoryModel = new CategoryModel();
            $categoryModel->deleteById($id);
        }
    }
    public function getAll()
    {
        $category = new CategoryModel();
        return $category->getAll();
    }
}
