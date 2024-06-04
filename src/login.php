<?php
	require('php\PhpUtils.php');
	require('php\controller\LoginController.php');

	use php\controller\LoginController as login;
	use php\PhpUtils as utils;

	if (login::getSingleton()->isUserSignedUp()) {
		utils::getSingleton()->onRedirectOk("Você já está entrou no sistema, não é necessário 
		realizar outro login.",
			"/");
		return;
	}
	if (isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] !== $_SERVER["REQUEST_URI"]) {
		utils::getSingleton()->flushResponseCookies();
	}
?>
<!DOCTYPE html>
<html lang="pt" style="height: 100%;">
<head>
	<meta charset="UTF-8">
	<title>.DEV Blog - Entrar</title>
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
		<a class="btn btn-sm btn-outline-success ms-md-0 ms-md-2 active disabled" href="/login"> <strong>Entrar</strong>
			<span class="glyphicon glyphicon-log-in"></span> </a>
		<a class="btn btn-sm btn-outline-secondary ms-md-0 ms-md-2" href="/register"> <strong>Registrar</strong> <span
					class="glyphicon glyphicon-info-sign"></span> </a>
	</div>
</header>
<div class="form-group col resizable-content">
	<div class="d-flex mt-5 justify-content-center h-100">
		<div id="login-box" class="row card m-md-5 align-self-center border-secondary w-50 shadow-lg">
			<div class="card-header bg-dark text-light text-center">
				<h5>Minha conta</h5>
			</div>
			<div class="card-body scrollable">
				<form action="php/MVCRouter" method="post">
					<input type="hidden" name="controller" value="login">
					<div class="form-group row mt-1">
						<label for="username" class="col-sm-3 col-form-label">Usuário</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="username" name="username">
						</div>
					</div>
					<div class="form-group row mt-1">
						<label for="password" class="col-sm-3 col-form-label">Senha</label>
						<div class="col-sm-8">
							<input type="password" class="form-control" id="password" name="password">
						</div>
					</div>
					<div class="form-group col mt-3">
						<div class="d-flex justify-content-center">
							<button type="submit" class="btn btn-sm btn-primary">Entrar</button>
							&nbsp;&nbsp;
							<a href="/" class="btn btn-sm btn-outline-secondary" role="button">
								<span class="glyphicon glyphicon-share-alt"></span> Voltar </a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
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
		$('#login-box').hide().fadeIn('slow');
		<?php if (!is_null($err = utils::getSingleton()->getResponseCookie(RESPONSE_FAILURE, true))) { ?>
		$.toast({
			"afterShown"() {
				removeCookieByName('<?= RESPONSE_FAILURE ?>');
			},
			"heading": '<span class="glyphicon glyphicon-info-sign text-warning-emphasis"></span> ' +
				'<strong>Atenção</strong>',
			"hideAfter": false,
			"position": 'top-center',
			"showHideTransition": 'fade',
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
			"position": 'top-center',
			"showHideTransition": 'fade',
			"text": '<?= $ok;?>',
			"class": 'bg-success text-light rounded-2 border-success-subtle'
		});
		<?php } ?>
	});
</script>
</body>
</html>
