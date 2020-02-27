// Generate a new captcha
$("#captcha_change").on("click", function () {
    $('#captcha_img').attr('src', './lib/captcha.php?r=' + Math.random());
});