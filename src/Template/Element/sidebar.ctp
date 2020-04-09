<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo $AppUI['avatar']; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $AppUI['display_name']; ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="<?php if (in_array($controller, array('top')) && $action == 'index') echo ' active ' ?>">
                <a href="<?php echo $BASE_URL; ?>">
                    <i class="fa fa-dashboard"></i> <span><?php echo __('LABEL_DASHBOARD'); ?></span>
                </a>
            </li>
            
            <li class="<?php if (in_array($controller, array('orders'))) echo ' active ' ?>">
                <a href="<?php echo $BASE_URL; ?>/orders">
                    <i class="fa fa-cart-plus"></i>
                    <span><?php echo __('LABEL_ORDER_MANAGEMENT'); ?></span>
                </a>
            </li>
            
            <li class="treeview <?php if (in_array($controller, array('products', 'productcates'))) echo ' active ' ?>">
                <a href="#">
                    <i class="fa fa-product-hunt"></i> 
                    <span><span><?php echo __('LABEL_PRODUCT_MANAGEMENT'); ?></span></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if ($controller == 'products') echo ' active ' ?>">
                        <a href="<?php echo $BASE_URL; ?>/products">
                            <i class="fa fa-circle-o"></i> <?php echo __('LABEL_PRODUCT_LIST');?>
                        </a>
                    </li>
                    <li class="<?php if ($controller == 'productcates') echo ' active ' ?>">
                        <a href="<?php echo $BASE_URL; ?>/productcates">
                            <i class="fa fa-circle-o"></i> <?php echo __('LABEL_CATE');?>
                        </a>
                    </li>
                </ul>
            </li>
            
            <li class="treeview <?php if (in_array($controller, array('posts', 'postcates'))) echo ' active ' ?>">
                <a href="#">
                    <i class="fa fa-newspaper-o"></i> 
                    <span><span><?php echo __('LABEL_POST_MANAGEMENT'); ?></span></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if ($controller == 'posts') echo ' active ' ?>">
                        <a href="<?php echo $BASE_URL; ?>/posts">
                            <i class="fa fa-circle-o"></i> <?php echo __('LABEL_POST_LIST');?>
                        </a>
                    </li>
                    <li class="<?php if ($controller == 'postcates') echo ' active ' ?>">
                        <a href="<?php echo $BASE_URL; ?>/postcates">
                            <i class="fa fa-circle-o"></i> <?php echo __('LABEL_CATE');?>
                        </a>
                    </li>
                </ul>
            </li>
            
            <li class="<?php if (in_array($controller, array('banners'))) echo ' active ' ?>">
                <a href="<?php echo $BASE_URL; ?>/banners">
                    <i class="fa fa-image"></i>
                    <span><?php echo __('LABEL_BANNER_MANAGEMENT'); ?></span>
                </a>
            </li>
            
            <li class="<?php if (in_array($controller, array('contacts'))) echo ' active ' ?>">
                <a href="<?php echo $BASE_URL; ?>/contacts">
                    <i class="fa fa-users"></i>
                    <span><?php echo __('LABEL_CONTACT_MANAGEMENT'); ?></span>
                </a>
            </li>
            
<!--            <li class="<?php if (in_array($controller, array('customers'))) echo ' active ' ?>">
                <a href="<?php echo $BASE_URL; ?>/customers">
                    <i class="fa fa-user"></i>
                    <span><?php echo __('LABEL_CUSTOMER_MANAGEMENT'); ?></span>
                </a>
            </li>-->
            
            <li class="treeview <?php if (in_array($controller, array('admins', 'companies', 'about'))) echo ' active ' ?>">
                <a href="#">
                    <i class="fa fa-cogs"></i> 
                    <span><span><?php echo __('LABEL_SETTING_MANAGEMENT'); ?></span></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php if ($controller == 'admins' && in_array($action, array('updateprofile'))) echo ' active ' ?>">
                        <a href="<?php echo $BASE_URL; ?>/admins/updateprofile">
                            <i class="fa fa-circle-o"></i> <?php echo __('LABEL_UPDATE_PROFILE');?>
                        </a>
                    </li>
                    <li class="<?php if ($controller == 'companies') echo ' active ' ?>">
                        <a href="<?php echo $BASE_URL;?>/companies/update">
                            <i class="fa fa-circle-o"></i>
                            <span><?php echo __('LABEL_COMPANIES_MANAGEMENT'); ?></span>
                        </a>
                    </li>
                    <li class="<?php if ($controller == 'about') echo ' active ' ?>">
                        <a href="<?php echo $BASE_URL;?>/about/update">
                            <i class="fa fa-circle-o"></i>
                            <span><?php echo __('Giới thiệu cty'); ?></span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
