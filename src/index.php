<!DOCTYPE html>
<html lang="pt" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <title>.DEV Blog - Início</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
</head>
<body style="height: 100%;" class="h-100 row align-items-center  alert-light">
    <div class="col card-body">
        <form class="card card-header form-inline alert-secondary border-secondary" action="php/MVCRouter.php" method="post">
            <input type="hidden" name="controller" value="login"/>
            <h3 class="card-header">Login</h3>
            <div class="card-body card-group">
                <label for="username"></label><input type="text" id="username" name="username" placeholder="Usuário"/>&nbsp;
                <label for="password"></label><input type="password" id="password" name="password" placeholder="Senha"/>&nbsp;
                <input class="btn btn-sm btn-outline-primary" type="submit" value="Entrar"/>&nbsp;
                <input class="btn btn-sm btn-outline-secondary" type="reset" value="Resetar"/>
            </div>
        </form>
        <?php

        include "php/controller/LoginController.php";

        use php\controller\LoginController;
        use php\PhpUtils as phputils;

        session_start();

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
                $utils->onRawIndexErr("Php Injection detectado!", "/");
                return;
            }

            echo "
        <hr/>
        <div class='alert alert-danger border-danger alert-dismissible fade show' role='alert'>
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
                $utils->onRawIndexErr("Php Injection detectado!", "/");
                return;
            }

            echo "
        <hr/>
        <div class='alert alert-success border-success alert-dismissible fade show' role='alert'>
            <h3 style='color: green'>Sucesso!</h3>
            <hr/>
            <p style='color: limegreen; text-align: justify; text-justify: inter-word'>$ok</p>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Fechar'></button>
        </div>";
        }
        ?>
    </div>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
</body>
</html>