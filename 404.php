<?php
// Determine lang inclusion
if (!isset($_GET['lang']) || $_GET['lang'] == 'pl') {
    require 'lang_pl.php';
} elseif (file_exists('lang_en.php') && $_GET['lang'] == 'en') {
    require 'lang_en.php';
} else {
    require 'lang_pl.php';
}
?>
<!DOCTYPE html>
<html lang="<?php echo $lang['lang_ver']; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang['404_title']; ?></title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="stylesheet" href="assets/styles_p.css">
</head>
<body>
    <div class="container">
	<header>
        <h1><?php echo $lang['header_title']; ?></h1>
	</header>
        <h2><?php echo $lang['404_title']; ?></h2>
        <p class="nodata"><?php echo $lang['404_message']; ?></p>
        <a href="index.php<?php echo "?lang=" . $lang['lang_ver']; ?>" class="button" title="<?php echo $lang['home_title']; ?>">&#x2b05;</a>
    </div>
</body>
</html>
