<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?php echo !empty($data['order_count']) ? $data['order_count'] : 0;?></h3>

                <p><?php echo __('LABEL_ORDER');?></p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="<?php echo $BASE_URL;?>/orders" class="small-box-footer"><?php echo __('LABEL_MORE_INFO');?> <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3><?php echo !empty($data['product_count']) ? $data['product_count'] : 0;?></h3>

                <p><?php echo __('LABEL_PRODUCT');?></p>
            </div>
            <div class="icon">
                <i class="ion-cube"></i>
            </div>
            <a href="<?php echo $BASE_URL;?>/products" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?php echo !empty($data['post_count']) ? $data['post_count'] : 0;?></h3>

                <p><?php echo __('Bài viết');?></p>
            </div>
            <div class="icon">
                <i class="ion ion-android-contacts"></i>
            </div>
            <a href="<?php echo $BASE_URL;?>/posts" class="small-box-footer"><?php echo __('LABEL_MORE_INFO');?> <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?php echo !empty($data['contact_count']) ? $data['contact_count'] : 0;?></h3>

                <p><?php echo __('Liên hệ');?></p>
            </div>
            <div class="icon">
                <i class="ion-android-people"></i>
            </div>
            <a href="<?php echo $BASE_URL;?>/contacts" class="small-box-footer"><?php echo __('LABEL_MORE_INFO');?> <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<!-- /.row -->
