<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8" />
		<title><?= SITENAME ?> | Edit user</title>
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
    <form id="roles_form" role="form" action="<?= DOMAIN ?>/panel/users/update-user" method="POST" class="tab-content" enctype="multipart/form-data">
        <input type="hidden" name="csrf_name" value="<?php echo $csrf_name; ?>">
        <input type="hidden" name="csrf_value" value="<?php echo $csrf_value; ?>">
        <input type="hidden" name="id" value="<?= $data['user']->id() ?>" />

        <div>
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
                        <input id="in_backend" name="in_backend" type="checkbox" <?= $data['user']->in_backend() == 1 ? 'checked' : '' ?>>
                    </div>
                </div>

                <div class="col-xs-6 col-sm-3 col-lg-3">
                    <div class="form-group">
                        <label class="" for="is_enabled">Active</label><p />
                        <input id="is_enabled" name="is_enabled" type="checkbox"  <?= $data['user']->is_enabled() == 1 ? 'checked' : '' ?>>
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

	</body>

</html>