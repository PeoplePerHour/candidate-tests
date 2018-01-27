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
	</head>
	<!-- END HEAD -->
	<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-fixed page-md">
		<!-- BEGIN CONTAINER -->
		<div class="page-container" style="margin: 0">
			<!-- BEGIN CONTENT -->
			<div class="page-content-wrapper">
				<!-- BEGIN CONTENT BODY -->
				<div class="page-content" style="margin: 0; height: 100vh">
                    <?php if(isset($data['cache_message']) && !empty($data['cache_message'])) : ?>
                        <div class="alert alert-<?= $data['cache_message_type'] ?>">
                            <button class="close" data-close="alert"></button>
                            <span><strong><?= $data['cache_message'] ?></strong></span>
                        </div>
                    <?php endif; ?>
					<div class="row">
						<div class="col-md-12">
							<div class="table-scrollable">
								<div class="portlet light ">
                                    <a class="btn btn-transparent green btn-outline btn-circle btn-sm active" href="<?= DOMAIN ?>/panel" target="_blank">Access Backend</a>
                                    <div id="users_table" class="portlet-body table-responsive">
                                        <table class="table table-striped table-hover margin-top-20">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Username</th>
                                                    <th>In Backend</th>
                                                    <th>Is Active</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!empty($data['list'])) : ?>
                                                    <?php foreach ($data['list'] as $user) : ?>
                                                        <tr>
                                                            <td><?= $user->id() ?></td>
                                                            <td><?= $user->name().'&nbsp'.$user->last_name() ?></td>
                                                            <td><?= $user->username() ?></td>
                                                            <td><i class="fa fa-<?= ($user->in_backend() == 1) ? 'check' : 'times'; ?> font-<?= ($user->in_backend() == 1) ? 'green-jungle' : 'red-thunderbird'; ?> font-lg"></i></td>
                                                            <td><i class="fa fa-<?= ($user->is_enabled() == 1) ? 'check' : 'times'; ?> font-<?= ($user->is_enabled() == 1) ? 'green-jungle' : 'red-thunderbird'; ?> font-lg"></i></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- END CONTENT BODY -->
			</div>
			<!-- END CONTENT -->
		</div>
		<!-- END CONTAINER -->
	</body>
</html>