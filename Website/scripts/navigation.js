function open_navigation() {
    //$('#nav_mobile_container').css('display', 'block');
    $('#nav_mobile_container').fadeIn();
    $('#open_nav').css('display', 'none');
    $('#close_nav').css('display', 'block');
}

function close_navigation() {
    //$('#nav_mobile_container').css('display', 'none');
    $('#nav_mobile_container').fadeOut();
    $('#open_nav').css('display', 'block');
    $('#close_nav').css('display', 'none');
}

function changeTemplate() {

    let overlay = $('#loading_overlay');
    //overlay.show();

    $('section').fadeIn();
    $("header").fadeIn("slow", function() {
        $(this).addClass("analyzed");
    });
    $("#close_nav").addClass("index");

    setTimeout(afterTwoSeconds, 2000);

    //overlay.css("display", "none");

}

$(document).ready(function(){

    var scrollTop = 0;
    $(window).scroll(function(){
        scrollTop = $(window).scrollTop();
        $('.counter').html(scrollTop);


        if (scrollTop >= 120) {
            $('#nav_scroll').fadeIn();
        } else if (scrollTop < 120) {
            $('#nav_scroll').fadeOut();
        }

    });
});