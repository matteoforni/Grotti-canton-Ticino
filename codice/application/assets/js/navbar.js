$(document).ready(function($) {
    $(window).scroll(function() {
        var scrollPos = $(window).scrollTop();
        var navbar = $('#navigation');

        if (scrollPos > 400) {
            document.getElementById('navigation').style.backgroundColor = "#FC4445";
            document.getElementById("navigation").style.transition = "all 0.7s";

            $("#nav-image").attr("src", "./application/assets/illustrator/logo-blue.svg");
        } else {
            document.getElementById('navigation').style.backgroundColor = "transparent";

            $("#nav-image").attr("src", "./application/assets/illustrator/logo.svg");
        }
    });
});