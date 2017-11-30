<html>
<body>
<div>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
	<h1>Input url of a gif to add to the list<h1>
	<input type="text" name="gifurl" placeholder="URL of a GIF to add" autofocus>
	<br><br>
	<h1>Input the title for that gif<h1>
	<input type="text" name="giftitle" placeholder="GIF title" autofocus>
	<br><br>
	<h1>Select a gif to remove<h1>
	<select name="remove">
		<option>None</option>
		<?php
			//checks to see if the file exists before continuing
			if (file_exists('gifs')) {
				//reads and unserializes the gifs file
				$gifs = unserialize(file_get_contents('gifs'));
				//loops through the gifs array to get components of each video
				foreach($gifs as $element) {
					$gifurl = $element[0];
					$giftitle = $element[1];
					//formats the gif details for html
					echo "\t\t<option value=\"$giftitle\">$giftitle</option>";
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
//checks to see if the gif url is set and not empty
if (isset($_POST['gifurl']) && $_POST['giftitle'] !== "") {
	//gets gif url from post
	$gifurl = $_POST['gifurl'];
	$giftitle = $_POST['giftitle'];
	if (stripos($gifurl, 'gif') !== FALSE) {
		if (file_exists('gifs')) {
			//reads and unserializes the gifs file
			$gifs = unserialize(file_get_contents('gifs'));
			//adds a new element containing the new gif url and title
			$gifs[count($gifs)] = [$gifurl, $giftitle];
		} else {
			//makes a new array for gifs and adds the gif url and title
			$gifs[0] = [$gifurl, $giftitle];
		}
		file_put_contents('gifs', serialize($gifs));
		header("Refresh:0");
	}
}
//checks to see if remove is set and isn't none
if (isset($_POST['remove']) && $_POST['remove'] !== "None") {
	//gets the gif title to be removed from the post
	$giftitle = $_POST['remove'];
	//reads and unserializes the gifs file
	$gifs = unserialize(file_get_contents('gifs'));
	//sets the counter to 0
	$counter = 0;
	//loops through the gifs array
	foreach($gifs as $element) {
		//checks to see if the element contains the gif url to be removed
		if(strpos($element[1], $giftitle) !== FALSE) {
			//Removes the array element that contains that gif url
			array_splice($gifs, $counter, 1);
		}
	//increments the counter
	$counter++;
	}
	//serializes and writes new gifs file
	file_put_contents('gifs', serialize($gifs));
}
?>
