<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $this->signUp($_POST['email'], $_POST['senha']);
}
?>
<div class="container">
    <h2>Cadastro de Usuário</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="senha">Senha:</label>
            <input type="password" class="form-control" id="senha" name="senha" required>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
</div>/opt/lampp/htdocs/projeto_php/models