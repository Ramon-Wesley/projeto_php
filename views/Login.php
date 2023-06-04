<?php
if ($_POST['email']) {
    $this->sign($_POST['email'], $_POST['password']);
}
?>
<div class="container d-flex justify-content-center vh-100 align-items-center">
    <form class="d-flex gap-2 row p-4  rounded flex-column align-items-center border border-dark-subtle justify-content-center " method="post" action="">
        <div class=" col-sm-12 text-light d-flex justify-content-center">
            <h3>Login </h3>
        </div>
        <div class=" col-sm-12">
            <input type="email" class="form-control" name="email" id="email" placeholder="email">

        </div>

        <div class=" col-sm-12">
            <input type="password" class="form-control" id="password" name="password" placeholder="senha">

        </div>

        <div class="col-sm-12 d-flex  justify-content-center">
            <button type="submit" class="btn btn-success" name="submit" type="password">Enviar</button>
        </div>
    </form>
</div>