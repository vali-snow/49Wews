/*global $, Cookies, confirm, document, window */
$(document).ready(function () {
    'use strict';
    $("nav").load("../html/common/nav.html", function () {
        $(".menuLoginLogout").click(function () {
            $("modalLogin").eq(0).css("display", "block");
        });
        $(".menuQuit").click(function () {
            var mywin = window.open('', '_self');
            if (confirm("Close Window?")) {
                mywin.close();
            }
        });
    });
});