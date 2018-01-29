<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title><?= SITENAME ?> | Users</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1" name="viewport" />
		<meta content="<?= SITENAME ?> Dashboard" name="description" />
		<meta content="" name="author" />
	</head>
	<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-fixed page-md">
    <?php if(isset($data['cache_message']) && !empty($data['cache_message'])) : ?>
        <div><?= $data['cache_message'] ?></div>
    <?php endif; ?>
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
                        <td><?= $user->in_backend() == 1 ? 'YES' : 'NO' ?></td>
                        <td><?= $user->is_enabled() == 1 ? 'YES' : 'NO' ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
	</body>
</html>