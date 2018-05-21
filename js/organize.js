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
		var dataString = 'readerId='+Cookies.get("readerId")+'&sessionId='+Cookies.get("sessionId")+'&feedId='+$(this).closest("tr").attr('id')+'&checkboxValue='+this.checked;
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
	
	//ADD
	$(document).on( "click", ".fa-plus", function() {
		$("modalOrganize").css("display", "block");
		Cookies.set("modalOrganize", "ADD");
		init(Cookies.get("modalOrganize"));
	});
	//EDIT
	$(document).on( "click", ".fa-edit", function() {
		$("modalOrganize").css("display", "block");
		Cookies.set("modalOrganize", "EDIT");
		Cookies.set("feedId", $(this).closest("tr").attr('id'));
		Cookies.set("feedName", $(this).closest("tr").find(":nth-child(2)").text());
		Cookies.set("feedDescription", $(this).closest("tr").find(":nth-child(3)").text());
		Cookies.set("feedLink", $(this).closest("tr").find(":nth-child(4) a").attr('href'));
		init(Cookies.get("modalOrganize"));
	});
	//COMMON MODAL
	function init(opt) {
		switch(opt) {
			case "ADD":
				$("modalOrganize .modal-header h2").text("Add a new feed");
				$("modalOrganize .modal-body input[name=name]").val('');
				$("modalOrganize .modal-body input[name=description]").val('');
				$("modalOrganize .modal-body textarea").val('');
				$("modalOrganize .modal-footer #submit").html('Add Feed');
				break;
			case "EDIT":
				$("modalOrganize .modal-header h2").text("Edit feed");
				$("modalOrganize .modal-body input[name=name]").val(Cookies.get("feedName"));
				$("modalOrganize .modal-body input[name=description]").val(Cookies.get("feedDescription"));
				$("modalOrganize .modal-body textarea").val(Cookies.get("feedLink"));
				$("modalOrganize .modal-footer #submit").html('Edit Feed');
				break;
		}
	}
	$(document).on( "click", "modalOrganize span, modalOrganize #close", function() {
		$("modalOrganize").css("display", "none");
		Cookies.remove('feedId');
		Cookies.remove('feedName');
		Cookies.remove('feedDescription');
		Cookies.remove('feedLink');
	});
	$(document).on( "click", "modalOrganize #reset", function() {
		init(Cookies.get("modalOrganize"));
	});
	$(document).on( "click", "modalOrganize #submit", function() {
		var dataString = 'readerId='+Cookies.get("readerId")+'&sessionId='+Cookies.get("sessionId")+'&feedId='+Cookies.get("feedId")+'&feedName='+$("modalOrganize .modal-body input[name=name]").val()+'&feedDescription='+$("modalOrganize .modal-body input[name=description]").val()+'&feedLink='+$("modalOrganize .modal-body textarea").val();
		$.post('..\\phpServer\\addEditFeed.php', dataString, function () {
		})
		.done(function (jsonObj) {
			var response = JSON.parse(jsonObj);
			if(!response.success){
				alert('An error has occured!')
			}
			window.location.reload(true);
		})
		.fail(function (response) {
			console.log('Error while deleting the feed:\n' + response.status + ' - ' + response.statusText);
		});
		$("modalOrganize").css("display", "none");
		Cookies.remove('feedId');
		Cookies.remove('feedName');
		Cookies.remove('feedDescription');
		Cookies.remove('feedLink');
	});
	//DELETE
	$(document).on( "click", ".fa-eraser", function() {
		if (confirm("Delete feed?")) {
				var dataString = 'readerId='+Cookies.get("readerId")+'&sessionId='+Cookies.get("sessionId")+'&feedId='+$(this).closest("tr").attr('id');
				$.post('..\\phpServer\\deleteFeedCascade.php', dataString, function () {
				})
				.done(function (jsonObj) {
					var response = JSON.parse(jsonObj);
					if(response.success){
						$("#"+response.feedId).remove();
					}else{
						alert('An error has occured!')
						window.location.reload(true);
					}
				})
				.fail(function (response) {
					console.log('Error while deleting the feed:\n' + response.status + ' - ' + response.statusText);
				});
            }
	});
});