<?php
// Safely determine lang inclusion
$lang_param = filter_input(
    INPUT_GET,
    'lang',
    FILTER_VALIDATE_REGEXP,
    ['options'=>['regexp'=>'/^(pl|en)$/']]
);
if ($lang_param === false || $lang_param === null) {
    $lang_param = 'pl';
}

if ($lang_param === 'en' && file_exists('lang_en.php')) {
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
    <title><?php echo $lang['index_page_title'] . " - " . $lang['menu_page_title']; ?></title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="stylesheet" href="assets/styles_p.css">
</head>
<body>
    <div class="container">
    <header>
    <h1><?php echo $lang['header_title']; ?></h1>

    <!-- Close button -->
    <a class="menu-icon" href="index.php<?php echo "?lang=" . $lang['lang_ver']; ?>">
    <svg viewBox="0 0 30 30" fill="none" stroke="black" stroke-width="2">
	<title id="close_menu"><?php echo $lang['menu_close']; ?></title>
	<line x1="18" y1="6" x2="6" y2="18" />
	<line x1="6" y1="6" x2="18" y2="18" />
    </svg>
    </a>
    </header>

    <!-- Menu Items -->
    <div class="menuitems">
    <a href="index.php?lang=en">EN</a>
    <a href="index.php">PL</a>
    <a href="about.php?section=1<?php echo '&lang=' . $lang['lang_ver']; ?>"><?php echo $lang['menu_privacy']; ?></a>
    <a href="about.php?section=2<?php echo '&lang=' . $lang['lang_ver']; ?>"><?php echo $lang['menu_accessibility']; ?></a>
    <a href="about.php?section=3<?php echo '&lang=' . $lang['lang_ver']; ?>"><?php echo $lang['menu_contact']; ?></a>
    </div>
    <br>
    <a href="index.php<?php echo "?lang=" . $lang['lang_ver']; ?>" class="button" title="<?php echo $lang['home_title']; ?>">&#x2b05;</a>
</div>
</body>
</html>
