	// var tweetlimit is set in index
	$(document).ready(function() {
		// Replace form event with ajax event
		// refresh if success, display error div if failure
		$("#new-tweet-form").submit(function(event) {
			/* stop form from submitting normally */
			event.preventDefault();
			var $form = $(this),
				url = $form.attr('action');
			// Length check
			if ($("#tweetcontent").val().length > tweetlimit) {
				displayError("Tweet is too long.");
				return false;
			}
			var posting = $.post(url, {
				tweetcontent: $("#tweetcontent").val()
			});
			/* Alerts the results */
			posting.done(function(data) {
				location.reload();
			});
			posting.fail(function(data) {
				displayError("Tweet was not successfully sent.");
			});
      posting.always(function(data) {
        console.log( data );
      });
			return false;
		});
		// Char count function
		$("#tweetcontent").on('input change paste', function() {
			updateCharCount();
		});
	});

	function updateCharCount() {
		var len = $("#tweetcontent").val().length;
		// console.log("Current length: " + len);
		$("#tweetform .charcount").html(tweetlimit - len + " characters left");
	}

	updateCharCount();

	// Display an error to the user
	function displayError(msg) {
		$("#tweetform .error").show();
		$("#tweetform .error").html(msg);
	}
	// Display an error to the user
	function clearError() {
		$("#tweetform .error").hide();
		$("#tweetform .error").html("");
	}