<!DOCTYPE html>
<html lang="pt" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <title>.DEV Blog - Início</title>
    <link rel="stylesheet" href="css/bootstrap.min.css?t=<?php echo time(); ?>"/>
    <link rel="stylesheet" href="css/custom.css?t=<?php echo time(); ?>"/>
</head>
<body class="bg-image">
    <header class="navbar navbar-dark flex-column flex-md-row bg-dark shadow-lg
        opacity-75 border-secondary-subtle border-bottom border-0 border-opacity-10">
        <a class="navbar-brand ms-md-0 ms-md-5" href="/"><strong>.DEV Blog</strong></a>
        <div class="navbar-nav-scroll navbar-expand">
            <ul class="navbar-nav flex-md-row">
                <li class="nav-item">
                    <a class="nav-link" href="/">Postagens</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="/">Ranking</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/">Editores</a>
                </li>
            </ul>
        </div>
        <div class="float-end my-lg-auto text-light">
            <a class="btn btn-outline-success ms-md-0 ms-md-2" href="/login">
                <strong>Entrar</strong>
            </a>
            <a class="btn btn-outline-secondary ms-md-0 ms-md-2" href="/">
                <strong>Cadastrar</strong>
            </a>
        </div>
    </header>
    <div class="container">
        <div class="d-flex mt-5 justify-content-center">
            <div class="row align-self-center w-50">
    <?php

    include "php/controller/LoginController.php";

    use php\controller\LoginController;
    use php\PhpUtils as phputils;

    session_start();

    $redirect = "/";
    $login = LoginController::getSingleton();
    if ($login->isUserSignedUp()) {
        header("Location:/account");
        return;
    }

    if (isset($_GET["err"])) {
        include "php/PhpUtils.php";

        $utils = phputils::getSingleton();
        $err = urldecode($_GET["err"]);
        if ($utils->checkPhpInjection($err)) {
            $utils->onRawIndexErr("Php Injection detectado!", $redirect);
            return;
        }

        echo "
                <div class='alert alert-danger border-danger alert-dismissible fade show top-50' role='alert'>
                    <h3 style='color: darkred'>Erro!</h3>
                    <hr/>
                    <p style='color: red; text-align: justify; text-justify: inter-word'>$err</p>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Fechar'></button>
                </div>
        ";
    }

    if (isset($_GET["ok"])) {
        include "php/PhpUtils.php";

        $utils = phputils::getSingleton();
        $ok = urldecode($_GET["ok"]);
        if ($utils->checkPhpInjection($ok)) {
            $utils->onRawIndexErr("Php Injection detectado!", $redirect);
            return;
        }

        echo "
                <div class='alert alert-success border-success alert-dismissible fade show top-50' role='alert'>
                    <h3 style='color: green'>Sucesso!</h3>
                    <hr/>
                    <p style='color: limegreen; text-align: justify; text-justify: inter-word'>$ok</p>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Fechar'></button>
                </div>
        ";
    }
    ?>
            </div>
        </div>
    </div>
    <footer class="card-footer py-3 mt-auto bg-body-secondary fixed-bottom border-success-subtle border-top border-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-lg-5 mb-0">
                    <a class="d-inline-flex align-items-center mb-2 link-dark text-decoration-none" href="/"
                        aria-label=".DEV Blog">
                        <span class="fs-5">.DEV Blog</span>
                    </a>
                    <ul class="list-unstyled small text-muted">
                        <li class="mb-2">
                            <strong>Projeto Integrado III</strong>
                        </li>
                        <li class="mb-2">
                            <strong>Aluno:</strong> Nádio Dib Fernandes Pontes [matrícula: <code>201918579</code>]
                        </li>
                        <li class="mb-2">
                            Código licenciado pelo
                            <a class="alert-link"
                               href="https://github.com/Devwarlt/dotdev-blog#MIT-1-ov-file">MIT</a>.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
</body>
</html>