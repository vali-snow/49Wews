/*global $, Cookies, confirm, document, window */
function initCookies() {
    'use strict';
    if (Cookies.get("sidebarExtended") === undefined) {
        Cookies.set("sidebarExtended", "false");
    }
    if (Cookies.get("sidebarExtended") === "true") {
        $(".menuBurger").toggleClass("change");
        $("aside").eq(0).css("width", "200px");
        $("aside li div").css("display", "flex");
    }
    if (Cookies.get("themeColorDark") === undefined) {
        Cookies.set("themeColorDark", "false");
    }
    if (Cookies.get("themeColorDark") === "true") {
        $(".menuTheme > i").addClass("fas").removeClass("far");
        $("*").css("--themeColor", "rgb(240,240,240)");
        $("*").css("--themeBGColor", "rgb(25,25,25)");
    }
    if (Cookies.get("themeAccentColor") === undefined) {
        Cookies.set("themeAccentColor", $(".menuAccent:hover").css("color"));
    }
    switch (Cookies.get("themeAccentColor")) {
    case "rgb(255, 55, 55)":
        $("*").css("--accentColor", "rgb(255, 55, 55)");
        $("*").css("--accentBGColor", "rgb(255, 55, 55)");
        $("*").css("--accentOpacityColor", "rgba(255, 55, 55, 0.4)");
        break;
    case "rgb(255, 113, 24)":
        $("*").css("--accentColor", "rgb(255, 113, 24)");
        $("*").css("--accentBGColor", "rgb(255, 113, 24)");
        $("*").css("--accentOpacityColor", "rgba(255, 113, 24, 0.4)");
        break;
    case "rgb(255, 195, 0)":
        $("*").css("--accentColor", "rgb(255, 195, 0)");
        $("*").css("--accentBGColor", "rgb(255, 195, 0)");
        $("*").css("--accentOpacityColor", "rgba(255, 195, 0, 0.4)");
        break;
    case "rgb(40, 180, 99)":
        $("*").css("--accentColor", "rgb(40, 180, 99)");
        $("*").css("--accentBGColor", "rgb(40, 180, 99)");
        $("*").css("--accentOpacityColor", "rgba(40, 180, 99, 0.4)");
        break;
    case "rgb(52, 152, 219)":
        $("*").css("--accentColor", "rgb(52, 152, 219)");
        $("*").css("--accentBGColor", "rgb(52, 152, 219)");
        $("*").css("--accentOpacityColor", "rgba(52, 152, 219, 0.4)");
        break;
    case "rgb(108, 52, 131)":
        $("*").css("--accentColor", "rgb(108, 52, 131)");
        $("*").css("--accentBGColor", "rgb(108, 52, 131)");
        $("*").css("--accentOpacityColor", "rgba(108, 52, 131, 0.4)");
        break;
    }
}

$(document).ready(function () {
    'use strict';
    var d1 = new $.Deferred(),
        d2 = new $.Deferred(),
        d3 = new $.Deferred(),
        d4 = new $.Deferred();
    $.when(d1, d2, d3, d4).then(function () {
        initCookies();
    });
    $("nav").load("../html/common/nav.html", function () {
        $(".menuBurger").click(function () {
            $(".menuBurger").toggleClass("change");
            if ($(".menuBurger").hasClass("change")) {
                Cookies.set("sidebarExtended", "true");
                $("aside").eq(0).css("width", "200px");
                $("aside li div").css("display", "flex");
            } else {
                Cookies.set("sidebarExtended", "false");
                $("aside").eq(0).css("width", "65px");
                $("aside li div").css("display", "none");
            }
        });
        $(".menuLoginLogout").click(function () {
            $("modalLogin").eq(0).css("display", "block");
        });
        $(".menuTheme").click(function () {
            if ($(".menuTheme > i").hasClass("far")) {
                Cookies.set("themeColorDark", "true");
                $(".menuTheme > i").addClass("fas").removeClass("far");
                $("*").css("--themeColor", "rgb(240,240,240)");
                $("*").css("--themeBGColor", "rgb(25,25,25)");
            } else {
                Cookies.set("themeColorDark", "false");
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
            Cookies.set("themeAccentColor", accentColor);
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
        d1.resolve();
    });
    $("aside").load("../html/common/aside.html", function () { d2.resolve(); });
    $("footer").load("../html/common/footer.html", function () { d3.resolve(); });
    $("modalLogin").load("../html/common/modalLogin.html", function () {
        $(".modal-header > i, .modal-body > form > button").click(function () {
            $("modalLogin").eq(0).css("display", "none");
        });
        d4.resolve();
    });
});