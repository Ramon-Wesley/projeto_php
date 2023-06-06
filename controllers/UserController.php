<?php



class UserController extends Controller
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
        $this->loadingTemplate("FormSignUp");
    }
    public function signIn(string $email, string $password)
    {
        session_start();
        $data = array();
        $user = new UserModel();
        $data = $user->signIn($email, $password);

        if (!empty($data)) {
            $_SESSION['email'] = $data[0]['email'];

            header("Location: http://localhost/projeto_php");
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
