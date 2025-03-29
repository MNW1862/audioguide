<?php

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
        $sec_title = "Polityka prywatności";
        $sec_content = "<p>Twoja prywatność jest dla nas ważna.</p>";
        $sec_content .= "<p>Nie gromadzimy, nie przetwarzamy ani nie przechowujemy żadnych danych osobowych użytkowników odwiedzających naszą stronę.</p>";
        $sec_content .= "<p>Nasza strona nie korzysta z plików ciasteczek (<em>cookies</em>) ani podobnych technologii śledzących</p>";
        $sec_content .= "<p>Nie korzystamy z żadnych narzędzi do analizy ruchu (takich jak Google Analytics).</p>";
        $sec_content .= "<p>Strona jest zabezpieczona protokołem HTTPS, co zapewnia bezpieczne połączenie między Twoim urządzeniem a naszym serwerem.</p>";
        $sec_content .= "<p>W razie pytań dotyczących prywatności możesz skontaktować się z nami pod adresem e-mail: <a href=\"mailto:audioguide@mnw.art.pl\">audioguide@mnw.art.pl</a>.</p>";
} elseif ($section == 2) {
        $sec_title = "Deklaracja dostępności";
} elseif ($section == 3) {
        $sec_title = "Kontakt";
} else {
    header("Location: 404.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MNW Audioguide - <?php echo $sectitle; ?></title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="stylesheet" href="assets/styles_p.css">

</head>
<body>
    <div class="container about">
    <h1><span class="mnw">MNW</span> / Audioguide</h1>
    <h2><?php echo $sec_title; ?></h2>
    
    <?php echo $sec_content; ?>
        <br>
        <a href="index.php" class="button">&#x2b05;</a>
    </div>
</body>
</html>
