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

            require("php\PhpUtils.php");
            require("php\controller\LoginController.php");

            use php\PhpUtils as utils;

            if (isset($_POST["err"])) {
                $err = urldecode($_POST["err"]);
                if (utils::getSingleton()->checkPhpInjection($err)) {
                    utils::getSingleton()->onRedirectErr("Php Injection detectado!", "/");
                    return;
                }

                echo "
                <div class='form-group col mt-0'>
                    <div class='d-flex justify-content-center small'>
                        <div class='alert small alert-warning border-warning alert-dismissible fade show col-sm-12'
                             style='text-justify: inter-word; text-align: justify' role='alert'>
                            <p class='mb-0'>$err</p>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Fechar'>
                            </button>
                            <hr/>
                            <p class='mb-0'>
                                <span class='glyphicon glyphicon-question-sign'></span>
                                Não possui cadastro? <a class='alert-link' href='/register'>Clique aqui!</a>
                            </p>
                        </div>
                    </div>
                    <div class='small d-flex justify-content-center'>
                    </div>
                </div>";
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