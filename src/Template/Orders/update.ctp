<!-- Main content -->
<div class="container-fluid">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Thong tin san pham</h3>
        </div>
        <div class="box-body">
            <div class="col-md-6 order_wrapper">
                <div class="search_wrapper">
                    <!--                    <div class="form-group">
                                            <select id="cateList" class="form-control">
                                                <option value="">Tất cả danh mục</option>
                                                <option value="1">aa</option>
                                                <option value="2">bb</option>
                                                <option value="3">cc</option>
                                            </select>
                                        </div>-->
                    <input id="search_product_name" class="form-control" value="" placeholder="Nhập tên sản phẩm cần tìm"/>
                </div>
                <div class="product_wrapper">
                    <?php for ($i = 1; $i <= 20; $i++): ?>
                        <div data-cate-id="<?php echo $i; ?>" 
                             data-id="<?php echo $i; ?>" 
                             data-name="<?php echo strtolower('San pham ' . $i); ?>"
                             data-price="<?php echo $i; ?>23456" class="col-xs-6 col-md-4 product_detail">
                            <img src="<?php echo $BASE_URL; ?>/img/sp.jpg" alt=""/>
                            <h4 class="product_name">San pham <?php echo $i; ?></h4>
                            <p>123.456</p>
                        </div>
                    <?php endfor; ?>
                </div>

            </div>
            <div class="col-md-6 order_wrapper">
                <div class="cart_wrapper">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="45%"><?php echo __('LABEL_PRODUCT'); ?></th>
                                <th width="15%"><?php echo __('LABEL_QTY'); ?></th>
                                <th width="20%"><?php echo __('LABEL_PRICE'); ?></th>
                                <th width="20%"><?php echo __('LABEL_CART_SUB_TOTAL'); ?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="cart_content"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 20px;">
        <div class="col-sm-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thong tin don hang</h3>
                    <button class="btn btn-primary pull-right" id="add_new_customer" title="Them moi khach hang">+</button>
                </div>
                <div class="box-body">
                    <div class="customer_search form-group">
                        <input class="form-control" id="customer_input" placeholder="Nhap ten khach hang hoac so dien thoai" value=""/>
                        <ul class="customer_search_result">
                            <?php for ($i = 0; $i < 10; $i++): ?>
                                <li class="customer_search_item" data-name="name-<?php echo $i; ?>" data-address="address-<?php echo $i; ?>" data-tel="tel-<?php echo $i; ?>" data-value="a-<?php echo $i; ?>" data-id="<?php echo $i; ?>">a-<?php echo $i; ?></li>
                            <?php endfor; ?>
                            <li class="customer_search_no_item">Khong co tim thay</li>
                        </ul>
                    </div>
                    <div class="customer_info">
                        <div class="form-group">
                            <label><?php echo __('LABEL_FULL_NAME');?></label>
                            <input class="form-control customer_info_input" placeholder="Ho ten..." id="customer_name" value="" disabled="disabled"/>
                        </div>
                        <div class="form-group">
                            <label><?php echo __('LABEL_TEL');?></label>
                            <input class="form-control customer_info_input" placeholder="So dien thoai..." id="customer_tel" value="" disabled="disabled"/>
                        </div>
                        <div class="form-group">
                            <label>Dia chi</label>
                            <input class="form-control customer_info_input" placeholder="Dia chi..." id="customer_address" value="" disabled="disabled"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Ghi chu</label>
                        <textarea class="form-control" rows="3" id="order_note" placeholder="Ghi chu..."></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Thong tin thanh toan</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th style="width:40%">Hinh thuc:</th>
                                    <td>
                                        <div class="form-group">
                                            <label class="radio-inline">
                                                <input name="rdoPopup" value="1" checked="" type="radio">Tien mat
                                            </label>
                                            <label class="radio-inline">
                                                <input name="rdoPopup" value="2" type="radio">Chuyen khoan
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Số lượng:</th>
                                    <td class="order_qty">0</td>
                                </tr>
                                <tr>
                                    <th>Tổng tiền</th>
                                    <td class="order_total">0</td>
                                </tr>
                                <tr>
                                    <th>Đã thanh toán:</th>
                                    <td><input type="text" class="form-control" value=""/></td>
                                </tr>
                                <tr>
                                    <th>Còn nợ:</th>
                                    <td class="order_binding">0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <div class="btn btn-primary pull-right">Luu hoa don</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.content -->
<div class="clearfix"></div>
