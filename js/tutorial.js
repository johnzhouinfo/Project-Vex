// If first time visit our page, show a tutorial to customer
(function () {
    if (localStorage.getItem("tutorial") == null || localStorage.getItem("tutorial") != "false") {
        tutorial();
        localStorage.setItem("tutorial", "false");
    }
})();
// Click the tutorial btn
$("#tut-btn").on("click", tutorial);

/**
 * Step-by-step tutorial function
 */
function tutorial() {
    $('.help').show();
    $('#step1').show();
    $('.close').on('click', function () {
        $('.step').hide();
        $('.help').hide();
    });
    $('.next').on('click', function () {
        var obj = $(this).parents('.step');
        var step = obj.attr('step');
        obj.hide();
        $('#step' + (parseInt(step) + 1)).show();
    });
    $('.over').on('click', function () {
        $(this).parents('.step').hide();
        $('.help').hide();
    });
};