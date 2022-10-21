function toRupiah(val) {
    return new Intl.NumberFormat("de-DE").format(val);
}
$(function ($) {
    $(".amount_format").autoNumeric("init", {
        aSep: ".",
        aDec: ",",
        mDec: "0",
    });
});
