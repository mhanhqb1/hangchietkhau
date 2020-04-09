<header class="main-header">
    <!-- Logo -->
<!--    <a href="<?php echo $BASE_URL;?>" class="logo">
        <span class="logo-lg"><b>VNS</b>HOP</span>
    </a>-->
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo $AppUI['avatar']; ?>" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?php echo $AppUI['display_name']; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?php echo $AppUI['avatar']; ?>" class="img-circle" alt="User Image">

                            <p>
                                <?php echo $AppUI['display_name']; ?>
                                <small><?php !empty($AppUI['created']) ? date('Y-m-d', $AppUI['created']) : '' ;?></small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?php echo $BASE_URL; ?>/admins/updateprofile" class="btn btn-default btn-flat"><?php echo __('LABEL_UPDATE_PROFILE'); ?></a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo $BASE_URL; ?>/login/logout" class="btn btn-default btn-flat"><?php echo __('LABEL_SIGN_OUT'); ?></a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
