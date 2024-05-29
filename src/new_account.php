<!DOCTYPE html>
<html lang="pt" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <title>.DEV Blog - Nova conta</title>
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
    <div class="float-end my-lg-auto text-light">
        <a class="btn btn-outline-success ms-md-0 ms-md-2" href="/login">
            <strong>Entrar</strong>
        </a>
        <a class="btn btn-outline-secondary ms-md-0 ms-md-2 disabled" href="/new_account">
            <strong>Nova Conta</strong>
        </a>
    </div>
</header>
<div class="container">
    <div class="d-flex mt-5 justify-content-center h-100">
        <div id="register-box" class="row card m-md-5 align-self-center border-secondary w-50 shadow-lg">
            <div class="card-header text-body-emphasis">
                <h5>Cadastrar nova conta</h5>
            </div>
            <div class="card-body" style="overflow-y: auto; max-height: 600px">
                <form action="php/MVCRouter" method="post">
                    <input type="hidden" name="controller" value="register">
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
                    <div class="form-group row mt-2">
                        <div class="d-flex justify-content-center">
                            <div class="col-sm-10">
                                <div class="power-container progress">
                                    <div role="progressbar" aria-valuenow="0"
                                         aria-valuemin="0" aria-valuemax="100" id="power-point"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col mt-2">
                        <div class="d-flex justify-content-center small">
                            <div class="alert small alert-info border-info fade show col-sm-12" role="alert">
                                <p class="mb-0">Para registrar uma senha forte, siga as instruções abaixo:</p>
                                <ol>
                                    <li>Utilize espaço entre a senha para aumentar sua complexidade;</li>
                                    <li>Letras maiúsculas - <code>ABCDEFGHIJKLMNOPQRSTUVXYWZ</code>;</li>
                                    <li>Números - <code>0123456789</code>; e</li>
                                    <li>Símbolos - <code>"!@#$%¨&*</code>.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col mt-0">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-sm btn-success">Registrar</button>
                            &nbsp;&nbsp;
                            <a href="/" class="btn btn-sm btn-outline-secondary" role="button">
                                <span class="glyphicon glyphicon-share-alt"></span>
                                Voltar
                            </a>
                        </div>
                    </div>
                    <?php

                    require("php\controller\LoginController.php");
                    require("php\PhpUtils.php");

                    use php\controller\LoginController as login;
                    use php\PhpUtils as utils;

                    if (login::getSingleton()->isUserSignedUp()) {
                        utils::getSingleton()->onRedirectOk(null, "/");
                        return;
                    }

                    if (!is_null($err = utils::getSingleton()->getResponseCookie(RESPONSE_FAILURE, true)))
                        echo "
                    <div class='form-group col mt-4'>
                        <div class='d-flex justify-content-center small'>
                            <div class='alert small alert-warning border-warning alert-dismissible fade show col-sm-12'
                                 style='text-justify: inter-word; text-align: justify' role='alert'>
                                <p class='mb-0'>" . $err . "</p>
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Fechar'>
                                </button>
                            </div>
                        </div>
                    </div>";
                    ?>
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
<script type="text/javascript" src="js/custom.js"></script>
<script>
    $(function () {
        $('#register-box').hide().fadeIn('slow');
    });
</script>
</body>
</html>