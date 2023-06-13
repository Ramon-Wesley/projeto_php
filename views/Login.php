<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $_POST = array_filter($_POST, function ($key) {
        return $key !== 'submit';
    }, ARRAY_FILTER_USE_KEY);
    $res = $this->signIn($_POST['email'], $_POST['password']);
}
?>

<style>
    body {
        background-color: #f8f9fa;
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .login-form {
        max-width: 400px;
        width: 100%;
        padding: 20px;
        border: 1px solid #dee2e6;
        background-color: #fff;
        border-radius: 4px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        animation: slideDown 0.5s ease-in-out;
        animation-fill-mode: forwards;
    }

    @keyframes slideDown {
        0% {
            opacity: 0;
            transform: translateY(-50%);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .login-form h3 {
        margin-top: 0;
        margin-bottom: 20px;
        text-align: center;
    }

    .login-form input[type="email"],
    .login-form input[type="password"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        background-color: #f1f3f5;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .login-form input[type="email"]:focus,
    .login-form input[type="password"]:focus {
        border-color: #4d94ff;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(77, 148, 255, 0.25);
    }

    .login-form .btn-success {
        width: 100%;
        padding: 10px;
        font-size: 16px;
    }

    .login-form .alert-danger {
        margin-bottom: 20px;
        display: none;
    }
</style>

<div class="container">
    <form class="login-form" method="POST" action="">
        <div class="alert alert-danger" id="error-message"></div>
        <h3>Login</h3>
        <div class="mb-3">
            <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="Senha" required>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-success" name="submit">Enviar</button>
        </div>
    </form>
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
</body>

</html>