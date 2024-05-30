<?php

require('php\PhpUtils.php');
require("php\model\LoginModel.php");
require("php\controller\LoginController.php");

use php\controller\LoginController as login;
use php\PhpUtils as utils;

if (!($isLoggedIn = login::getSingleton()->isUserSignedUp())) {
    utils::getSingleton()->onRedirectOk(
        "É necessário realizar o login para acessar esta página.",
        "/login"
    );
    return;
}

if ($_SERVER["HTTP_REFERER"] !== $_SERVER["REQUEST_URI"])
    utils::getSingleton()->flushResponseCookies();
?>
<!DOCTYPE html>
<html lang="pt" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <title>.DEV Blog - Minhas postagens</title>
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
        <form action="php/MVCRouter" method="post">
            <input type="hidden" name="controller" value="logout">
            <button type="submit" class="btn btn-sm btn-outline-danger ms-md-0 ms-md-2">
                <strong>Sair</strong> <span class="glyphicon glyphicon-log-out"></span>
            </button>
        </form>
    </div>
</header>
<div class="form-group col mt-1">
    <div class="text-light small rounded-1 col-sm-3"
         style="padding: 0 4px 0 4px; float: right;">
        <div class="card text-center border-secondary">
            <div class="card-header bg-dark text-light shadow-sm">
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
                    <li class="list-group-item btn-sm btn-outline-success disabled">
                        <a class="btn btn-sm active" role="button" href="/my_posts">
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
    <div class="card text-center border-secondary">
        <div class="card-header bg-dark text-light shadow-sm">
            <h5 class="card-title">
                <span class="glyphicon glyphicon-search"></span>
                Minhas postagens
            </h5>
        </div>
        <div class="card-body">
            <div class="accordion accordion-flush" style="padding: 4px 0 4px 8px;" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseOne" aria-expanded="false"
                                aria-controls="flush-collapseOne">
                            Accordion Item #1
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                         data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">Placeholder content for this accordion, which is intended to
                            demonstrate
                            the <code>.accordion-flush</code> class. This is the first item's accordion body.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                aria-controls="flush-collapseTwo">
                            Accordion Item #2
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
                         data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">Placeholder content for this accordion, which is intended to
                            demonstrate
                            the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's
                            imagine
                            this being filled with some actual content.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseThree" aria-expanded="false"
                                aria-controls="flush-collapseThree">
                            Accordion Item #3
                        </button>
                    </h2>
                    <div id="flush-collapseThree" class="accordion-collapse collapse"
                         aria-labelledby="flush-headingThree"
                         data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">Placeholder content for this accordion, which is intended to
                            demonstrate
                            the <code>.accordion-flush</code> class. This is the third item's accordion body. Nothing
                            more
                            exciting happening here in terms of content, but just filling up the space to make it look,
                            at
                            least at first glance, a bit more representative of how this would look in a real-world
                            application.
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <nav>
                <ul class="pagination pagination-sm justify-content-center">
                    <li class="page-item active" aria-current="page">
                        <span class="page-link">1</span>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<div class="container">
    <div class="d-flex row mt-5 justify-content-center">
        <div class="form-group row mt-2">
            <div class="col align-self-center w-50 scrollable">
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