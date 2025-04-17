<?php
// Determine lang inclusion
if (!isset($_GET['lang']) || $_GET['lang'] == 'pl') {
    require 'lang_pl.php';
} elseif (file_exists('lang_en.php') && $_GET['lang'] == 'en') {
    require 'lang_en.php';
} else {
    require 'lang_pl.php';
}

// Check if number is provided and valid (digits only)
if (!isset($_GET['section']) || !ctype_digit($_GET['section'])) {
    header('HTTP/1.1 404 Not Found');
    include '404.php';
    exit();
}

$section = $_GET['section'];
# Section toc
# 1 - privacy
# 2 - accessibility
# 3 - contact/about
if ($section == 1) {
        $sec_title   = $lang['privacy_title'];
        $sec_content = $lang['privacy_content'];
} elseif ($section == 2) {
        $sec_title   = $lang['accessibility_title'];
	$sec_content = $lang['accessibility_content'];
} elseif ($section == 3) {
        $sec_title   = $lang['contact_title'];
        $sec_content = $lang['contact_content'];
} else {
    header("Location: 404.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="<?php echo $lang['lang_ver']; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang['index_page_title'] . " - " . $sec_title; ?></title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="stylesheet" href="assets/styles_p.css">
</head>
<body>
    <div class="container about">
    <header>
    <h1><?php echo $lang['header_title']; ?></h1>
    </header>
    <h2><?php echo $sec_title; ?></h2>
    
    <?php echo $sec_content; ?>
        <br>
        <a href="index.php<?php echo "?lang=" . $lang['lang_ver']; ?>" class="button" title="<?php echo $lang['home_title']; ?>">&#x2b05;</a>
    </div>
</body>
</html>
