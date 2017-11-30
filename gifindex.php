<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<head>
	<title>Sit Back</title>
</head>
<style>
html, body{
  margin: 0;
  padding: 0;
  height: 100%;
  width: 100%;
  overflow: hidden;
  -webkit-column-gap: 0;
  -moz-column-gap: 0;
  column-gap: 0;
  display: inline-block;
  border-collapse: collapse;
}
body{
  position: absolute;
  background-color:#000;
  background-size:cover;
  cursor: none;
}
img{
  display: inline-block;
  height: 33.333333%;
  width: 25%;
  margin: 0;
  vertical-align: top;
}
</style>
<body>
<?php
function get_gif() {
	if (file_exists('gifs')) {
		//reads and unserializes the gifs file
		$gifs = unserialize(file_get_contents('gifs'));
		//selects a random gif and gets the ID
		srand();
		$gifurl = $gifs[array_rand($gifs)][0];
		return $gifurl;
	} else {
		echo 'No video list found, if you have not configured it, go to edit.php';
		return false;
	}
}

for ($i = 1; $i <= 12; $i ++) {
	echo '<img src="' . get_gif() . '">';
	if ($i % 4 == 0) {
		echo '<br>' . "\n";
	}
}
?>
</body>
</html>
