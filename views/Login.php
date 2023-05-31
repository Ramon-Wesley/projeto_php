<div class="container d-flex justify-content-center vh-100 align-items-center">
    <form class="d-flex gap-2 row p-4  rounded flex-column align-items-center border border-dark-subtle justify-content-center " method="post" action="">
        <div class="col-sm-12 text-light d-flex justify-content-center">
            <h3>Login </h3>
        </div>
        <div class="col-sm-12">
            <input type="email" class="form-control " id=" email" placeholder="email">
            <button id="toggle-password" type="button" class="d-none" aria-label="Show password as plain text. Warning: this will display your password on the screen.">
                <i class="bi bi-eye"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                    </svg></i>
            </button>
        </div>
        <div class="input-group">
            <input type="password" id="password" class="form-control rounded-right" required>
            <button id="toggle-password" type="button" class="d-none" aria-label="Show password as plain text. Warning: this will display your password on the screen.">
            </button>
        </div>

        <div class=" col-sm-12">
            <input type="password" class="form-control" id="password" placeholder="senha">

        </div>

        <div class="col-sm-12 d-flex  justify-content-center">
            <button type="submit" class="btn btn-success" type="password">Enviar</button>
        </div>
    </form>
</div>