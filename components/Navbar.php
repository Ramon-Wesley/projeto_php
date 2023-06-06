<nav class="navbar bg-body-tertiary fixed-top" style="display:<?php
                                                                if (isset($_SESSION['email'])) {
                                                                    echo "flex";
                                                                } else {
                                                                    echo "none";
                                                                } ?>;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Offcanvas navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Offcanvas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                                <path d="M14 15v-4h-1V4a2 2 0 0 0-2-2h-2a1 1 0 0 0-1 1v1H8V1L4 4H1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1zM4 4l3-3 3 3H4zm2 9v2h4v-2H6z" />
                            </svg> Página Inicial
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building" viewBox="0 0 16 16">
                                <path d="M7.5 1v3h1V1h-1zm0 4h1v1h-1V5zm3-3v4h1V2h-1zM4 5h1v1H4V5zm0-1V1H3v3h1zm2 5H5v1h1V9zm-3 0H1v1h2V9zm9 2H7V9h2v1zm-3 0H4V9h2v1zm-3 0H1V9h2v1zm9 2H7v-1h2v1zm-3 0H4v-1h2v1zm-3 0H1v-1h2v1zm5 1h1v-3h-1v3zm0-4h1V5h-1v1zm-3-3V2h-1v1h1zm3 3h1V5h-1v1zm0-1v-1h-1v1h1zm-9 2h1V5H1v1zm0-1V2H0v4h1zm2-4v3h1V1H3zm0 4h1v1H3V5zm2-3H4v1h1V2zm9 10v-3h-1v3h1zm-3 0h-1v1h1v-1zm-3 0H7v1h1v-1zm-3 0H4v1h1v-1zm5-4v-1H9v1h1zm-2 0H7v1h1v-1zm-2 0H4v1h1v-1zm-3 0H1v1h1v-1zm10 2h1v-1h-1v1zm-3 0h-1v1h1v-1zm-3 0H4v1h1v-1zm-3 0H1v1h1v-1z" />
                            </svg> Fornecedores
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                                <path d="M2 4a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm8 0a2 2 0 1 1 4 0 2 2 0 0 1-4 0zM4.5 6.5a3.5 3.5 0 0 1 7 0V8h-7v-.5zM12 10a4 4 0 0 0-3-3.87V6a3 3 0 0 0-6 0v.13A4 4 0 0 0 1 10v3h11v-3zm-6 1a2 2 0 1 1-4 0 2 2 0 0 1 4 0z" />
                            </svg> Clientes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash-stack" viewBox="0 0 16 16">
                                <path d="M1 2.01a1 1 0 0 1 1 0V6a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2.01a1 1 0 1 1 0 0zM2 8a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v1.062c-.58.342-1 .985-1 1.738v1.402a2.494 2.494 0 0 1-1.463 2.276A2.5 2.5 0 0 1 10 16h-4a2.5 2.5 0 0 1-1.537-4.464A2.494 2.494 0 0 1 4 11.302v-1.402c0-.753-.42-1.396-1-1.738V8zm1 6.798A1.496 1.496 0 0 0 6 14.756V13h4v1.756a1.496 1.496 0 0 0 1 2.427 1.5 1.5 0 0 0 .894-2.82A1.5 1.5 0 0 0 10 13.756V11h-.894A1.5 1.5 0 0 0 8.5 12.5H7.001A1.5 1.5 0 0 0 5.5 11H4v2.756z" />
                            </svg> Vendas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart4" viewBox="0 0 16 16">
                                <path d="M1 0h2v1h2l.781 2.344L7.219 4H15v2h-.781l-1.938 5.828A1 1 0 0 1 11.344 14H4.656a1 1 0 0 1-.938-.828L1.719 6H0V4h1zm4 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm7 0a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm-1 3H6.437L7.28 14h2.439l.843-2zM6.43 12h3.141l-.57 1.713a.5.5 0 1 0 .946.342L11.75 12H14v-1h-1.25L10 8.5 10.875 7h-7.75l.266 1h8.25a.5.5 0 1 0 0-1H3.34L2.096 4H1V2h1.5l.333 1h11.334l.667-2H15v2h-1.5l-.666 2H6.43L5.596 6H14v1H5.595l.667 2z" />
                            </svg> Compras
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-grid-fill" viewBox="0 0 16 16">
                                <path d="M2 4a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4zm6 0a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1V4zM2 9a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V9zm6 0a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1V9zM2 14a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1zm6 0a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1v-1z" />
                            </svg> Produtos
                        </a>
                    </li>
                </ul>
                <form class="d-flex mt-3" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>
</nav>