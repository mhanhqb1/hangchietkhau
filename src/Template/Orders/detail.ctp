<!--<div class="pad margin no-print">
    <div class="callout callout-info" style="margin-bottom: 0!important;">
        <h4><i class="fa fa-info"></i> Note:</h4>
        This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
    </div>
</div>-->

<!-- Main content -->
<section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> LYONABEAUTY
                <small class="pull-right"><?php echo __('LABEL_CREATED');?>: <?php echo !empty($data['created']) ? date('Y-m-d', $data['created']) : '-';?></small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            From
            <address>
                <strong><?php echo !empty($AppUI['company']['name']) ? $AppUI['company']['name'] : ''; ?></strong><br>
                <?php echo !empty($AppUI['company']['address']) ? $AppUI['company']['address'] : ''; ?><br>
                Phone: <?php echo !empty($AppUI['company']['tel']) ? $AppUI['company']['tel'] : ''; ?><br>
                Email: <?php echo !empty($AppUI['company']['email']) ? $AppUI['company']['email'] : ''; ?>
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            To
            <address>
                <strong><?php echo $data['name']; ?></strong><br>
                <?php echo $data['address']; ?><br>
                Phone: <?php echo $data['phone']; ?><br>
                Email: <?php echo $data['email']; ?><br>
            </address>
        </div>
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th><?php echo __('LABEL_IMAGE');?></th>
                        <th><?php echo __('LABEL_PRODUCT');?></th>
                        <th><?php echo __('LABEL_QTY');?></th>
                        <th><?php echo __('LABEL_PRICE');?></th>
                        <th><?php echo __('LABEL_CART_SUB_TOTAL'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['detail'])): ?>
                    <?php $products = json_decode($data['detail'], true); ?>
                        <?php foreach ($products as $p): ?>
                            <tr>
                                <td><img src="<?php echo $p['image']; ?>" width="200"/></td>
                                <td><?php echo !empty($p['name']) ? $p['name'] : '-'; ?></td>
                                <td><?php echo $p['qty']; ?></td>
                                <td><?php echo number_format($p['price']); ?></td>
                                <td><?php echo number_format($p['price'] * $p['qty']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
            <p class="lead"><?php echo __('LABEL_NOTE');?>:</p>
            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                <?php echo !empty($data['note']) ? $data['note'] : ''; ?>
            </p>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
            <p class="lead"><?php echo __('LABEL_PAYMENT_INFO');?></p>

            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:50%"><?php echo __('LABEL_ORDER_TOTAL'); ?>:</th>
                        <td><?php echo number_format($data['total_price']); ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-xs-12">
<!--            <a href="#" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
            <a href="<?php echo $BASE_URL;?>/orders/add/<?php echo $data['id']; ?>" class="btn btn-primary pull-right" style="margin-right: 5px;">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo __('LABEL_ORDER_UPDATE');?>
            </a>-->
        </div>
    </div>
</section>
<!-- /.content -->
<div class="clearfix"></div>