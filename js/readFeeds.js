/*global $, document, alert, window, console*/
function readFeeds(){
	var FeedID = $("#feeds option").filter(":selected").val();
	var dateFilter = $("#dateFilter option").filter(":selected").val();
	var dataString = 'readerId='+Cookies.get("readerId")+'&sessionId='+Cookies.get("sessionId")+'&FeedID='+FeedID+'&dateFilter='+dateFilter;
	$.post('..\\phpServer\\getFeedContent.php', dataString, function () {
	})
	.done(function (jsonObj) {
		var response = JSON.parse(jsonObj);
		$("#readFeeds article").remove();
		$.each(response.items, function (i, item) {
			var img;
			if (item.image){
				img = item.image;
			}else{
				img = item.description.match(/img src="http.*?"/);
				if (!img) {img = "../img/img.jpg";} else {img = img[0].match(/http.*?(?=")/)[0];}
			}
			$("#readFeeds")
				.append($('<article>')
					.append($('<header>')
						.append($('<h1>',{text:item.title})))
					.append($('<main>')
						.append($('<img>',{src:img}))
						.append($('<p>').html(item.description.replace(/<a.*?a>/g,'').replace(/<img.*?\/>/g,'')))
						.append($('<a>',{href:item.link})
							.append($('<i>', {class:"fas fa-chevron-circle-right"}))
						)));
		});
	})
	.fail(function (response) {
		console.log('Error while getting selected feed content:\n' + response.status + ' - ' + response.statusText);
	});
}

$(document).ready(function () {
    'use strict';
    // get subscribed feeds
    var dataString = 'readerId='+Cookies.get("readerId")+'&sessionId='+Cookies.get("sessionId");
    $.post('..\\phpServer\\getSubscriptions.php', dataString, function () {
    })
    .done(function (jsonObj) {
        var response = JSON.parse(jsonObj);
        $("#feeds option").remove();
		$("#feeds select").append($('<option>', {
			value: 'ALL',
			text: 'All feeds'
		}));
		$.each(response.subs, function (i, item) {
			$("#feeds select").append($('<option>', {
				value: item.FeedID,
				text : item.Name
			}));
		});
		readFeeds();
    })
    .fail(function (response) {
        console.log('Error while getting subscribed feeds:\n' + response.status + ' - ' + response.statusText);
    });
	
	$("#readFeeds form select").change(function() {
		readFeeds();
	});
});