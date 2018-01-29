<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8" />
		<title><?= SITENAME ?> | Add User</title>
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
    <form id="roles_form" role="form" action="<?= DOMAIN ?>/panel/users/insert-user" method="POST" class="tab-content" enctype="multipart/form-data">
        <input type="hidden" name="csrf_name" value="<?php echo $csrf_name; ?>">
        <input type="hidden" name="csrf_value" value="<?php echo $csrf_value; ?>">
        <input type="hidden" id="selected_permissions" name="selected_permissions" value="" />

        <div>
            <div class="row">
                <div class="col-xs-6 col-sm-3 col-lg-3">
                    <div class="form-group">
                        <label class="control-label">Username</label>
                        <input type="text" name="user_name" value="<?= isset($_SESSION['Users']['insert_user']['user_name']) ? $_SESSION['Users']['insert_user']['user_name'] : '' ?>" placeholder="Username" class="form-control" />
                    </div>
                </div>

                <div class="col-xs-6 col-sm-3 col-lg-3">
                    <div class="form-group">
                        <label class="control-label">Email</label>
                        <input type="text" name="email" value="<?= isset($_SESSION['Users']['insert_user']['email']) ? $_SESSION['Users']['insert_user']['email'] : '' ?>" placeholder="Email" class="form-control" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6 col-sm-3 col-lg-3">
                    <div class="form-group">
                        <label class="control-label">Name</label>
                        <input type="text" name="name" value="<?= isset($_SESSION['Users']['insert_user']['name']) ? $_SESSION['Users']['insert_user']['name'] : '' ?>" placeholder="Name" class="form-control" />
                    </div>
                </div>

                <div class="col-xs-6 col-sm-3 col-lg-3">
                    <div class="form-group">
                        <label class="control-label">Last Name</label>
                        <input type="text" name="last_name" value="<?= isset($_SESSION['Users']['insert_user']['last_name']) ? $_SESSION['Users']['insert_user']['last_name'] : '' ?>" placeholder="Last Name" class="form-control" />
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
                        <input id="in_backend" name="in_backend" type="checkbox" class="make-switch" data-size="normal" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger"
                            <?= isset($_SESSION['Users']['insert_user']['in_backend']) && $_SESSION['Users']['insert_user']['in_backend'] == 1 ? 'checked' : '' ?>>
                    </div>
                </div>

                <div class="col-xs-6 col-sm-3 col-lg-3">
                    <div class="form-group">
                        <label class="" for="is_enabled">Active</label><p />
                        <input id="is_enabled" name="is_enabled" type="checkbox" class="make-switch" data-size="normal" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger"
                            <?= isset($_SESSION['Users']['insert_user']['is_enabled']) && $_SESSION['Users']['insert_user']['is_enabled'] == 1 ? 'checked' : '' ?>>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" id="submit" class="btn green">Save</button>
        <a href="<?= DOMAIN.'/panel/users' ?>" class="btn default">Go back</a>
    </form>

	</body>

</html>