/**
 * Main Javascript process
 */

$(document).ajaxStart(function () {
    Pace.restart();
});

$(document).on('submit', '.box-search form, .box-update form', function () {
    Pace.restart();
});

$(document).ready(function ($) {
    // Disable button toggle
    $('.toggle').show();
    $('.toggle-event').change(function () {
        toggleChange(this);
    });

    // Buttons action
    $(".btn-disable").click(function () {
        return disableEnableMulti('disable');
    });
    $(".btn-enable").click(function () {
        return disableEnableMulti('enable');
    });
    $(".btn-addnew").click(function () {
        if (controller == 'orders') {
            location.href = baseUrl + '/' + controller + '/add';
        } else {
            location.href = baseUrl + '/' + controller + '/update';
        }
        return false;
    });
    $(".btn-order-sell").click(function () {
        location.href = baseUrl + '/' + controller + '/add?type=1';
        return false;
    });
    $(".btn-order-buy").click(function () {
        location.href = baseUrl + '/' + controller + '/add?type=2';
        return false;
    });

    // Order
    init_order();
});

/**
 * Update multi (enable/disable)
 * @param {string} type
 * @returns {Boolean}
 */
function disableEnableMulti(type) {
    var items = getItemsChecked('items[]', ',');
    if (items == '') {
        showAlertModal('Vui lòng chọn');
        return false;
    }
    $("#action").val(type);
    return true;
}

/**
 * Get list item checked
 * @param {type} strItemName
 * @param {type} sep
 * @returns {String}
 */
function getItemsChecked(strItemName, sep) {
    var x = document.getElementsByName(strItemName);
    var p = "";
    for (var i = 0; i < x.length; i++) {
        if (x[i].checked) {
            p += x[i].value + sep;
        }
    }
    var result = (p != '' ? p.substr(0, p.length - 1) : '');
    return result;
}

/**
 * Check all item in data search result
 */
function checkAll(strItemName, value) {
    var x = document.getElementsByName(strItemName);
    for (var i = 0; i < x.length; i++) {
        if (value == 1 && !x[i].disabled) {
            if (!x[i].checked) {
                x[i].checked = 'checked';
            }
        } else {
            if (x[i].checked) {
                x[i].checked = '';
            }
        }
    }
}

/**
 * On change toggle
 * 
 * @param {object} item
 */
function toggleChange(item) {
    var revertClassFlg = 'reverted';
    if ($(item).hasClass(revertClassFlg)) {
        return false;
    }

    // Init
    var _this = $(item);
    var id = _this.val();
    var data_field = _this.attr('data-field');
    var data_controller = controller;
    if (data_controller == 'postcates' || data_controller == 'productcates') {
        data_controller = 'cates';
    }
    var classList = _this.attr('class').split(/\s+/);//get controller in case there are multi-controllers on a screen
    if (classList.length == 2) {
        data_controller = classList[1];
    }

    // Select action
    if (data_field == 'disable') {
        var disable = $(item).prop('checked') ? 1 : 0;
        var data = {
            controller: data_controller,
            action: action,
            id: id,
            disable: disable
        };
        $.ajax({
            type: "POST",
            url: baseUrl + '/ajax/disable',
            data: data,
            success: function (response) {
                if (response) {
                    // Revert checkbox
                    $(item).addClass(revertClassFlg);
                    $(item).prop('checked', disable == 0).change();
                    $(item).removeClass(revertClassFlg);

                    // Show error
                    showAlertModal(response);
                }
            },
            complete: function () {
                location.reload();
            }
        });
    }

    return false;
}

/**
 * Show alert using bootstrap modal
 * @param {string} message
 */
function showAlertModal(message) {
    $('#modal_alert_body').html(message);
    $('#modal_alert').modal('show');
}

/**
 * Go back
 */
function back(redirect) {
    if (typeof redirect !== 'undefined' && redirect !== '') {
        location.href = redirect;
    } else if (referer.indexOf(url) === -1) {
        location.href = referer;
    } else {
        location.href = '/' + controller;
    }
    return false;
}

/**
 * Check input file is Image
 * @param {Object} input
 * @returns {Boolean}
 */
function is_image_type(input) {
    var image_types = ['image/jpg', 'image/jpeg', 'image/png'];
    return $.inArray(input['type'], image_types) >= 0;
}

/*
 * only value array
 * @param {type} value
 * @param {type} index
 * @param {type} self
 * @returns {Boolean}
 */
function onlyUnique(value, index, self) {
    return self.indexOf(value) === index;
}

/*
 * order functions
 */
function init_order() {
    var product = $('.product_detail');
    var cartContent = $('#cart_content');
    var delBtn = $('.c_item .btn-danger');
    var pItem = $('.product_detail');

    $('#cateList').on('change', function () {
        var value = $(this).val();
        if (value == '') {
            pItem.show();
        } else {
            pItem.hide();
            $('.product_wrapper').find("[data-cate-id='" + value + "']").show();
        }
    });

    $('#search_product_name').on('keyup', function () {
        var value = $(this).val().toLowerCase();
        if (value == '') {
            pItem.show();
        } else {
            pItem.hide();
            $('.product_wrapper').find("[data-search*='" + value + "']").show();
        }
    });

    product.unbind('click').bind('click', function () {
        var id = $(this).attr('data-id');
        var name = $(this).attr('data-name');
        var price = $(this).attr('data-price');
        var existItem = $("#cart_content").find("[data-p-id='" + id + "']");
        if (existItem.length > 0) {
            var qty = parseInt(existItem.find('.input_number').val());
            existItem.find('.input_number').val(qty + 1);
            existItem.find('.item_total_price').html(commaSeparateNumber(price * (qty + 1)));
        } else {
            var item = item_render(id, name, price);
            cartContent.prepend(item);
        }
        order_calculate();

        $('.input_number').unbind('change').bind('change', function () {
            var value = parseInt($(this).val());
            var parent = $(this).parents('.c_item');
            var price = parseInt(parent.find('.item_price').html().replace(/,/g, ''));
            parent.find('.item_total_price').html(commaSeparateNumber(price * value));
            order_calculate();
        });
    });

    delBtn.unbind('click').bind('click', function () {
        $(this).parents('.c_item').remove();
    });

    select_customer();
    
    order_pay();

    order_save();
    
    order_calculate();
}

/*
 * Render item
 */
function item_render(id, name, price) {
    price = commaSeparateNumber(price);
    return '<tr class="c_item" data-p-id="' + id + '"><td>' + name + '</td><td><input data-p-id="'+id+'" data-p-price="'+price+'" type="number" class="form-control input_number o_input_product" value="1" min="1"/></td><td class="item_price">' + price + '</td><td class="item_total_price">' + price + '</td><td><button onclick="remove_item($(this))" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></button></td></tr>';
}

/*
 * Remove item
 */
function remove_item(btn) {
    btn.parents('.c_item').remove();
    order_calculate();
}

/*
 * Select customer
 */
function select_customer() {
    var c_wrapper = $('.customer_search_result');
    var input = $('#customer_input');
    var item = $('.customer_search_result .customer_search_item');
    var emptyItem = $('.customer_search_result .customer_search_no_item');
    var c_info = $('.customer_info');
    var input_name = $('#o_customer_name');
    var input_tel = $('#o_customer_tel');
    var input_address = $('#o_customer_address');
    var input_id = $('#o_customer_id');
    var c_input = $('.customer_info_input');
    var btn_add_new_customer = $('#add_new_customer');

    input.on('keyup', function () {
        show_customer();
    });
    input.on('click', function () {
        show_customer();
    });
    item.unbind('click').bind('click', function () {
        var address = $(this).attr('data-address');
        var tel = $(this).attr('data-tel');
        var name = $(this).attr('data-name');
        var id = $(this).attr('data-id');

        input.val('');
        input_id.val(id);
        input_name.val(name);
        input_tel.val(tel);
        input_address.val(address);
        c_wrapper.hide();
        c_info.show();
    });

    btn_add_new_customer.on('click', function () {
        c_input.attr('disabled', false);
        c_input.val('');
        c_info.show();
    })

    /*
     * Show customer
     */
    function show_customer() {
        var value = input.val();
        c_input.attr('disabled', 'disabled');
        item.hide();
        emptyItem.hide();
        c_wrapper.fadeIn();
        if (value == '') {
            item.show();
            return false;
        } else {
            var results = $('.customer_search_result').find("[data-value*='" + value + "']");
            if (results.length > 0) {
                results.show();
            } else {
                emptyItem.show();
            }
        }
    }
}

/*
 * Order calculate
 */
function order_calculate() {
    var td_qtv = $('.order_qty');
    var td_total = $('.order_total');
    var qty = 0;
    var total = 0;
    var pay_total = $('#o_pay_total').val();
    $('.item_total_price').each(function () {
        var value = parseInt($(this).html().replace(/,/g, ''));
        total += value;
    });
    $('.input_number').each(function () {
        var value = parseInt($(this).val());
        qty += value;
    });

    td_total.html(commaSeparateNumber(total));
    td_qtv.html(qty);
    $('#o_total_price').val(total);
    $('.order_binding').html(commaSeparateNumber(total - pay_total));
    $('#o_pay_debt').val(total - pay_total);
}

/*
 * Order pay
 */
function order_pay() {
    var debt = $('.order_binding');
    var o_debt = $('#o_pay_debt');
    $('#o_pay_total').on('keyup', function(){
        var total = parseInt($('#o_total_price').val());
        var val = $(this).val();
//        if (val > total) {
//            val = total;
//            $(this).val(val);
//        }
        debt.html(commaSeparateNumber(total - val));
        o_debt.val(total - val);
    });
}

/*
 * Save order data
 */
function order_save() {
    $('#order_save').on('click', function () {
        var productData = [];
        $(".o_input_product").each(function( i ) {
            var pId = $(this).attr('data-p-id');
            var pPrice = $(this).attr('data-p-price').replace(/,/g, '');
            var qty = $(this).val();
            var tmp = {
                id: pId,
                price: pPrice,
                qty: qty
            };
            productData.push(tmp);
        });
        var data = {
            product_data: productData,
            customer_id: $('#o_customer_id').val(),
            sub_name: $('#o_customer_name').val(),
            sub_tel: $('#o_customer_tel').val(),
            sub_address: $('#o_customer_address').val(),
            payment_method: $('#o_payment_method').val(),
            ext_cost: 0,
            ship_cost: 0,
            total: $('#o_total_price').val(),
            pay_total: $('#o_pay_total').val(),
            pay_debt: $('#o_pay_debt').val(),
            note: $('#o_order_note').val(),
            id: $('#o_id').val(),
            type: $('#o_type').val()
        };
        $.ajax({
            type: "POST",
            url: baseUrl + '/ajax/orderadd',
            data: data,
            success: function (response) {
                if (response.status == 'OK') {
                    window.location.href = baseUrl + '/orders/detail/'+response.data;
                } else {
                    // Show error
                    showAlertModal('Error');
                }
            },
            error: function () {
                // Show error
                showAlertModal('Đã có lỗi xảy ra, vui lòng thử lại.');
            },
            complete: function () {
//                location.reload();
            }
        });
    });
}

$(document).on('click touchend', function (e) {
    // Check if click outside of search form
    var search_result = $('.customer_search_result');
    if (search_result.length > 0) {
        var customer_input = $('#customer_input');
        if (!customer_input.is(e.target) && !search_result.is(e.target) && search_result.has(e.target).length === 0) {
            search_result.hide();
        }
    }
});