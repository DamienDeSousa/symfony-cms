$(document).ready(function() {
    $(".menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    
    $("#sidebar-wrapper .nav-link").hover(function() {
        $(this).addClass('custom-color');
    }, function () {
        $(this).removeClass('custom-color');
    });
});
