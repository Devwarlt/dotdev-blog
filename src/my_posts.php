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
	use php\controller\PostController as post;
	use php\PhpUtils as utils;

	if (!($isLoggedIn = login::getSingleton()->isUserSignedUp())) {
		utils::getSingleton()->onRedirectOk("É necessário realizar o login para acessar esta página.",
			"/login");
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
	<title>.DEV Blog - Minhas postagens</title>
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
		<form action="php/MVCRouter" method="post">
			<input type="hidden" name="controller" value="logout">
			<button type="submit" class="btn btn-sm btn-outline-danger ms-md-0 ms-md-2">
				<strong>Sair</strong> <span class="glyphicon glyphicon-log-out"></span>
			</button>
		</form>
	</div>
</header>
<div class="form-group col bg-dark-subtle resizable-content">
	<div class="text-light small rounded-1 col-sm-3" style="padding: 4px 4px 0 4px; float: right;">
		<div class="card text-center border-secondary">
			<div class="card-header bg-dark text-light shadow-sm">
				<h5 class="card-title">
					<span class="glyphicon glyphicon-tasks"></span> Painel de Controle
				</h5>
			</div>
			<div class="card-body">
				<p class="card-text">
					Seja bem-vindo(a) <strong>
                        <span class="text-warning"><?= login::getSingleton()->fetchLogin()->getUsername() ?>
                        </span> </strong>! <br /> <span class="d-flex justify-content-center badge bg-primary
                        me-auto">
							<?= login::getSingleton()->fetchLogin()->getLevelHumanReadable() ?>
						</span> <span class="mt-2 badge bg-dark me-auto">Postagens:
					<span
							class="badge rounded-pill bg-secondary"><?= post::getSingleton()
					                                                        ->count(login::getSingleton()->fetchLogin())
					                                                        ->getCount() ?></span></span>
				</p>
				<hr />
				<ul class="list-group list-group-flush small">
					<li class="list-group-item btn-sm btn-outline-primary">
						<a class="btn btn-sm" role="button" href="/">
							<span class="glyphicon glyphicon-home small"></span> <small>Início</small> </a>
					</li>
					<li class="list-group-item btn-sm btn-outline-success">
						<a class="btn btn-sm disabled" role="button" href="/my_posts">
							<span class="glyphicon glyphicon-search small"></span> <small>Minhas postagens </small> </a>
					</li>
					<?php
						if (login::getSingleton()->fetchLogin()->getLevel() === LOGIN_LEVEL_ADMIN) { ?>
							<li class="list-group-item btn-sm btn-outline-warning">
								<a class="btn btn-sm" role="button" href="/my_moderators">
									<span class="glyphicon glyphicon-user small"></span> <small>Ver moderadores</small>
								</a>
							</li>
							<?php
						} ?>
				</ul>
			</div>
		</div>
	</div>
	<div class="scrollable" style="padding: 4px 0 0 4px;">
		<div class="card text-center border-secondary">
			<div class="card-header bg-dark text-light shadow-sm">
				<h5 class="card-title">
					<span class="glyphicon glyphicon-search"></span> Minhas postagens
				</h5>
			</div>
			<div class="card-body">
				<ul class="nav nav-pills nav-fill">
					<li class="nav-item">
						<button type="button" class="btn btn-success" data-bs-toggle="modal"
						        data-bs-target="#create-post-modal">
							<span class="glyphicon glyphicon-plus-sign"></span> Nova postagem
						</button>
					</li>
					<li class="nav-item">
						<button id="count-button" type="button" class="btn btn-secondary position-relative disabled">
							<span class="glyphicon glyphicon-remove-sign"></span> <label id="count-label"
							                                                             for="count-button">Remover
							                                                                                postagem</label>
							<span id="count-checkboxes"
							      class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
							      style="display:none;">
                            </span>
						</button>
					</li>
				</ul>
				<hr />
				<table class="table table-borderless table-striped table-hover table-sm accordion accordion-flush">
					<thead>
					<tr style="vertical-align: middle">
						<th scope="col" class="d-flex justify-content-center">
							<div class="form-check form-switch">
								<input id="checkbox-master" class="form-check-input" type="checkbox"
								       onclick="toggleAll(this);
                                       updateSelectedCheckboxes(
                                           $('#count-checkboxes'), $('#count-button'), $('#count-label'),
                                           'Remover postagem', 'Remover postagens')">
							</div>
						</th>
						<th scope="col">Ações</th>
						<th scope="col">Postagens</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<th scope="row" style="vertical-align: middle">
							<input class="form-check-input checkbox-child" type="checkbox" id="checkboxNoLabel"
							       value="" onclick="
                                       updateSingleCheckbox(
                                           this, $('#checkbox-master'),
                                           $('#count-checkboxes'), $('#count-button'), $('#count-label'),
                                           'Remover postagem', 'Remover postagens')">
						</th>
						<td style="vertical-align: middle">
							<div class="btn-group" role="group">
								<button type="button" class="btn btn-warning">
									<span class="glyphicon glyphicon-pencil"></span>
								</button>
								<button type="button" class="btn btn-danger">
									<span class="glyphicon glyphicon-remove-sign"></span>
								</button>
							</div>
						</td>
						<td style="width: 75%">
							<div class="accordion accordion-flush" id="accordionFlushExample">
								<div class="accordion-item">
									<h2 class="accordion-header" id="flush-headingOne">
										<button class="accordion-button collapsed" type="button"
										        data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
										        aria-expanded="false" aria-controls="flush-collapseOne">
											Accordion Item #1
										</button>
									</h2>
									<div id="flush-collapseOne" class="accordion-collapse collapse"
									     aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
										<div class="accordion-body">Placeholder content for this accordion, which is
										                            intended to demonstrate the
											<code>.accordion-flush</code> class. This is the first item's accordion
										                            body.
										</div>
									</div>
								</div>
							</div>
						</td>
					</tr>
					</tbody>
				</table>
				<hr />
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
</div>
<div class="modal"
     id="create-post-modal"
     tabindex="-1"
     aria-labelledby="exampleModalLiveLabel"
     aria-modal="true"
     role="dialog"
     style="display: none;">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
		<div class="modal-content">
			<form action="php/MVCRouter" method="post">
				<input type="hidden" name="controller" value="create-post">
				<div class="modal-header">
					<h5 class="modal-title">Nova postagem</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
				</div>
				<div class="modal-body">
					<div class="mb-3">
						<label for="post-create-username" class="form-label">Autor</label>
						<input class="form-control bg-secondary-subtle"
						       type="text"
						       id="post-create-username"
						       value="<?= login::getSingleton()->fetchLogin()->getUsername() ?>"
						       aria-label="readonly input"
						       readonly>
					</div>
					<div class="mb-3">
						<label for="post-create-title" class="form-label">Título</label> <input class="form-control"
						                                                                        id="post-create-title"
						                                                                        name="post-create-title"
						                                                                        type="text"
						                                                                        value=""
						                                                                        aria-label="input">
					</div>
					<div class="mb-3">
						<label for="post-create-text" class="form-label">Texto</label> <textarea
								class="form-control"
								id="post-create-text"
								name="post-create-text"
								rows="3"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Criar</button>
				</div>
			</form>
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
			"bgColor": 'bg-warning text-secondary rounded-2 border-warning-subtle',
			"heading": '<span class="glyphicon glyphicon-info-sign"></span> <strong>Atenção</strong>',
			"hideAfter": false,
			"position": 'bottom-right',
			"showHideTransition": 'slide',
			"text": '<?= $err ?>'
		});
		<?php }
		if (!is_null($ok = utils::getSingleton()->getResponseCookie(RESPONSE_SUCCESS, true))) { ?>
		$.toast({
			"afterShown"() {
				removeCookieByName('<?= RESPONSE_SUCCESS ?>');
			},
			"bgColor": 'bg-success text-white rounded-2 border-success-subtle',
			"heading": '<span class="glyphicon glyphicon-ok-sign"></span> <strong>Notificação</strong>',
			"hideAfter": false,
			"position": 'bottom-right',
			"showHideTransition": 'slide',
			"text": '<?= $ok ?>'
		});
		<?php } ?>
	});
</script>
</body>
</html>
