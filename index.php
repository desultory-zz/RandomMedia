<?php
//checks to see if video file exists
if (file_exists('videos')) {
	//reads and unserializes the videos file
	$videos = unserialize(file_get_contents('videos'));
	//selects a random video and gets the ID
	$videoid = $videos[array_rand($videos)][0];
} else {
	echo 'No video list found, if you have not configured it, go to edit.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<head>
	<title>Infinite Random Videos</title>
</head>
<style>
html, body{
  margin:0;
  padding:0;
  height: 100%;
  width: 100%;
}
.video{
  overflow: hidden;
  position: abslute;
  width: 100%;
  height: 100%;
}
</style>
<body>
	<div class="video">
		<iframe width="100%" height="100%" frameborder="0" src="https://youtube.com/embed/<?php echo $videoid;?>?autoplay=1&loop=1&controls=0&disablekb=1&fs=0&iv_load_policy=3&rel=0&showinfo=0&modestbranding=1"></iframe>
	</div>
</body>
</html>
