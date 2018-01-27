<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title><?= SITENAME ?> | Dashboard</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="<?= SITENAME ?> Dashboard" name="description" />
    <meta content="" name="author" />
    <?php require_once 'inc/global_css.php' ?>
    <!-- BEGIN PAGE LEVEL PLUGINS -->
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
            <h1 class="page-title"> Dasboard
                <small></small>
            </h1>
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">
                <!-- BEGIN BREADCRUMBS -->
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa icon-home"></i>
                        <span>Dasboard</span>
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
                        <div class="row">
                            <div class="col-sm-6 col-md-3 col-lg-2 margin-top-10">
                                <a href="<?= DOMAIN ?>/panel/users" class="btn btn-block blue btn-outline">
                                    <i class="fa icon-users"></i>
                                    <div>Users</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
    <!-- BEGIN QUICK SIDEBAR -->
    <?php require_once 'inc/quick_sidebar.v.php' ?>
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

    <?php require_once 'inc/global_js.php' ?>

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="<?= DOMAIN ?>/theme/admin/assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
    <script src="<?= DOMAIN ?>/theme/admin/assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
    <script src="<?= DOMAIN ?>/theme/admin/assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="<?= DOMAIN ?>/theme/admin/assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
</div>
</body>

</html>