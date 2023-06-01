  <?php

  class HomeController extends Controller
  {


    public function index($email, $password)
    {
      $this->loadingTemplate("Home");
    }
  }
