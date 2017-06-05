<div id="maincontent">
	<a class="btn btn-warning logout" href="<?php echo $this->viewdata['root-url']; ?>/logout">Log out</a>
	<h1 class="title">Tweets</h1><br>
	<div id="tweetform">
		<form action="<?php echo $this->viewdata['tweet-submit']; ?>" class="new-tweet" id="new-tweet-form" method="post" name="new-tweet-form">
			<h2 class="tweet-form-heading">Have something interesting to say? Tell us about it!</h2>
			<textarea class="form-control" cols="50" id="tweetcontent" name="tweetcontent" rows="4"></textarea> <span class="charcount"></span> <button class="btn btn-lg btn-primary btn-block" type="submit">Tweet</button> <span class="error alert alert-warning"></span>
		</form>
	</div><!-- end #tweetform -->
	<div id="tweets">
		<?php 
		// Loop through tweets and display them
		foreach (array_reverse($this->viewdata['tweets']) as $tweet) { ?>
			<div class="tweet" id="tweetid-&lt;?php echo $tweet['tweet_id']; ?&gt;">
				<span class="author">
                    <span class="name">@<?php echo $tweet['username']; ?></span> 
                    <img alt="Profile Picture" src="<?php echo $this->viewdata['root-url']; ?>/assets/profile.png">
                </span> 
                <span class="content">
                    <?php echo $tweet['content']; ?>
                </span> 
                <span class="timestamp">
                    <?php echo date("F j, Y", $tweet['timestamp']); ?>
                </span>
			</div><!-- end .tweets -->
		<?php } ?>
	</div><!-- end #tweets -->
</div>