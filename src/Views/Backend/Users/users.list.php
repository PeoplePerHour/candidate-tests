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
	<body>
    <?php if(!empty($messages)) : ?>
        <?php foreach($messages as $type => $msgs) : ?>
            <?php foreach($msgs as $msg) : ?>
                <span><strong><?= $msg ?></strong></span>
            <?php endforeach; ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <form name="filters">
        <div>
            <input type="text" placeholder="Search Username..." value="<?= isset($_SESSION['Users']['nav']['filter_user']) ? $_SESSION['Users']['nav']['filter_user'] : '' ?>" name="filter_user">
        </div>

        <div>
            <select name="filter_active">
                <option value="">Select Status</option>
                <option value="1" <?= isset($_SESSION['Users']['nav']['filter_active']) && $_SESSION['Users']['nav']['filter_active'] == 1   ? 'selected' : ''?>>Active</option>
                <option value="0" <?= isset($_SESSION['Users']['nav']['filter_active']) && $_SESSION['Users']['nav']['filter_active'] == '0' ? 'selected' : ''?>>Not Active</option>
            </select>
        </div>
        <button id="submit_filters" type="submit" >Submit filters</button>
    </form>
    <form id="users_list_form" name="users_list_form" method="POST" action='<?= DOMAIN ?>/panel/users/delete-user'>
        <input type="hidden" name="csrf_name" value="<?php echo $csrf_name; ?>">
        <input type="hidden" name="csrf_value" value="<?php echo $csrf_value; ?>">
        <a href="<?= DOMAIN ?>/panel/users/add-user">Add new user</a>
        <button id="delete_all" type="submit" >Delete user</button>
        <a href="<?= DOMAIN ?>/panel/clear-cache">Clear cache</a>
        <div id="users_table" name="users_table" class="portlet-body table-responsive">
            <div><?= $data['paginate'] ?></div>
            <table class="table table-striped table-hover margin-top-20">
                <thead>
                <tr>
                    <th></th>
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
                            <th>
                                <input name="user_checkbox[]" value="<?= $user->id() ?>" id="<?= $user->id() ?>" type="checkbox" class="md-check item-checkbox">
                            </th>
                            <td><?= $user->id() ?></td>
                            <td>
                                <a href="<?= DOMAIN ?>/panel/users/edit-user?id=<?= $user->id() ?>">
                                    <?= $user->name().'&nbsp'.$user->last_name() ?>
                                </a>
                            </td>
                            <td><?= $user->username() ?></td>
                            <td><?= $user->is_enabled() == 1 ? 'YES' : 'NO' ?></td>
                            <td><?= $user->in_backend() == 1 ? 'YES' : 'NO' ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
            <div><?= $data['paginate'] ?></div>
            <div class="margin-top-20">Total rows: <?= $data['total_rows'] ?></div>
        </div>
    </form>

	</body>

</html>