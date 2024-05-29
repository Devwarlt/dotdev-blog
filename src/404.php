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
    <div class="navbar-nav-scroll navbar-expand">
        <ul class="navbar-nav flex-md-row">
            <li class="nav-item">
                <a class="nav-link" href="/posts">Postagens</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="/ranking">Ranking</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/authors">Editores</a>
            </li>
        </ul>
    </div>
</header>
<div class="container">
    <div class="d-flex mt-5 justify-content-center">
        <div class="row align-self-center w-50" style="overflow-y: auto; max-height: 400px">
            <div class="form-group col mt-0">
                <div class="d-flex justify-content-center">
                    <div class="alert alert-danger border-danger fade show col-sm-12">
                        <h4 class="alert-heading"><span class="glyphicon glyphicon-alert"></span> Página não encontrada!
                        </h4>
                        <p class="mb-0 small" style="text-justify: inter-word; text-align: justify">
                            A página <code class="link-danger bg-dark"><?php echo $_SERVER["REQUEST_URI"]; ?></code>
                            não existe ou foi movida para outro diretório.
                        </p>
                        <hr/>
                        <div class="form-group col mt-3">
                            <div class="d-flex justify-content-center">
                                <a href="/" class="btn btn-sm btn-outline-secondary" role="button">
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