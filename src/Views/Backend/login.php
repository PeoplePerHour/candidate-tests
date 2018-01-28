<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title><?= SITENAME ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="Login page for the administration of <?= SITENAME ?>" name="description" />
    <meta content="Giannis Toutoulis" name="author" />
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="<?= DOMAIN ?>/theme/admin/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= DOMAIN ?>/theme/admin/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="<?= DOMAIN ?>/theme/admin/assets/pages/css/login-2.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <!-- END THEME LAYOUT STYLES -->
    <?php require_once 'inc/global_css.php' ?>
    <!-- END HEAD -->
<body class=" login">
<!-- BEGIN LOGO -->
<div class="logo">
    <h2 style="color: #ffffff;"><?= SITENAME ?> Administration</h2>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" action="<?= DOMAIN ?>/panel/login" method="post">
        <input type="hidden" name="csrf_name" value="<?php echo $csrf_name; ?>">
        <input type="hidden" name="csrf_value" value="<?php echo $csrf_value; ?>">
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span> Enter any username and password. </span>
        </div>
        <?php if(!empty($messages)) : ?>
            <?php foreach($messages as $type => $msgs) : ?>
                <?php foreach($msgs as $msg) : ?>
                    <div class="alert alert-<?= $type ?>">
                        <button class="close" data-close="alert"></button>
                        <span> <?= $msg ?> </span>
                    </div>
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
    <!-- END LOGIN FORM -->
</div>
<div class="copyright hide"> 2017 © <?= SITENAME ?>. </div>
<!-- END LOGIN -->
<!--[if lt IE 9]>
<script src="<?= DOMAIN ?>/theme/admin/assets/global/plugins/respond.min.js"></script>
<script src="<?= DOMAIN ?>/theme/admin/assets/global/plugins/excanvas.min.js"></script>
<script src="<?= DOMAIN ?>/theme/admin/assets/global/plugins/ie8.fix.min.js"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="<?= DOMAIN ?>/theme/admin/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?= DOMAIN ?>/theme/admin/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?= DOMAIN ?>/theme/admin/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="<?= DOMAIN ?>/theme/admin/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?= DOMAIN ?>/theme/admin/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?= DOMAIN ?>/theme/admin/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?= DOMAIN ?>/theme/admin/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?= DOMAIN ?>/theme/admin/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="<?= DOMAIN ?>/theme/admin/assets/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?= DOMAIN ?>/theme/admin/assets/pages/scripts/login.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<!-- END THEME LAYOUT SCRIPTS -->
</body>
</html>