<?php


class Controller

{

    public $data;

    public function __construct()
    {
        $this->data = array();
    }

    public function  loadingTemplate($nameView, $dataModel = array())
    {
        $this->data = $dataModel;
        require "views/Template.php";
    }

    public function loadindViewTemplate($nameView, $dataModel = array())
    {
        extract($dataModel);
        require "views/" . $nameView . ".php";
    }
}
