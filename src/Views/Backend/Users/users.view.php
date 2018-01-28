<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<!-- BEGIN HEAD -->

	<head>
		<meta charset="utf-8" />
		<title><?= SITENAME ?> | Edit user</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1" name="viewport" />
		<meta content="<?= SITENAME ?> Dashboard" name="description" />
		<meta content="" name="author" />
		<?php require_once DIR.'/src/Views/Backend/inc/global_css.php' ?>
		<!-- BEGIN PAGE LEVEL PLUGINS -->
		<link href="<?= DOMAIN ?>/theme/admin/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
		<link href="<?= DOMAIN ?>/theme/admin/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="<?= DOMAIN ?>/theme/admin/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= DOMAIN ?>/theme/admin/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= DOMAIN ?>/theme/admin/assets/global/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" />
		<link href="<?= DOMAIN ?>/theme/admin/assets/global/plugins/jstree/dist/themes/default/style.min.css" rel="stylesheet" type="text/css" />
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
					<h1 class="page-title"> Edit user
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
								<a href="<?= DOMAIN ?>/panel/users"><span>Users</span></a>
								<i class="fa fa-angle-right"></i>
								<i class="fa icon-pencil"></i>
								<span>Edit user</span>
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
							<div class="portlet light ">
								<div class="portlet-title">
									<div class="caption">
										<span class="caption-subject font-red-sunglo bold"><?= $data['user']->name() ?>&nbsp<?= $data['user']->last_name() ?> [<?= $data['user']->username() ?>]</span>
									</div>
								</div>
								<div class="portlet-body form">
									<form id="roles_form" role="form" action="<?= DOMAIN ?>/panel/users/update-user" method="POST" class="tab-content" enctype="multipart/form-data">
										<input type="hidden" name="csrf_name" value="<?php echo $csrf_name; ?>">
										<input type="hidden" name="csrf_value" value="<?php echo $csrf_value; ?>">
										<input type="hidden" id="selected_permissions" name="selected_permissions" value="" />
                                        <input type="hidden" name="id" value="<?= $data['user']->id() ?>" />

										<div class="tabbable-line tabbable-full-width">
											<ul class="nav nav-tabs">
												<li class="active">
													<a href="#tab1" data-toggle="tab"> Main Info </a>
												</li>
												<li class="">
													<a href="#tab2" data-toggle="tab"> Additional Info </a>
												</li>
											</ul>
											<div class="tab-content">
												<div class="tab-pane active" id="tab1">
													<div class="row">
														<div class="col-xs-6 col-sm-3 col-lg-3">
															<div class="form-group">
																<label class="control-label">Username</label>
																<input type="text" name="user_name" value="<?= $data['user']->username() ?>" placeholder="Username" class="form-control" />
															</div>
														</div>

														<div class="col-xs-6 col-sm-3 col-lg-3">
															<div class="form-group">
																<label class="control-label">Email</label>
																<input type="text" name="email" value="<?= $data['user']->email() ?>" placeholder="Email" class="form-control" />
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-6 col-sm-3 col-lg-3">
															<div class="form-group">
																<label class="control-label">Name</label>
																<input type="text" name="name" value="<?= $data['user']->name() ?>" placeholder="Name" class="form-control" />
															</div>
														</div>

														<div class="col-xs-6 col-sm-3 col-lg-3">
															<div class="form-group">
																<label class="control-label">Last Name</label>
																<input type="text" name="last_name" value="<?= $data['user']->last_name() ?>" placeholder="Last Name" class="form-control" />
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-6 col-sm-3 col-lg-3">
															<div class="form-group">
																<label class="control-label">Password</label>
																<input type="password" name="password" value="" placeholder="Password" class="form-control" />
															</div>
														</div>

														<div class="col-xs-6 col-sm-3 col-lg-3">
															<div class="form-group">
																<label class="control-label">Repeat Password</label>
																<input type="password" name="repeat_password" value="" placeholder="Password" class="form-control" />
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-6 col-sm-3 col-lg-3">
															<div class="form-group">
																<label class="" for="in_backend">In Backend</label><p />
																<input id="in_backend" name="in_backend" type="checkbox" class="make-switch" data-size="normal" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" <?= $data['user']->in_backend() == 1 ? 'checked' : '' ?>>
															</div>
														</div>

														<div class="col-xs-6 col-sm-3 col-lg-3">
															<div class="form-group">
																<label class="" for="is_enabled">Active</label><p />
																<input id="is_enabled" name="is_enabled" type="checkbox" class="make-switch" data-size="normal" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" <?= $data['user']->is_enabled() == 1 ? 'checked' : '' ?>>
															</div>
														</div>
													</div>
												</div>

												<div class="tab-pane" id="tab2">
													<div class="row">
														<div class="col-xs-6 col-sm-3 col-lg-3">
															<div class="form-group">
																<label class="control-label">Gender</label>
																<select id="gender" class="form-control" name="gender">
																	<option value="0" <?= $data['user']->gender() == 0 ? 'selected' : '' ?>>Select Gender</option>
																	<option value="1" <?= $data['user']->gender() == 1 ? 'selected' : '' ?>>Male</option>
																	<option value="2" <?= $data['user']->gender() == 2 ? 'selected' : '' ?>>Female</option>
																</select>
															</div>
														</div>

														<div class="col-xs-6 col-sm-3 col-lg-3">
															<div class="form-group">
																<label class="">Location</label>
																<input name="location" type="text" class="form-control" value="<?= $data['user']->location() ?>" />
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-6 col-sm-3 col-lg-2">
															<div class="form-group">
																<label class="control-label" for="birthdate">Birthdate</label>
																<?php

																	if(!empty($data['user']->birthdate()))
																	{
																		$birthdate = \DateTime::createFromFormat('Y-m-d', $data['user']->birthdate());
																		$birthdate = $birthdate->format('d-m-Y');
																	}
																	else
																		$birthdate = $data['user']->birthdate();
																?>
																<div class="input-group input-date">
																	<input id="birthdate" name="birthdate" type="text" class="form-control form-control-inline"
																		   data-provide="datepicker" data-date-format="dd-mm-yyyy" value="<?= $birthdate ?>">
																</div>
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-6 col-sm-3 col-lg-2">
															<div class="form-group">
																<label class="control-label" for="description">Description</label>
																<textarea id="description" name="description" class="form-control" rows="5" cols="20"><?= $data['user']->description() ?></textarea>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>


										<!-- FORM ACTIONS -->
										<div class="form-actions">
											<div class="row">
												<div class="col-md-4">
													<button type="submit" id="submit" class="btn green">Save</button>
													<a href="<?= DOMAIN.'/panel/users' ?>" class="btn default">Go back</a>
												</div>
											</div>
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
			<script src="<?= DOMAIN ?>/theme/admin/assets/global/plugins/jstree/dist/jstree.min.js" type="text/javascript"></script>
			<script src="<?= DOMAIN ?>/theme/admin/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
			<script src="<?= DOMAIN ?>/theme/admin/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
			<script src="<?= DOMAIN ?>/theme/admin/assets/pages/js/users.js" type="text/javascript"></script>
			<!-- END PAGE LEVEL SCRIPTS -->

	</body>

</html>