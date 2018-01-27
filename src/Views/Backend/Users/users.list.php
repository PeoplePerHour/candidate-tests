<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<!-- BEGIN HEAD -->

	<head>
		<meta charset="utf-8" />
		<title><?= SITENAME ?> | Users</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1" name="viewport" />
		<meta content="<?= SITENAME ?> Dashboard" name="description" />
		<meta content="" name="author" />
		<?php require_once DIR.'/src/Views/Backend/inc/global_css.php' ?>
		<!-- BEGIN PAGE LEVEL PLUGINS -->
		<link href="<?= DOMAIN ?>/theme/admin/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
		<link href="<?= DOMAIN ?>/theme/admin/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="<?= DOMAIN ?>/theme/admin/assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
		<!-- END PAGE LEVEL PLUGINS -->
	</head>
	<!-- END HEAD -->

	<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-fixed page-md">

		<!-- BEGIN HEADER -->
		<div class="page-header navbar navbar-fixed-top">
			<!-- BEGIN HEADER INNER -->
			<div class="page-header-inner ">
				<!-- BEGIN LOGO -->
				<?php require_once(DIR . '/src/Views/Backend/inc/logo.v.php'); ?>
				<!-- END LOGO -->
				<!-- BEGIN RESPONSIVE MENU TOGGLER -->
				<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
				<!-- END RESPONSIVE MENU TOGGLER -->
				<!-- BEGIN PAGE ACTIONS -->
				<!-- DOC: Remove "hide" class to enable the page header actions -->
				<?php require_once DIR . '/src/Views/Backend/inc/dropdown.v.php'?>
				<!-- END PAGE ACTIONS -->
				<!-- BEGIN PAGE TOP -->
				<div class="page-top">
					<!-- BEGIN TOP NAVIGATION MENU -->
					<?php require_once DIR . '/src/Views/Backend/inc/top_menu.v.php'?>
					<!-- END TOP NAVIGATION MENU -->
				</div>
				<!-- END PAGE TOP -->
			</div>
			<!-- END HEADER INNER -->
		</div>
		<!-- END HEADER -->
		<!-- BEGIN HEADER & CONTENT DIVIDER -->
		<div class="clearfix"> </div>
		<!-- END HEADER & CONTENT DIVIDER -->
		<!-- BEGIN CONTAINER -->
		<div class="page-container">
			<!-- BEGIN SIDEBAR -->
			<?php require_once DIR . '/src/Views/Backend/inc/sidebar.v.php' ?>
			<!-- END SIDEBAR -->
			<!-- BEGIN CONTENT -->
			<div class="page-content-wrapper">
				<!-- BEGIN CONTENT BODY -->
				<div class="page-content">
					<!-- BEGIN PAGE HEADER-->
					<h1 class="page-title"> Users
						<small></small>
					</h1>
					<!-- BEGIN PAGE BAR -->
					<div class="page-bar">
						<!-- BEGIN BREADCRUMBS -->
						<ul class="page-breadcrumb">
							<li>
								<i class="fa icon-home"></i>
								<a href="<?= DOMAIN ?>"><span>Dashboard</span></a>
								<i class="fa fa-angle-right"></i>
								<i class="fa icon-users"></i>
								<span>Users</span>
							</li>
						</ul>
						<!-- END BREADCRUMBS -->
					</div>
					<!-- END PAGE BAR -->
					<?php if(!empty($messages)) : ?>
						<?php foreach($messages as $type => $msgs) : ?>
							<?php foreach($msgs as $msg) : ?>
								<div class="alert alert-<?= $type ?>">
									<button class="close" data-close="alert"></button>
									<span><strong><?= $msg ?></strong></span>
								</div>
							<?php endforeach; ?>
						<?php endforeach; ?>
					<?php endif; ?>
					<!-- END PAGE HEADER-->

					<div class="row">
						<div class="col-md-12">
							<div class="table-scrollable">
								<div class="portlet light ">
									<div class="portlet-title">
										<div class="caption">
											<form id="search_list" name="search_list" class="form-inline" action='<?= DOMAIN ?>/panel/users' method="GET">
                                                <div class="form-group">
													<input type="text" class="form-control" name="filter_user" id="filter_user"
														   value="<?= isset($_GET['filter_user']) ? $_GET['filter_user'] : '' ?>" placeholder="Search username..." />
												</div>
                                                <div class="form-group">
                                                    <select id="filter_active" class="form-control" name="filter_active">
                                                        <option value="">Select Active Status</option>
                                                        <option value="1" <?= isset($_SESSION['Users']['nav']['filter_active']) && $_SESSION['Users']['nav']['filter_active'] == 1 ? 'selected' : '' ?>>Active</option>
                                                        <option value="0" <?= isset($_SESSION['Users']['nav']['filter_active']) && $_SESSION['Users']['nav']['filter_active'] == '0' ? 'selected' : '' ?>>Not Active</option>
                                                    </select>
                                                </div>
											</form>
										</div>
									</div>
									<form id="users_list_form" name="users_list_form" method="POST" action='<?= DOMAIN ?>/panel/users/delete-user'>
										<div class="actions pull-right" style="margin-top: -55px">
											<input type="hidden" name="csrf_name" value="<?php echo $csrf_name; ?>">
											<input type="hidden" name="csrf_value" value="<?php echo $csrf_value; ?>">
											<a class="btn btn-transparent green btn-outline btn-circle btn-sm active" href="<?= DOMAIN ?>/panel/users/add-user">Add new user</a>
											<button id="delete_all" type="submit" class="btn btn-transparent red btn-outline btn-circle btn-sm active">Delete user</button>
										</div>
										<div id="users_table" name="users_table" class="portlet-body table-responsive">
											<div><?= $data['paginate'] ?></div>
											<table class="table table-striped table-hover margin-top-20">
												<thead>
													<tr>
														<th>
															<div class="form-group form-md-checkboxes" style="margin: 0 auto;width: 20px;padding-top: 0;">
																<div class="md-checkbox-list" style="margin: 2px auto;">
																	<div class="md-checkbox">
																		<input id="select_all" type="checkbox" class="md-check item-checkbox">
																		<label for="select_all"><span></span><span class="check"></span><span class="box"></span></label>
																	</div>
																</div>
															</div>
														</th>
														<th>
															<a href="<?= $_SESSION['Users']['nav']['navigation'] ?>&s=users_id">ID
																<?= $_SESSION['Users']['nav']['sort'] == 'users_id' ? $_SESSION['Users']['nav']['icon'] : $_SESSION['Users']['nav']['icon_default'] ?>
															</a>
														</th>
														<th>
															<a href="<?= $_SESSION['Users']['nav']['navigation'] ?>&s=users_name">Name
																<?= $_SESSION['Users']['nav']['sort'] == 'users_name' ? $_SESSION['Users']['nav']['icon'] : $_SESSION['Users']['nav']['icon_default'] ?>
															</a>
														</th>
                                                        <th>
                                                            <a href="<?= $_SESSION['Users']['nav']['navigation'] ?>&s=users_username">Username
                                                                <?= $_SESSION['Users']['nav']['sort'] == 'users_username' ? $_SESSION['Users']['nav']['icon'] : $_SESSION['Users']['nav']['icon_default'] ?>
                                                            </a>
                                                        </th>
														<th>
															<a href="<?= $_SESSION['Users']['nav']['navigation'] ?>&s=users_active">Is Active
																<?= $_SESSION['Users']['nav']['sort'] == 'users_active' ? $_SESSION['Users']['nav']['icon'] : $_SESSION['Users']['nav']['icon_default'] ?>
															</a>
														</th>
														<th>
															<a href="<?= $_SESSION['Users']['nav']['navigation'] ?>&s=users_backend">In Backend
																<?= $_SESSION['Users']['nav']['sort'] == 'users_backend' ? $_SESSION['Users']['nav']['icon'] : $_SESSION['Users']['nav']['icon_default'] ?>
															</a>
														</th>
													</tr>
												</thead>
												<tbody>
													<?php if(!empty($data['list'])) : ?>
														<?php foreach ($data['list'] as $user) : ?>
															<tr>
																<td>
																	<div class="form-group form-md-checkboxes" style="margin: 0 auto;width: 20px;padding-top: 0;">
																		<div class="md-checkbox-list" style="margin: 2px auto;">
																			<div class="md-checkbox">
																				<input name="user_checkbox[]" value="<?= $user->id() ?>" id="<?= $user->id() ?>" type="checkbox" class="md-check item-checkbox">
																				<label for="<?= $user->id() ?>"><span></span><span class="check"></span><span class="box"></span></label>
																			</div>
																		</div>
																	</div>
																</td>
																<td><?= $user->id() ?></td>
																<td>
																	<a href="<?= DOMAIN ?>/panel/users/edit-user?id=<?= $user->id() ?>">
																		<?= $user->name().'&nbsp'.$user->last_name() ?>
																	</a>
																</td>
                                                                <td><?= $user->username() ?></td>
																<td><i class="fa fa-<?= ($user->is_enabled() == 1) ? 'check' : 'times'; ?> font-<?= ($user->is_enabled() == 1) ? 'green-jungle' : 'red-thunderbird'; ?> font-lg"></i></td>
																<td><i class="fa fa-<?= ($user->in_backend() == 1) ? 'check' : 'times'; ?> font-<?= ($user->in_backend() == 1) ? 'green-jungle' : 'red-thunderbird'; ?> font-lg"></i></td>
															</tr>
														<?php endforeach; ?>
													<?php endif; ?>
												</tbody>
											</table>
											<div><?= $data['paginate'] ?></div>
											<div class="margin-top-20">Total rows: <?= $data['total_rows'] ?></div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- END CONTENT BODY -->
			</div>
			<!-- END CONTENT -->
			<!-- BEGIN QUICK SIDEBAR -->
			<?php require_once DIR . '/src/Views/Backend/inc/quick_sidebar.v.php' ?>
			<!-- END QUICK SIDEBAR -->
		</div>
		<!-- END CONTAINER -->
		<!-- BEGIN FOOTER -->
		<div class="page-footer">
			<div class="page-footer-inner"> <?= date("Y"); ?> &copy; <?= SITENAME ?>
				<div class="scroll-to-top">
					<i class="icon-arrow-up"></i>
				</div>
			</div>
			<!-- END FOOTER -->

			<?php require_once DIR.'/src/Views/Backend/inc/global_js.php' ?>

			<!-- BEGIN PAGE LEVEL SCRIPTS -->
			<script src="<?= DOMAIN ?>/theme/admin/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
			<script src="<?= DOMAIN ?>/theme/admin/assets/pages/js/users.js" type="text/javascript"></script>
			<!-- END PAGE LEVEL SCRIPTS -->

	</body>

</html>