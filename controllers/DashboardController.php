  <?php

  class DashboardController extends Controller
  {


    public function index()
    {
      session_start();
      if (!isset($_SESSION['email'])) {
        $_SESSION['email'];
        header("Location: http://localhost/projeto_php/login");
      }
      $buyModel = new BuyModel();
      $datab = $buyModel->saleSum();
      $saleModel = new SaleModel();
      $datas = $saleModel->saleSum();
      $data = array($datas, $datab);
      $this->loadingTemplate("Dashboard", $data, array(
        'janeiro', 'feveriro', 'marco ', 'abril', 'maio', 'junho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'

      ));
    }
  }
