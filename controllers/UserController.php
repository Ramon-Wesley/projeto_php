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
    public function sign($email, $password)
    {
        session_start();
        $user = new UserModel();
        $data = $user->SignIn($email, $password);
        if (!empty($data)) {
            $_SESSION['email'] = $data[0]['email'];
            header("Location: http://localhost/projeto_php");
        }
    }
}
