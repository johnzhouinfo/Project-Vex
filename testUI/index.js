
import AOS from 'aos';
import 'aos/dist/aos.css';

$(function() {
    AOS.init();
    $('.hambuger-menu').on()('click', function(){
        $('.toggle').toggleClass('open');
    });


});
