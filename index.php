<?php
$title = "TinyVPS";
$city = "Fürth";
$fav_link ="https://www.europeana.eu/en";
$footer ="This is <a href=''>Tiny page</a>";
$search = "https://tinyvps.xyz/gufo/search.php?q=";
$request = "http://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1";
$response = file_get_contents($request);
$data = json_decode($response, true);
$img_url = "https://bing.com" . $data['images'][0]['url'];
?>

<html lang="en">
<!-- Author: Dmitri Popov, dmpop@linux.com
         License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt -->

<head>
	<title><?php echo $title ?></title>
	<link rel="icon" type="image/png" href="/favicon.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		html {
			background: url(<?php echo $img_url; ?>) no-repeat center center fixed;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
		}

		body {
			font-family: "Karla", monospace;
		}

		.flexbox {
			float: left;
			color: #ffffff;
			background-color: #000000;
			opacity: 0.5;
			border-radius: 5px;
			padding: .5em;
			margin-right: .5em;
			margin-bottom: .5em;
		}

		#footer {
			position: fixed;
			text-align: center;
			vertical-align: middle;
			color: #ffffff;
			background-color: #000000;
			opacity: 0.5;
			bottom: 0;
			width: 100%;
			height: 1.5em;
		}

		input {
			width: 20em;
			height: 2em;
			border: 0;
			border-radius: 5px;
		}

		a {
			color: #ffffff;
		}

		@font-face {
			font-family: "Karla";
			font-style: normal;
			src: url("Karla-Regular.woff2") format("woff2");
		}
	</style>
</head>

<body>
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
	<p></p>
	<div class="flexbox">
		<strong>Favorite link:</strong> <a href="<?php echo $fav_link; ?>">Europeana</a>
	</div>
	<div class="flexbox">
		<form style="margin-bottom: -0.01em;"  method="POST" action="" autocomplete="off">
			<label for="query">Search: </label>
			<input type="text" name="query" />
		</form>
	</div>
	<div id="footer">
		<?php echo $footer; ?>
	</div>
	<?php
	if (isset($_POST["query"])) {
		echo "<script>window.location = '" . $search . $_POST['query'] . "'</script>";
	}
	?>
</body>

</html>