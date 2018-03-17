/*global $, Cookies, confirm, document, window */
$(document).ready(function () {
    'use strict';
    $("nav").load("../html/common/nav.html", function () {
        $(".menuBurger").click(function () {
            $(".menuBurger").toggleClass("change");
            if ($(".menuBurger").hasClass("change")) {
                $("aside").eq(0).css("width", "200px");
                $("aside li div").css("display", "flex");
            } else {
                $("aside").eq(0).css("width", "65px");
                $("aside li div").css("display", "none");
            }
        });
        $(".menuLoginLogout").click(function () {
            $("modalLogin").eq(0).css("display", "block");
        });
        $(".menuTheme").click(function () {
            if ($(".menuTheme > i").hasClass("far")) {
                $(".menuTheme > i").addClass("fas").removeClass("far");
                $("*").css("--themeColor", "rgb(240,240,240)");
                $("*").css("--themeBGColor", "rgb(25,25,25)");
            } else {
                $(".menuTheme > i").addClass("far").removeClass("fas");
                $("*").css("--themeColor", "rgb(25,25,25)");
                $("*").css("--themeBGColor", "rgb(240,240,240)");
            }
        });
        $(".menuAccent").click(function () {
            var accentColor = $(".menuAccent:hover").css("color"), accentOpacityColor;
            switch (accentColor) {
            case "rgb(255, 55, 55)":
                accentColor = "rgb(255, 113, 24)";
                accentOpacityColor = "rgba(255, 113, 24, 0.4)";
                break;
            case "rgb(255, 113, 24)":
                accentColor = "rgb(255, 195, 0)";
                accentOpacityColor = "rgba(255, 195, 0, 0.4)";
                break;
            case "rgb(255, 195, 0)":
                accentColor = "rgb(40, 180, 99)";
                accentOpacityColor = "rgba(40, 180, 99, 0.4)";
                break;
            case "rgb(40, 180, 99)":
                accentColor = "rgb(52, 152, 219)";
                accentOpacityColor = "rgba(52, 152, 219, 0.4)";
                break;
            case "rgb(52, 152, 219)":
                accentColor = "rgb(108, 52, 131)";
                accentOpacityColor =  "rgba(108, 52, 131, 0.4)";
                break;
            case "rgb(108, 52, 131)":
                accentColor = "rgb(255, 55, 55)";
                accentOpacityColor = "rgba(255, 55, 55, 0.4)";
                break;
            default:
                break;
            }
            $("*").css("--accentColor", accentColor);
            $("*").css("--accentBGColor", accentColor);
            $("*").css("--accentOpacityColor", accentOpacityColor);
        });
        $(".menuQuit").click(function () {
            var mywin = window.open('', '_self');
            if (confirm("Close Window?")) {
                mywin.close();
            }
        });
    });
    $("aside").load("../html/common/aside.html");
    $("footer").load("../html/common/footer.html");
    $("modalLogin").load("../html/common/modalLogin.html", function () {
        $(".modal-header > i, .modal-body > form > button").click(function () {
            $("modalLogin").eq(0).css("display", "none");
        });
    });
});