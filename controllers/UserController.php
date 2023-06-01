<?php



class UserController extends Controller
{
    public function index()
    {
        $this->loadingTemplate("Login");
    }
    public function sign($email, $password)
    {
        $user = new UserModel();
        $data = $user->SignIn($email, $password);
        if (!empty($data)) {
            $this->loadingTemplate("Home");
        }
    }
}
