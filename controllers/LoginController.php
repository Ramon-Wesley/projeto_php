<?php
session_start();



class LoginController extends Controller
{
    public function index()
    {
        session_start();
        session_unset();
        session_destroy();
        $this->loadingTemplate("Login");
    }
    public function cadastrar()
    {
        session_start();
    }
    public function signIn(string $email, string $password)
    {
        $user = new UserModel();
        $data = $user->signIn($email, $password);

        if ($data == "usuario ou senha incorretos!") {
            throw new \Exception("Usuário ou senha incorretos!");
        } else {
            session_start();
            $_SESSION['email'] = $data[0]['email'];
            header('Location: http://localhost/projeto_php/');
            $dashboard = new DashboardController();
            $dashboard->index();
            exit();
        }
    }

    public function signUp(string $email, string $password)
    {
        session_start();
        $data = array();
        $user = new UserModel();
        $data = $user->SignUp($email, $password);
    }
}
