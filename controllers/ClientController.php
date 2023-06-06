<?php

class ClientController extends Controller
{


    public function index()
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header("Location: http://localhost/projeto_php/User");
        }
        $this->loadingTemplate("FormClient");
    }
}
