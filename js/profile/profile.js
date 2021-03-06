$(document).ready(function() {
	$("#img_container").click(function() {
		$("#userfile").show();
	});

	if (document.location.hash != '') {
		//get the index from URL hash
		tabSelect = document.location.hash.substr(1, document.location.hash.length);
		$('#myTab a[href="#' + tabSelect + '"]').tab('show');
		$('.container-fluid').scrollTop(0);
	}

	$('#myTab a').click(function(e) {
		e.preventDefault();
		$(this).tab('show');
	});
	getAllReviews();

	imagesLoaded('#tiles', function() {
		var options = {
			itemWidth : 200, // Optional min width of a grid item
			autoResize : true, // This will auto-update the layout when the browser window is resized.
			container : $('#tiles'), // Optional, used for some extra CSS styling
			offset : 5, // Optional, the distance between grid items
			outerOffset : 20, // Optional the distance from grid to parent
			flexibleWidth : 300 // Optional, the maximum width of a grid item
		};

		var handler = $('#tiles li');
		handler.wookmark(options);

		$(window).load(function() {
			handler.wookmark(options);
		});
	});
});

function getAllReviews() {
	var resp = $.ajax({
		url : '/thepurplebooth/database/user_rating.php',
		data : {
			'select_reviews' : true,
			'user_name_rating' : username
		},
		type : 'get',
		success : function(output) {
			displayReviews(output);
		}
	});
}

function displayReviews(output) {
	var res = jQuery.parseJSON(output);
	$('.reviews').html("");
	var content = "<ul>";
	// if no reviews then handle the foreach loop
	if (output != null || output != "") {
		$.each(res, function(id, value) {
			content += "<li style='list-style-type: square;'>" + value.rating + " Stars</li>";
			content += "<li style='list-style: none;'> <a href=http://localhost:8888/thepurplebooth/profile.php?username=" + value.rated_by + ">" + value.rated_by + "</a> wrote &#8230; </li>";
			content += "<li style='list-style: none;'> " + value.comments + " </li>";
		});
	}
	content += '</ul>';
	$('.reviews').html(content);
}