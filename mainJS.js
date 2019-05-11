$(document).ready(function(){
    $(".scroll-downs").click(function(){
        $('html, body').animate({
            scrollTop: $(".about").offset().top
        }, 1000);
    });
    $("#li_home").click(function(){
        $('html, body').animate({
            scrollTop: $(".main").offset().top
        }, 1000);
    });
    $("#li_about").click(function(){
        $('html, body').animate({
            scrollTop: $(".about").offset().top
        }, 1000);
    });
    $("#li_tracker").click(function(){
        $('html, body').animate({
            scrollTop: $(".tracker").offset().top
        }, 1000);
    });
    $("#li_contact").click(function(){
        $('html, body').animate({
            scrollTop: $("footer").offset().top
        }, 1000);
    });
});