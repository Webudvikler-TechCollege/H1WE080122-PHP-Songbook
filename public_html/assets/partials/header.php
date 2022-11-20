<?php
$arrNavItems = [
	[
		"title" => "Forside",
		"url" => "/index.php"
	], 
	[
		"title" => "Om os",
		"url" => "/about.php"
	],
	[
		"title" => "Kontakt",
		"url" => "/contact.php"
	]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/assets/css/styles.css" />
	<title><?php echo isset($strPageTitle) ? $strPageTitle : 'Min PHP side' ?></title>
</head>
<body>
	<header>
		<div id="logo">MyFirstPHPSite</div>
		<nav>
			<ul>
				<?php 
					foreach($arrNavItems as $key => $value) {
						$class = ($_SERVER["PHP_SELF"] === $value["url"]) ? "active" : "";
						echo "<li><a class=\"" . $class . "\" href=\"" . $value["url"] . "\">" . $value["title"] . "</a></li>";
					}
				?>
			</ul>
		</nav>
	</header>