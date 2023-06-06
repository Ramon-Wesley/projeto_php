<?php

class SaleController extends Controller
{


    public function index()
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header("Location: http://localhost/projeto_php/User");
        }
        $dates = array();
        $sale = new SaleModel();
        //$dates = $sale->sale_items();
        $this->loadingTemplate("FormSale", $dates, $dates);
    }
}
