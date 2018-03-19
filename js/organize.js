/*global $, document*/
$(document).ready(function () {
    'use strict';
    $("#organize th > i").click(function () {
        $("modalAddSource").eq(0).css("display", "block");
    });
    $("#organize td:last-child>i.fa-edit").click(function () {
        $("modalEditSource").eq(0).css("display", "block");
    });
    $("modalAddSource").load("common/modalAddSource.html", function () {
        $(".modal-header > i, .modal-body > form > button").click(function () {
            $("modalAddSource").eq(0).css("display", "none");
        });
    });
    $("modalEditSource").load("common/modalEditSource.html", function () {
        $(".modal-header > i, .modal-body > form > button").click(function () {
            $("modalEditSource").eq(0).css("display", "none");
        });
    });
    
});