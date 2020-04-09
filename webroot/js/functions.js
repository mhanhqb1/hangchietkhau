/* 
 * Common function
 */

/**
 * Check string is numeric character
 * @param {string} str
 * @returns {Boolean}
 */
function isNumber(str) {
    var alphaExp = /^[0-9]+$/;
    if (str.match(alphaExp)) {
        return true;
    }
    return false;
}

/**
 * Check string is email format
 * @param {string} email
 * @return {Boolean}
 */
function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

/**
 * Check string is url format
 * @param {string} url
 * @returns {Boolean}
 */
function isURL(url) {
    var regex = /\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i;
    return regex.test(url);
}

/**
 * Plugin focus at last character
 * @param {?} $
 */
(function ($) {
    $.fn.focusTextToEnd = function () {
        this.focus();
        var $thisVal = this.val();
        this.val('').val($thisVal);
        return this;
    };
}(jQuery));

/**
 * Go next item
 * @param {string} selector
 */
function inputNextEvent(selector) {
    $(selector).keyup(function() {
        if (this.value.length == this.maxLength) {
            $(this).nextAll(selector).eq(0).focus().select();
            return false;
        }
    });
}

/**
 * Go previous item
 * @param {string} selector
 */
function inputBackEvent(selector) {
    $(selector).keyup(function(e) {
        if (e.which == 8 && this.value.length == 0) {
            $(this).prevAll(selector).eq(0).focusTextToEnd();
            return false;
        }
    });
}

/**
 * Check sring is empty
 * 
 * @param {String} str
 * @returns {Boolean}
 */
function is_empty(str) {
    if (typeof str === 'undefined') {
        return true;
    }
    str = str.trim();
    if (str == '') {
        return true;
    }
    return false;
}

/**
 * Currency format
 * 
 * @param {String} str
 * @returns {Boolean}
 */
function commaSeparateNumber(val){
    while (/(\d+)(\d{3})/.test(val.toString())){
      val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
    }
    return val;
}