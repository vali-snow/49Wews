/*global $, document, alert, window, console*/

$(document).ready(function () {
    'use strict';
    // get all feeds details
    var dataString = 'readerId='+Cookies.get("readerId")+'&sessionId='+Cookies.get("sessionId");
    $.post('..\\phpServer\\getAllFeeds.php', dataString, function () {
    })
    .done(function (jsonObj) {
        var response = JSON.parse(jsonObj);
        $("#organize table tr").remove();
		$("#organize table")
			.append($('<tr>')
				.append($('<th>'))
				.append($('<th>',{text:'Name'}))
				.append($('<th>',{text:'Description'}))
				.append($('<th>',{text:(Cookies.get("readerId")==1)?'Manage':'Link'})));
			if (Cookies.get("readerId")==1) {
				$("#organize table th:first")
					.append($('<i>', {class:"fas fa-plus"}))
			}
		
		$.each(response.feeds, function (i, item) {
			$("#organize table")
			.append($('<tr>',{id:item.FeedID})
				.append($('<td>')
					.append($('<input>',{type:'checkbox',checked:item.subscribed})))
				.append($('<td>',{text:item.Name}))
				.append($('<td>',{text:item.Description}))
				.append($('<td>')
					.append($('<a>',{href:item.Link})
						.append($('<i>', {class:"fas fa-link"})))));
			if (Cookies.get("readerId")==1) {
				$("#organize table td:last")
					.append($('<i>', {class:"fas fa-edit"}))
					.append($('<i>', {class:"fas fa-eraser"}));
			}
		});
			
    })
    .fail(function (response) {
        console.log('Error while getting all feeds details:\n' + response.status + ' - ' + response.statusText);
    });
	
	$(document).on("change", "input:checkbox", function () {
		var dataString = 'readerId='+Cookies.get("readerId")+'&sessionId='+Cookies.get("sessionId")+'&feedId='+$(this).parent().parent().attr('id')+'&checkboxValue='+this.checked;
		$.post('..\\phpServer\\updateSubscription.php', dataString, function () {
		})
		.done(function (jsonObj) {
			var response = JSON.parse(jsonObj);
			if(!response.success){
				alert('An error has occured!')
				window.location.reload(true);
			}
		})
		.fail(function (response) {
			console.log('Error while updating subscription:\n' + response.status + ' - ' + response.statusText);
		});
	});
	
});