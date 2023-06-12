<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $_POST = array_filter($_POST, function ($key) {
        return $key !== 'submit';
    }, ARRAY_FILTER_USE_KEY);
    $res = $this->signIn($_POST['email'], $_POST['password']);
}
?>

<div class="container">
    <div class="container d-flex justify-content-center flex-column vh-100 align-items-center">
        <div id="error-message" class="alert alert-danger" style="display: none;"></div>
        <form class="d-flex gap-2 row p-4 rounded flex-column align-items-center border border-dark-subtle justify-content-center" method="POST" action="">
            <div class="col-sm-12 text-light d-flex justify-content-center">
                <h3>Login</h3>
            </div>
            <div class="col-sm-12">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email">
            </div>
            <div class="col-sm-12">
                <input type="password" class="form-control" id="password" name="password" placeholder="Senha">
            </div>
            <div class="col-sm-12 d-flex justify-content-center">
                <a href="projeto_php">
                    <button type="submit" class="btn btn-success" name="submit">Enviar</button>
                </a>
            </div>

        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var errorMessageElement = document.getElementById('error-message');
        var errorMessage = '<?php if (!empty($res)) {
                                echo $res;
                            } ?>';

        if (errorMessage !== '') {
            errorMessageElement.innerText = errorMessage;
            errorMessageElement.style.display = 'block';
            errorMessageElement.classList.add('show');

            setTimeout(function() {
                errorMessageElement.classList.remove('show');
                errorMessageElement.style.display = 'none';
            }, 2000);
        }
    });
</script>