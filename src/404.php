<!DOCTYPE html>
<html lang="pt" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <title>.DEV Blog - Página inexistente</title>
    <link rel="stylesheet" href="css/bootstrap.min.css?t=<?php echo time(); ?>"/>
    <link rel="stylesheet" href="css/glyphicons.css?t=<?php echo time(); ?>"/>
    <link rel="stylesheet" href="css/custom.css?t=<?php echo time(); ?>"/>
</head>
<body class="bg-image">
<header class="navbar navbar-dark flex-column flex-md-row bg-dark shadow-lg
        opacity-75 border-secondary-subtle border-bottom border-0 border-opacity-10">
    <a class="navbar-brand ms-md-0 ms-md-5" href="/"><strong>.DEV Blog</strong></a>
</header>
<div class="container">
    <div class="d-flex mt-5 justify-content-center">
        <div class="row align-self-center w-50 scrollable">
            <div class="form-group col mt-0">
                <div class="d-flex justify-content-center">
                    <div class="alert alert-warning border-danger bg-danger text-light fade show col-sm-12">
                        <h4 class="alert-heading"><span class="glyphicon glyphicon-alert"></span>
                            Página não encontrada!
                        </h4>
                        <p class="mb-0 small" style="text-justify: inter-word; text-align: justify">
                            A página <code
                                    class="link-warning bg-dark rounded-2 shadow-sm"><?php echo $_SERVER["REQUEST_URI"]; ?></code>
                            não existe ou foi movida para outro diretório. Caso esse erro persista, entre em contato com
                            o administrador do sistema através do contato abaixo.
                        </p>
                        <hr class="border-dark"/>
                        <p class="mb-0 small d-flex justify-content-center">
                            <?php
                            $email = $_SERVER["SERVER_ADMIN"];
                            echo "
                            <a class='link-warning text-decoration-none' href='mailto:$email'>
                                <span class='glyphicon glyphicon-envelope shadow-sm'></span>
                            </a>&nbsp;<code class='link-warning bg-dark rounded-2 shadow-sm'>$email</code>";
                            ?>
                        </p>
                        <div class="form-group col mt-3">
                            <div class="d-flex justify-content-center">
                                <a href="/" class="btn btn-sm btn-outline-light" role="button">
                                    <span class="glyphicon glyphicon-share-alt"></span>
                                    Voltar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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