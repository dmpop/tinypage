<?php
$title = "TinyVPS";
$city = "Fürth";
$footer = "This is <a href='https://github.com/dmpop/tinypage'>Tiny Page</a>. I really 🧡 <a href='https://www.paypal.com/paypalme/dmpop'>coffee</a>";
$text_file = "vocabulary.txt";
$bookmark_file = "bookmarks.txt";
$photos_dir = "photos";
if (!file_exists($photos_dir) or count(glob("$photos_dir/*")) === 0) {
	$request = "http://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1";
	$response = file_get_contents($request);
	$data = json_decode($response, true);
	$background = "https://bing.com" . $data['images'][0]['url'];
	$img_title = $data['images'][0]['title'];
} else {
	$photos = glob($photos_dir . '/*');
	$photo = array_rand($photos);
	$background = $photos[$photo];
}
?>
<html lang="en">
<!-- Author: Dmitri Popov, dmpop@cameracode.coffee
License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt -->

<head>
	<title><?php echo $title ?></title>
	<link rel="icon" type="image/png" href="/favicon.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		html * {
			font-family: "Inter", sans-serif;
		}

		body {
			background: url(<?php echo $background; ?>) no-repeat center center fixed;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
		}

		.flexbox {
			float: left;
			color: #ffffff;
			background-color: #000000;
			opacity: 0.65;
			border-radius: 5px;
			padding: .5em;
			margin-right: .5em;
			margin-bottom: .5em;
		}

		.footer {
			position: fixed;
			text-align: center;
			color: #ffffff;
			background-color: #000000;
			opacity: 0.65;
			bottom: 0;
			left: 0;
			width: 100%;
			height: 1.5em;
		}

		a {
			color: #ffffff;
		}

		ul {
			list-style-position: inside;
			padding-left: 0;
		}

		li {
			line-height: 150%;
		}

		@font-face {
			font-family: "Inter";
			src: url("fonts/InterDisplay-Regular.woff2") format("woff2");
			font-weight: normal;
			font-style: normal;
		}

		@font-face {
			font-family: "Inter";
			src: url("fonts/InterDisplay-SemiBold.woff2") format("woff2");
			font-weight: bold;
			font-style: normal;
	</style>
</head>

<body>
	<?php
	$handle = fopen($bookmark_file, "r");
	if ($handle) {
		echo "<div class='flexbox'>
		<strong>Bookmarks</strong><br/>
	<ul>";
		while (($line = fgets($handle)) !== false) {
			echo "<li><a href='$line'>" . $line . "</a></li>";
		}
		fclose($handle);
		echo "</div>";
	}
	?>
	<div class="flexbox">
		<?php
		$url = "https://wttr.in/" . $city . "?format=%c+%t,+%w,+%p,+%h";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		$result = curl_exec($ch);
		echo "<strong>" . $city . ":</strong> " . $result;
		?>
	</div>
	<?php
	if (file_exists($text_file)) {
		$lines = file($text_file);
		$random_line = $lines[array_rand($lines)];
		echo "
		<div class='flexbox'>
		<strong>Word or phrase:</strong> $random_line
		</div>
		";
	}
	?>
	<!-- TEMPLATE	
	<div class="flexbox">
		HTML and PHP code goes here
	</div> -->
	<div class="footer">
		<?php echo "<span style='margin-right: 1em;'>" . $footer . "</span>" . $img_title; ?>
	</div>
</body>

</html>