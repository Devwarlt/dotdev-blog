<?php
	require('php\PhpUtils.php');
	require('php\dao\PostDAO.php');
	require('php\dao\engine\SQLQuery.php');
	require('php\dao\engine\MySQLDatabase.php');
	require('php\model\LoginModel.php');
	require('php\model\PostModel.php');
	require('php\model\PostResultModel.php');
	require('php\controller\LoginController.php');
	require('php\controller\PostController.php');

	use php\controller\LoginController as login;
	use php\PhpUtils as utils;

	if (isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] !== $_SERVER["REQUEST_URI"]) {
		utils::getSingleton()->flushResponseCookies();
	}
	$isLoggedIn = login::getSingleton()->isUserSignedUp();
?>
<!DOCTYPE html>
<html lang="pt" style="height: 100%;">
<head>
	<meta charset="UTF-8">
	<title>.DEV Blog - Início</title>
	<link rel="stylesheet" href="css/bootstrap.min.css?t=<?= time() ?>" />
	<link rel="stylesheet" href="css/glyphicons.css?t=<?= time() ?>" />
	<link rel="stylesheet" href="css/jquery.toast.css?t=<?= time() ?>" />
	<link rel="stylesheet" href="css/custom.css?t=<?= time() ?>" />
</head>
<body class="bg-image">
<header class="navbar navbar-dark flex-column flex-md-row bg-dark shadow-lg
        opacity-75 border-secondary-subtle border-bottom border-0 border-opacity-10">
	<a class="navbar-brand ms-md-0 ms-md-5 shadow-sm link-light" href="/">
        <span class="glyphicon glyphicon-console bg-black rounded-top-1"
              style="padding: 4px 8px 4px 8px; border-top: 6px solid goldenrod"></span>&nbsp;
		<strong>.DEV Blog</strong> </a>
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
		<?php
			if (!$isLoggedIn) { ?>
				<a class="btn btn-sm btn-outline-success ms-md-0 ms-md-2" href="/login"> <strong>Entrar</strong> <span
							class="glyphicon glyphicon-log-in"></span> </a>
				<a class="btn btn-sm btn-outline-secondary ms-md-0 ms-md-2" href="/register"> <strong>Registrar</strong>
					<span class="glyphicon glyphicon-info-sign"></span> </a>
				<?php
			}
			else { ?>
				<form action="php/MVCRouter" method="post">
					<input type="hidden" name="controller" value="logout">
					<button type="submit" class="btn btn-sm btn-outline-danger ms-md-0 ms-md-2">
						<strong>Sair</strong> <span class="glyphicon glyphicon-log-out"></span>
					</button>
				</form>
				<?php
			} ?>
	</div>
</header>
<div class="form-group col resizable-content">
	<?php
		if ($isLoggedIn) { ?>
			<div class="text-light small rounded-1 col-sm-3" style="padding: 4px 4px 0 4px; float: right;">
				<div class="card text-center border-secondary">
					<div class="card-header bg-dark text-light shadow-sm">
						<h5 class="card-title">
							<span class="glyphicon glyphicon-tasks small"></span> Painel de Controle
						</h5>
					</div>
					<div class="card-body">
						<p class="card-text">
							Seja bem-vindo(a) <strong>
                        <span class="text-warning"><?= login::getSingleton()->fetchLogin()->getUsername() ?>
                        </span> </strong>! <br /> <span class="mt-1 d-flex justify-content-center badge bg-primary
                        me-auto">
							<?= login::getSingleton()->fetchLogin()->getLevelHumanReadable() ?>
						</span>
						</p>
						<ul class="list-group list-group-flush small">
							<li class="list-group-item btn-sm btn-outline-primary">
								<a class="btn btn-sm disabled" role="button" href="/">
									<span class="glyphicon glyphicon-home small"></span> <small>Início</small> </a>
							</li>
							<li class="list-group-item btn-sm btn-outline-success">
								<a class="btn btn-sm" role="button" href="/my_posts">
									<span class="glyphicon glyphicon-search small"></span> <small>Minhas
									                                                              postagens </small>
								</a>
							</li>
							<?php
								if (login::getSingleton()->fetchLogin()->getLevel() === LOGIN_LEVEL_ADMIN) { ?>
									<li class="list-group-item btn-sm btn-outline-warning">
										<a class="btn btn-sm" role="button" href="/my_moderators">
											<span class="glyphicon glyphicon-user small"></span> <small>Ver
											                                                            moderadores</small>
										</a>
									</li>
									<?php
								} ?>
						</ul>
					</div>
				</div>
			</div>
			<?php
		} ?>
</div>
<footer class="card-footer py-3 mt-4 bg-body-secondary small border-top border-5">
	<div class="container py-4">
		<div class="row">
			<div class="col-lg-5 mb-0">
				<a class="d-inline-flex align-items-center mb-2 link-dark text-decoration-none" href="/"
				   aria-label=".DEV Blog">
                    <span class="glyphicon glyphicon-console text-light bg-secondary rounded-top-1"
                          style="padding: 4px 8px 4px 8px; border-top: 6px solid darkslategray"></span>&nbsp;
					<span class="fs-5">.DEV Blog</span> </a>
				<ul class="list-unstyled small text-muted">
					<li class="mb-2">
						<strong>Projeto Integrado III</strong>
					</li>
					<li class="mb-2">
						<strong>Aluno:</strong> Nádio Dib Fernandes Pontes [matrícula: <code>201918579</code>]
					</li>
					<li class="mb-2">
						Código licenciado pelo <a class="alert-link"
						                          href="https://github.com/Devwarlt/dotdev-blog#MIT-1-ov-file">MIT</a>.
					</li>
				</ul>
			</div>
		</div>
	</div>
</footer>
<script type="text/javascript" src="js/jquery-3.7.1.min.js?t=<?= time() ?>"></script>
<script type="text/javascript" src="js/jquery.toast.js?t=<?= time() ?>"></script>
<script type="text/javascript" src="js/bootstrap.bundle.min.js?t=<?= time() ?>"></script>
<script type="text/javascript" src="js/custom.js?t=<?= time() ?>"></script>
<script type="text/javascript">
	$(() => {
		<?php if (!is_null($err = utils::getSingleton()->getResponseCookie(RESPONSE_FAILURE, true))) { ?>
		$.toast({
			"afterShown"() {
				removeCookieByName('<?= RESPONSE_FAILURE ?>');
			},
			"heading": '<span class="glyphicon glyphicon-info-sign text-warning-emphasis"></span> ' +
				'<strong>Atenção</strong>',
			"hideAfter": false,
			"position": 'bottom-right',
			"showHideTransition": 'slide',
			"text": '<?= $err ?>',
			"class": 'bg-warning rounded-2 border-warning-subtle'
		});
		<?php }
		if (!is_null($ok = utils::getSingleton()->getResponseCookie(RESPONSE_SUCCESS, true))) { ?>
		$.toast({
			"afterShown"() {
				removeCookieByName('<?= RESPONSE_SUCCESS ?>');
			},
			"heading": '<span class="glyphicon glyphicon-ok-sign text-success-emphasis"></span> ' +
				'<strong>Notificação</strong>',
			"hideAfter": false,
			"position": 'bottom-right',
			"showHideTransition": 'slide',
			"text": '<?= $ok;?>',
			"class": 'bg-success text-light rounded-2 border-success-subtle'
		});
		<?php } ?>
	});
</script>
</body>
</html>
