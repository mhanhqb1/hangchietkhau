<!DOCTYPE html>
<html lang="vi">
    <head>
        <title><?php echo!empty($title_for_layout) ? h($title_for_layout) : DEFAULT_SITE_TITLE ?></title>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        <link href="<?php echo $BASE_URL ?>/favicon.ico" type="image/x-icon" rel="icon"/>
        <link href="<?php echo $BASE_URL ?>/favicon.ico" type="image/x-icon" rel="shortcut icon"/>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo $BASE_URL ?>/css/bootstrap.min.css?<?php echo VERSION_DATE ?>"/>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" type="text/css" />
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo $BASE_URL ?>/adminlte/dist/css/AdminLTE.min.css?<?php echo VERSION_DATE ?>"/>
        <link rel="stylesheet" href="<?php echo $BASE_URL ?>/adminlte/dist/css/skins/skin-blue.min.css?<?php echo VERSION_DATE ?>"/>
        <link rel="stylesheet" href="<?php echo $BASE_URL ?>/adminlte/plugins/pace/pace.min.css"/>
        <link rel="stylesheet" href="<?php echo $BASE_URL ?>/css/bootstrap-toggle.min.css"/>
        <link rel="stylesheet" href="<?php echo $BASE_URL ?>/css/style.css?<?php echo VERSION_DATE ?>"/>

        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body id="container_<?php echo $controller . '_' . $action; ?>" class="skin-blue sidebar-mini">

        <div id="wrapper">
            <!-- Start Header -->
            <?php echo $this->element('header'); ?>
            <!-- End Header -->

            <!-- Start Sidebar -->
            <?php echo $this->element('sidebar'); ?>
            <!-- End Sidebar -->

            <div class="content-wrapper">
                <?php if (!empty($breadcrumb)) : ?>
                    <section class="content-header">
                        <?php echo $this->Breadcrumb->render($breadcrumb, $breadcrumbTitle); ?>
                    </section>
                <?php endif ?>
                
                <section class="content">
                    <?php echo $this->Flash->render() ?>
                    <?php echo $this->fetch('content'); ?>
                    <?php echo $this->element('popup'); ?>
                </section>
            </div>
            
            <!-- Start Footer -->
            <?php echo $this->element('footer'); ?>
            <!-- End Footer -->
        </div>

        <script type="text/javascript">
            var controller = '<?php echo $controller; ?>';
            var action = '<?php echo $action; ?>';
            var baseUrl = '<?php echo $BASE_URL; ?>';
            var referer = "<?php echo $referer; ?>";
            var url = "<?php echo $url; ?>";
        </script>

        <script type="text/javascript" src="<?php echo $BASE_URL ?>/js/jquery-2.1.3.min.js"></script>
        <script type="text/javascript" src="<?php echo $BASE_URL ?>/js/jquery-migrate-1.4.1.min.js"></script>
        <script type="text/javascript" src="<?php echo $BASE_URL ?>/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo $BASE_URL ?>/js/bootstrap-toggle.min.js"></script>
        <script type="text/javascript" src="<?php echo $BASE_URL ?>/adminlte/plugins/pace/pace.min.js"></script>
        <script type="text/javascript" src="<?php echo $BASE_URL ?>/adminlte/dist/js/adminlte.min.js"></script>
        <script type="text/javascript" src="<?php echo $BASE_URL ?>/js/functions.js?<?php echo VERSION_DATE ?>"></script>
        <script type="text/javascript" src="<?php echo $BASE_URL ?>/js/common.js?<?php echo VERSION_DATE ?>"></script>
    </body>
</html>

