<html>
<body>
<div>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
	<h1>Input video ID of a video to add to the list<h1>
	<input type="text" name="videoid" placeholder="Video ID of video to add" autofocus>
	<br><br>
	<h1>Select a video to remove<h1>
	<select name="remove">
		<option>None</option>
		<?php
			//checks to see if the file exists before continuing
			if (file_exists('videos')) {
				//reads and unserializes the videos file
				$videos = unserialize(file_get_contents('videos'));
				//loops through the videos array to get components of each video
				foreach($videos as $element) {
					$videoid = $element[0];
					$videotitle = $element[1];
					//formats the video details for html
					echo "\t\t<option value=\"$videoid\">$videotitle</option>";
				}
			}
		?>
	</select>
	<br><br>
	<input type="submit" name="submit" text="Update list"/>
</form>
</div>
</body>
</html>
<?php
//includes the config to get youtube api token
include 'config.php';
//checks to see if the video id is set and not empty
if (isset($_POST['videoid']) && $_POST['videoid'] !== "") {
	//gets video id from post
	$videoid = $_POST['videoid'];
	//checks to see if the video id contains the string youtube so it can extract the video id
	if (stripos($videoid, 'youtube') !== FALSE) {
		//parses the string to get query information
		parse_str(parse_url($videoid, PHP_URL_QUERY), $videoquery);
		//sets the video ID to be just the v query which is the video id
		$videoid = $videoquery['v'];
	}
	//gets the title snippet using the youtube api
	$videoinfo = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/videos?part=snippet&id='.$videoid.'&key='.$ytapikey.'&fields=items(snippet(title))'));
	//sets videotitle to be just the title portion of the snippet
	$videotitle = $videoinfo->items[0]->snippet->title;
	//checks to see if videos exists so it can read it and then concatenate it
	if (file_exists('videos')) {
		//reads and unserializes the videos file
		$videos = unserialize(file_get_contents('videos'));
		//adds a new element containing the new video id and title
		$videos[count($videos)] = [$videoid, $videotitle];
	} else {
		//makes a new array for videos and adds the video id and title
		$videos[0] = [$videoid, $videotitle];
	}
	//checks to see if the video is valid based on the title found before writing
	if ($videotitle !== NULL) {
		//serializes and writes new video file
		file_put_contents('videos', serialize($videos));
		//refreshes the page
		header("Refresh:0");
	} else {
		echo 'Invalid video';
	}
}
//checks to see if remove is set and isn't none
if (isset($_POST['remove']) && $_POST['remove'] !== "None") {
	//gets the video id to be removed from the post
	$videoid = $_POST['remove'];
	//reads and unserializes the videos file
	$videos = unserialize(file_get_contents('videos'));
	//sets the counter to 0
	$counter = 0;
	//loops through the videos array
	foreach($videos as $element) {
		//checks to see if the element contains the video ID to be removed
		if(strpos($element[0], $videoid) !== FALSE) {
			//Removes the array element that contains that video ID
			array_splice($videos, $counter, 1);
		}
	//increments the counter
	$counter++;
	}
	//serializes and writes new videos file
	file_put_contents('videos', serialize($videos));
}
?>
