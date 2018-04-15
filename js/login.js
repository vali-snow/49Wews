/*global $, document, alert, window, console*/
$(document).ready(function () {
    'use strict';
    var $loginMsg = $('.loginMsg'),
        $login = $('.login'),
        $signupMsg = $('.signupMsg'),
        $signup = $('.signup'),
        $frontbox = $('.frontbox');
    $('#switch1').on('click', function () {
        $loginMsg.toggleClass("visibility");
        $frontbox.addClass("moving");
        $signupMsg.toggleClass("visibility");
        $signup.toggleClass('hide');
        $login.toggleClass('hide');
    });
    $('#switch2').on('click', function () {
        $loginMsg.toggleClass("visibility");
        $frontbox.removeClass("moving");
        $signupMsg.toggleClass("visibility");
        $signup.toggleClass('hide');
        $login.toggleClass('hide');
    });
    $('.login button').on('click', function () {
        var username = $('.login input[name=username]').val();
        var password = $('.login input[name=password]').val();
        if (username === "" || password === ""){
            $('.login err').text('Email or password must not be empty!').show(0).delay(5000).hide(0);
            $(':input').val('');
        } else {
            var dataString = 'username='+username+'&password='+password;
            $.post('..\\phpServer\\login.php', dataString, function () {
            })
            .done(function (jsonObj) {
                var response = JSON.parse(jsonObj);
                if(response.success){
                    window.location = '..\\phpClient\\index.php';
                } else {
                    $('.login err').text('Something went wrong! Check console.').show(0).delay(5000).hide(0);
                    console.log(response.errorMessage);
                }
            })
            .fail(function (response) {
                $('.login err').text('Something went wrong! Check console.').show(0).delay(5000).hide(0);
                console.log('Error while posting to login.php:\n' + response.status + ' - ' + response.statusText);
            })
            .always(function () {
                $(':input').val('');
            });
        }
        
    });
    $('.signup button').on('click', function () {
        var username = $('.signup input[name=username]').val();
        var email = $('.signup input[name=email]').val();
        var password = $('.signup input[name=password]').val();
        if (username === "" || email ==="" || password === ""){
            $('.signup err').text('Fields must not be empty!').show(0).delay(5000).hide(0);
            $(':input').val('');
        } else {
            var dataString = 'username='+username+'&email='+email+'&password='+password;
            $.post('..\\phpServer\\register.php', dataString, function () {
            })
            .done(function (jsonObj) {
                var response = JSON.parse(jsonObj);
                if(response.success){
                    $('.signup scs').text('Succesfull registration!').show(0).delay(5000).hide(0);
                } else {
                    $('.signup err').text('Something went wrong! Check console.').show(0).delay(5000).hide(0);
                    console.log(response.errorMessage);
                }
            })
            .fail(function (response) {
                $('.signup err').text('Something went wrong! Check console.').show(0).delay(5000).hide(0);
                console.log('Error while posting to signup.php:\n' + response.status + ' - ' + response.statusText);
            })
            .always(function () {
                $(':input').val('');
            });
        }
    });
});