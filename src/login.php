<!DOCTYPE html>
<html lang="pt" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <title>.DEV Blog - Entrar</title>
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
            <a class="btn btn-outline-success ms-md-0 ms-md-2 disabled" href="/">
                <strong>Entrar</strong>
            </a>
            <a class="btn btn-outline-secondary ms-md-0 ms-md-2" href="/">
                <strong>Cadastrar</strong>
            </a>
        </div>
    </header>
    <div class="container">
        <div class="d-flex mt-5 justify-content-center h-100">
            <div id="login-box" class="row card m-md-5 align-self-center border-secondary w-50 shadow-lg">
                <div class="card-header text-body-emphasis">
                    <h5>Minha conta</h5>
                </div>
                <div class="card-body">
                    <form action="php/MVCRouter" method="post">
                        <div class="form-group row mt-1">
                            <label for="username" class="col-sm-3 col-form-label">Usuário</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="username">
                            </div>
                        </div>
                        <div class="form-group row mt-1">
                            <label for="password" class="col-sm-3 col-form-label">Senha</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="password">
                            </div>
                        </div>
                        <div class="form-group col mt-3">
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-sm btn-primary">Entrar</button>
                                &nbsp;&nbsp;&nbsp;
                                <a href="/" class="btn btn-sm btn-outline-secondary" role="button">
                                    <span class="glyphicon glyphicon-share-alt"></span>
                                    Voltar
                                </a>
                            </div>
                            <div class="d-flex justify-content-center">
                                <small>
                                    <a class="link-secondary" href="/">
                                        <span class="glyphicon glyphicon-question-sign"></span>
                                        Não possui cadastro? Clique aqui!
                                    </a>
                                </small>
                            </div>
                        </div>
                    </form>
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
    <script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
    <script>
        $(function () {
            $('#login-box').hide().fadeIn('slow');
        });
    </script>
</body>
</html>