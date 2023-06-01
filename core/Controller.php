<?php


class Controller

{

    public $data;
    public $data2;

    public function __construct()
    {
        $this->data = array();
    }

    public function  loadingTemplate($nameView, $dataModel = array(), $data2 = array())
    {
        $this->data = $dataModel;
        $this->data2 = $data2;
        require "views/Template.php";
    }

    public function loadindViewTemplate($nameView, $dataModel = array())
    {
        extract($dataModel);
        require "views/" . $nameView . ".php";
    }
}
