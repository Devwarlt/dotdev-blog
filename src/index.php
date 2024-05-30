<?php

require('php\PhpUtils.php');
require("php\model\LoginModel.php");
require("php\controller\LoginController.php");

use php\controller\LoginController as login;
use php\PhpUtils as utils;

if ($_SERVER["HTTP_REFERER"] !== $_SERVER["REQUEST_URI"])
    utils::getSingleton()->flushResponseCookies();

$isLoggedIn = login::getSingleton()->isUserSignedUp();
?>
<!DOCTYPE html>
<html lang="pt" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <title>.DEV Blog - Início</title>
    <link rel="stylesheet" href="css/bootstrap.min.css?t=<?php echo time(); ?>"/>
    <link rel="stylesheet" href="css/glyphicons.css?t=<?php echo time(); ?>"/>
    <link rel="stylesheet" href="css/custom.css?t=<?php echo time(); ?>"/>
</head>
<body class="bg-image">
<header class="navbar navbar-dark flex-column flex-md-row bg-dark shadow-lg
        opacity-75 border-secondary-subtle border-bottom border-0 border-opacity-10">
    <a class="navbar-brand ms-md-0 ms-md-5 shadow-sm link-light" href="/">
        <span class="glyphicon glyphicon-console bg-black rounded-top-1"
              style="padding: 4px 8px 4px 8px; border-top: 6px solid goldenrod"></span>&nbsp;
        <strong>.DEV Blog</strong>
    </a>
    <div class="navbar-nav-scroll navbar-expand navbar-toggler">
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
    <div class="float-end my-lg-auto text-light" style="padding-right: 4px">
        <?php if (!$isLoggedIn) { ?>
            <a class="btn btn-sm btn-outline-success ms-md-0 ms-md-2" href="/login">
                <strong>Entrar</strong> <span class="glyphicon glyphicon-log-in"></span>
            </a>
            <a class="btn btn-sm btn-outline-secondary ms-md-0 ms-md-2" href="/register">
                <strong>Registrar</strong> <span class="glyphicon glyphicon-info-sign"></span>
            </a>
        <?php } else { ?>
            <form action="php/MVCRouter" method="post">
                <input type="hidden" name="controller" value="logout">
                <button type="submit" class="btn btn-sm btn-outline-danger ms-md-0 ms-md-2">
                    <strong>Sair</strong> <span class="glyphicon glyphicon-log-out"></span>
                </button>
            </form>
        <?php } ?>
    </div>
</header>
<?php if ($isLoggedIn) { ?>
    <div class="text-light small mt-1 rounded-1 col-sm-3"
         style="padding: 4px 8px 4px 8px; float: right;">
        <div class="card text-center border-secondary">
            <div class="card-header btn bg-dark text-light shadow-sm">
                <h5 class="card-title">
                    <span class="glyphicon glyphicon-tasks"></span>
                    Painel de Controle
                </h5>
            </div>
            <div class="card-body">
                <p class="card-text">
                    Seja bem-vindo(a)
                    <strong>
                        <span class="text-warning"><?php echo login::getSingleton()->fetchLogin()->getUsername(); ?>
                        </span>
                    </strong>!
                    <br/>
                    <small>
                        Nível de acesso:
                        <code class="bg-warning-subtle rounded-2 text-secondary-emphasis">
                            <?php echo login::getSingleton()->fetchLogin()->getLevelHumanReadable(); ?>
                        </code>
                    </small>
                </p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item btn-sm btn-outline-success">
                        <a class="btn btn-sm" role="button" href="/my_posts">
                            <span class="glyphicon glyphicon-search"></span>
                            Minhas postagens
                        </a>
                    </li>
                    <?php if (login::getSingleton()->fetchLogin()->getLevel() === LOGIN_LEVEL_ADMIN) { ?>
                        <li class="list-group-item btn-sm btn-outline-warning">
                            <a class="btn btn-sm" role="button" href="/my_moderators">
                                <span class="glyphicon glyphicon-user"></span>
                                Ver moderadores
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
<?php } ?>
<div class="container">
    <div class="d-flex mt-5 justify-content-center">
        <div class="row align-self-center w-50 scrollable">
            <?php if (!is_null($err = utils::getSingleton()->getResponseCookie(RESPONSE_FAILURE, true))) { ?>
                <div class="form-group col mt-3">
                    <div class="d-flex justify-content-center small">
                        <div class="alert small alert-info border-info alert-dismissible
                                    fade show col-sm-12 shadow"
                             style="text-justify: inter-word; text-align: justify" role="alert">
                            <p class="mb-0">
                                <span class="glyphicon glyphicon-info-sign"></span> <?php echo $err; ?>
                            </p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar">
                            </button>
                        </div>
                    </div>
                </div>
            <?php }
            if (!is_null($ok = utils::getSingleton()->getResponseCookie(RESPONSE_SUCCESS, true))) { ?>
                <div class="form-group col mt-3">
                    <div class="d-flex justify-content-center small">
                        <div class="alert small alert-success border-success alert-dismissible
                                    fade show col-sm-12 shadow"
                             style="text-justify: inter-word; text-align: justify" role="alert">
                            <p class="mb-0">
                                <span class="glyphicon glyphicon-ok-sign"></span> <?php echo $ok; ?>
                            </p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar">
                            </button>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<footer class="card-footer py-3 mt-auto bg-body-secondary small fixed-bottom border-success-subtle border-top border-5">
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-5 mb-0">
                <a class="d-inline-flex align-items-center mb-2 link-dark text-decoration-none" href="/"
                   aria-label=".DEV Blog">
                    <span class="glyphicon glyphicon-console text-light bg-secondary rounded-top-1"
                          style="padding: 4px 8px 4px 8px; border-top: 6px solid darkslategray"></span>&nbsp;
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