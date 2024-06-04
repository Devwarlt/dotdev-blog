<?php
	require('php\PhpUtils.php');
	require('php\dao\LoginDAO.php');
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
		utils::getSingleton()->onRedirectErr("É necessário realizar o login para acessar esta página.",
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
<div class="form-group col resizable-content">
	<div class="text-light small rounded-1 col-sm-3" style="padding: 4px 4px 0 4px; float: right;">
		<div class="card text-center border-secondary">
			<div class="card-header bg-dark text-light shadow-sm">
				<h5 class="card-title">
					<span class="small glyphicon glyphicon-tasks"></span> Painel de Controle
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
					<span class="small glyphicon glyphicon-search"></span> Minhas postagens
				</h5>
			</div>
			<div class="card-body">
				<ul class="nav nav-pills nav-fill">
					<li class="nav-item">
						<button type="button" class="btn btn-lg btn-success" data-bs-toggle="modal"
						        data-bs-target="#create-post-modal">
							<span class="glyphicon small glyphicon-plus-sign"></span> Nova postagem <small><span
										class="badge bg-success-subtle text-success-emphasis"><?= post::getSingleton()
							                                                                          ->count(login::getSingleton()
							                                                                                       ->fetchLogin())
							                                                                          ->getCount() ?></span></small>
						</button>
					</li>
					<li class="nav-item">
						<button id="count-button" type="button" class="btn btn-lg btn-secondary position-relative
						disabled" data-bs-toggle="modal" data-bs-target="#remove-post-modal"
						        onclick="fillRemoveModalData()">
							<span class="glyphicon small glyphicon-remove-sign"></span> Remover postagem
							<span id="count-checkboxes"
							      class="position-absolute start-100 translate-middle badge rounded-pill bg-danger"
							      style="display:none; padding-top: -2px">
                            </span>
						</button>
					</li>
				</ul>
				<hr />
				<table class="table
				<?= post::getSingleton()->count(login::getSingleton()->fetchLogin())->getCount() === 0
					? "table-light"
					: "table-hover table-secondary" ?> table-sm">
					<caption class="small fst-italic blockquote blockquote-footer"
					         style="margin: var(--bs-accordion-body-padding-x) var(--bs-accordion-body-padding-y);
					         text-justify: inter-word; text-align: justify"><span
								class="small fst-italic
					glyphicon
					glyphicon-info-sign"></span> Aqui se encontram todas suas publicações. Também é possível consultar a
					                             quantidade de visualizações, total de pontos avaliados por outros
					                             usuários e opções de pré-visualização. <br /><br />Todas essas
					                             funcionalidades estão disponíveis aqui pelo seu <strong>Painel de
					                                                                                     Controle</strong>.
					</caption>
					<thead class="table-bordered table-primary">
					<tr style="vertical-align: middle" class="bg-light">
						<th scope="col" class="d-flex justify-content-center" style="margin-top: -0.04rem !important">
							<div class="form-check form-switch">
								<input id="checkbox-master" class="form-check-input" type="checkbox"
								       onclick="toggleAll(this);
									   updateCheckboxes($('#count-checkboxes'), $('#count-button'))"
									<?= post::getSingleton()->count(login::getSingleton()->fetchLogin())->getCount() ===
									    0
										? "disabled"
										: "" ?>>
							</div>
						</th>
						<th scope="col">Postagens</th>
						<th scope="col">Ações</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$powerScripts = [];
						if (post::getSingleton()->count(login::getSingleton()->fetchLogin())->getCount() === 0) { ?>
							<tr>
								<td colspan="3" class="small">
									Você não possui nenhuma postagem.
								</td>
							</tr>
							<?php
						}
						else {
							foreach (post::getSingleton()
							             ->fetch(login::getSingleton()->fetchLogin(), 0, 1000)
							             ->getPosts() as $post) {
								$powerScripts["power-point-id-" . $post->getId()] = $post->getAverageScore(); ?>
								<tr>
									<td style="vertical-align: top">
										<input class="mt-5 form-check-input checkbox-child"
										       type="checkbox"
										       id="post-id-<?= $post->getId() ?>"
										       value="<?= $post->getId() ?>"
										       onclick="toggleMaster();
											   updateCheckboxes($('#count-checkboxes'), $('#count-button'))">
									</td>
									<td style="width: 75%; padding-bottom: 1rem;">
										<div class="accordion accordion-flush">
											<small class="small text-secondary post-labels">
												<?= utils::getSingleton()->numberFormat($post->getViews()) ?>
												<span class="glyphicon glyphicon-stats small"></span></small><small
													class="small text-secondary post-labels"> Visível
												<?= utils::getSingleton()->numberFormat($post->isHidden())
													? "somente para você"
													: "para todos" ?>
												<span class="glyphicon glyphicon-eye-<?= utils::getSingleton()
												                                              ->numberFormat($post->isHidden())
													? "close"
													: "open" ?> small"></span></small><small
													class="small text-secondary post-labels">Última alteração em
												<u><?= $post->getLastUpdated()->format(DEFAULT_DATEFORMAT) ?></u> por
												<strong><?= $postOwnerName = $post->getLastUpdateUserId() !== -1 &&
												                             $post->getLastUpdateUserId() !==
												                             $post->getOwnerId()
														? login::getSingleton()
														       ->fetchUsername($post->getLastUpdateUserId())
														: "você" ?></strong>
												<span class="glyphicon glyphicon-pencil small"></span></small>
											<div class="col-form-label-sm">
												<div class="bg-dark-subtle power-container progress progress-bar-animated progress-bar-striped scrollable">
													<div role="progressbar"
													     aria-valuenow="0"
													     aria-valuemin="0"
													     aria-valuemax="100"
													     id="power-point-id-<?= $post->getId() ?>"></div>
												</div>
											</div>
											<div class="accordion-item bg-info-subtle border border-primary-subtle
											mt-2 rounded-bottom-1 shadow-sm"
											     id="accordion-flush-post-id-<?= $post->getId() ?>">
												<h2 class="accordion-header"
												    id="accordion-header-post-id-<?= $post->getId() ?>">
													<button class="accordion-button collapsed"
													        id="accordion-button-post-id-<?= $post->getId() ?>"
													        type="button"
													        data-bs-toggle="collapse"
													        data-bs-target="#accordion-post-id-<?= $post->getId() ?>"
													        aria-expanded="false"
													        aria-controls="accordion-post-id-<?= $post->getId() ?>">
														<?= $post->getTitle() ?>
													</button>
												</h2>
												<div id="accordion-post-id-<?= $post->getId() ?>"
												     class="accordion-collapse collapse"
												     aria-labelledby="accordion-header-post-id-<?= $post->getId() ?>"
												     data-bs-parent="#accordion-flush-post-id-<?= $post->getId() ?>">
													<div class="accordion-body"
													     id="accordion-post-content-id-<?= $post->getId() ?>">
														<?= $post->getText() ?>
													</div>
												</div>
											</div>
										</div>
									</td>
									<td style="vertical-align: top;">
										<div class="btn-group btn-group-sm"
										     role="group"
										     style="margin-top: 2.75rem !important">
											<button type="button" class="btn btn-warning"
											        data-bs-toggle="modal" data-bs-target="#edit-post-modal"
											        onclick="fillEditModalData(
											        <?= $post->getId() ?>,
													        '<?= $postOwnerName ?>', <?= $post->isHidden()
												        ? 'true'
												        : 'false' ?>)">
												<span class="small glyphicon glyphicon-pencil"></span>
											</button>
											<button type="button" class="btn btn-danger"
											        data-bs-toggle="modal" data-bs-target="#remove-post-modal"
											        onclick="fillRemoveSingleModalData(<?= $post->getId() ?>)">
												<span class="small glyphicon glyphicon-remove-sign"></span>
											</button>
										</div>
									</td>
								</tr>
								<?php
							}
						} ?>
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
<!-- [MODAL] add new post -->
<div class="modal"
     id="create-post-modal"
     tabindex="-1"
     aria-labelledby="create-post-modal"
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
								rows="3" style="white-space: pre-line"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Criar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- [MODAL] remove post -->
<div class="modal"
     id="remove-post-modal"
     tabindex="-1"
     aria-labelledby="remove-post-modal"
     aria-modal="true"
     role="dialog"
     style="display: none;">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
		<div class="modal-content">
			<form action="php/MVCRouter" method="post">
				<input type="hidden" name="controller" value="remove-post"> <input id="post-remove-list"
				                                                                   type="hidden"
				                                                                   name="post-remove-list"
				                                                                   value="">
				<div class="modal-header">
					<h5 class="modal-title">Remover postagem</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
				</div>
				<div class="modal-body">
					<div class="mb-3">
						Você deseja remover permanentemente <strong id="count-selected-posts"></strong> <span
								id="format-selected-posts"></span>?
						<ul id="selected-posts-remove-list">
						</ul>
					</div>
					<br />
					<div class="mb-3" style="margin: var(--bs-accordion-body-padding-x) var(--bs-accordion-body-padding-y);
					         text-justify: inter-word; text-align: justify">
						<p class="blockquote blockquote-footer fst-italic"><span class="glyphicon
						glyphicon-info-sign small fst-italic"></span> Esta ação é irreversível, pois você estará
							<strong>excluindo permanentemente</strong> os dados e o conteúdo publicado na plataforma.
						</p>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-danger">Remover</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- [MODAL] edit post -->
<div class="modal"
     id="edit-post-modal"
     tabindex="-1"
     aria-labelledby="edit-post-modal"
     aria-modal="true"
     role="dialog"
     style="display: none;">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
		<div class="modal-content">
			<form action="php/MVCRouter" method="post">
				<input type="hidden" name="controller" value="edit-post"> <input type="hidden"
				                                                                 name="post-edit-new-editor"
				                                                                 value="<?= login::getSingleton()
				                                                                                 ->fetchLogin()
				                                                                                 ->getId() ?>"> <input
						type="hidden"
						id="post-edit-id"
						name="post-edit-id"
						value="">
				<div class="modal-header">
					<h5 class="modal-title">Alterar postagem</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
				</div>
				<div class="modal-body">
					<div class="mb-3">
						<label for="post-edit-owner" class="form-label">Autor</label>
						<input class="form-control bg-secondary-subtle"
						       type="text"
						       id="post-edit-owner"
						       value=""
						       aria-label="readonly input"
						       readonly>
					</div>
					<div class="mb-3">
						<label for="post-edit-new-editor" class="form-label">Editor</label>
						<input class="form-control bg-secondary-subtle"
						       type="text"
						       id="post-edit-new-editor"
						       name="post-edit-new-editor-name"
						       value="<?= login::getSingleton()->fetchLogin()->getUsername() ?>"
						       aria-label="readonly input"
						       readonly>
					</div>
					<div class="mb-3">
						<label for="post-edit-title" class="form-label">Título</label> <input class="form-control"
						                                                                      id="post-edit-title"
						                                                                      name="post-edit-title"
						                                                                      type="text"
						                                                                      value=""
						                                                                      aria-label="input">
					</div>
					<div class="mb-3">
						<label for="post-edit-text" class="form-label">Texto</label> <textarea
								class="form-control"
								id="post-edit-text"
								name="post-edit-text"
								rows="3" style="white-space: pre-line"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-warning">Atualizar</button>
				</div>
			</form>
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
		<?php
		if (!empty($powerScripts))
		{foreach ($powerScripts as $powerId => $powerScore) {?>
		scoreHandler('<?= $powerId ?>', '<?= $powerScore ?>');
		<?php
		}} if (!is_null($err = utils::getSingleton()->getResponseCookie(RESPONSE_FAILURE, true))) { ?>
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
		<?php } if (!is_null($ok = utils::getSingleton()->getResponseCookie(RESPONSE_SUCCESS, true))) { ?>
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
