  <?php

  class DashboardController extends Controller
  {


    public function index()
    {
      session_start();
      if (!isset($_SESSION['email'])) {
        header("Location: http://localhost/projeto_php/User");
      }
      $this->loadingTemplate("Dashboard", array(), array(
        'janeiro', 'feveriro', 'marco ', 'abril', 'maio', 'junho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'

      ));
    }
  }
