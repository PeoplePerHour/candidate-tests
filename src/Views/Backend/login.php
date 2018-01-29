<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?= SITENAME ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Login page for the administration of <?= SITENAME ?>" name="description" />
        <meta content="Giannis Toutoulis" name="author" />
    </head>
    <body class=" login">
        <form class="login-form" action="<?= DOMAIN ?>/panel/login" method="post">
            <input type="hidden" name="csrf_name" value="<?php echo $csrf_name; ?>">
            <input type="hidden" name="csrf_value" value="<?php echo $csrf_value; ?>">
            <?php if(!empty($messages)) : ?>
                <?php foreach($messages as $type => $msgs) : ?>
                    <?php foreach($msgs as $msg) : ?>
                        <span> <?= $msg ?> </span>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            <div class="alert alert-info">
                <span> Username:  <strong>admin</strong></span> <br />
                <span> Password: <strong>admin</strong> </span>
            </div>
            <div class="form-group">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9">Username</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" /> </div>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Password</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" /> </div>
            <div class="form-actions">
                <button type="submit" class="btn red btn-block uppercase">Login</button>
            </div>
        </form>
    </body>
</html>