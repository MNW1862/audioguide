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
	$sec_content = "<p>Muzeum Narodowe w Warszawie zobowiązuje się zapewnić dostępność swojej strony internetowej zgodnie z przepisami ustawy z dnia 4 kwietnia 2019 r. o dostępności cyfrowej stron internetowych i aplikacji mobilnych podmiotów publicznych.</p>";
	$sec_content .= "<p>Deklaracja dostępności dotyczy strony internetowej <a href=\"https://audioguide.mnw.art.pl\">audioguide.mnw.art.pl</a></p>";
	$sec_content .= "<ul>";
	$sec_content .= "<li>Data publikacji strony internetowej: 10 kwietnia 2025 r.</li>";
	$sec_content .= "<li>Data ostatniej istotnej aktualizacji: 10 kwietnia 2025 r.</li>";
	$sec_content .= "</ul>";
	$sec_content .= "<h3>Stan dostępności cyfrowej</h3>";
	$sec_content .= "<p>Strona internetowa jest częściowo zgodna z załącznikiem do ustawy z dnia 4 kwietnia 2019 r. o dostępności cyfrowej stron internetowych i aplikacji mobilnych podmiotów publicznych z powodu niezgodności lub wyłączeń wymienionych poniżej.</p>";
	$sec_content .= "<h3>Treści niedostępne</h3>";
	$sec_content .= "<ol>";
	$sec_content .= "<li>W niektórych miejscach brakuje oznaczenia języka</li>";
	$sec_content .= "<li>Strona nie ma wersji kontrastowej</li>";
	$sec_content .= "<li>Podczas nawigacji na stronie czasami focus przestaje być widoczny</li>";
	$sec_content .= "</ol>";
	$sec_content .= "<h3>Przygotowanie deklaracji dostępności</h3>";
	$sec_content .= "<ul>";
	$sec_content .= "<li>Data sporządzenia deklaracji: 2 kwietnia 2025 r.</li>";
	$sec_content .= "<li>Data ostatniego przeglądu deklaracji: 2 kwietnia 2025 r.</li>";
	$sec_content .= "</ul>";
	$sec_content .= "<p>Deklarację sporządziliśmy na podstawie samooceny przeprowadzonej przez podmiot publiczny.</p>";
	$sec_content .= "<h3>Informacje zwrotne i dane kontaktowe</h3>";
	$sec_content .= "<p>Wszystkie problemy z dostępnością cyfrową tej strony internetowej możesz zgłosić do Mikołaja Machowskiego — mejlowo mmachowski@mnw.art.pl lub telefonicznie 22 621 10 31 w. 462</p>";
	$sec_content .= "<p>Każdy ma prawo wystąpić z żądaniem zapewnienia dostępności cyfrowej tej strony internetowej lub jej elementów.</p>";
	$sec_content .= "<p>Zgłaszając takie żądanie podaj:</p>";
	$sec_content .= "<ul>";
	$sec_content .= "<li>swoje imię i nazwisko,</li>";
	$sec_content .= "<li>swoje dane kontaktowe (np. numer telefonu, e-mail),</li>";
	$sec_content .= "<li>dokładny adres strony internetowej, na której jest niedostępny cyfrowo element lub treść,</li>";
	$sec_content .= "<li>opis na czym polega problem i jaki sposób jego rozwiązania byłby dla Ciebie najwygodniejszy.</li>";
	$sec_content .= "</ul>";
	$sec_content .= "<p>Na Twoje zgłoszenie odpowiemy najszybciej jak to możliwe, nie później niż w ciągu 7 dni od jego otrzymania.</p>";
	$sec_content .= "<p>Jeżeli ten termin będzie dla nas zbyt krótki poinformujemy Cię o tym. W tej informacji podamy nowy termin, do którego poprawimy zgłoszone przez Ciebie błędy lub przygotujemy informacje w alternatywny sposób. Ten nowy termin nie będzie dłuższy niż 2 miesiące.</p>";
	$sec_content .= "<p>Jeżeli nie będziemy w stanie zapewnić dostępności cyfrowej strony internetowej lub treści, wskazanej w Twoim żądaniu, zaproponujemy Ci dostęp do nich w alternatywny sposób.</p>";
	$sec_content .= "<h3>Obsługa wniosków i skarg związanych z dostępnością</h3>";
	$sec_content .= "<p>Jeżeli w odpowiedzi na Twój wniosek o zapewnienie dostępności cyfrowej, odmówimy zapewnienia żądanej przez Ciebie dostępności cyfrowej, a Ty nie zgadzasz się z tą odmową, masz prawo złożyć skargę.</p>";
	$sec_content .= "<p>Skargę masz prawo złożyć także, jeśli nie zgadzasz się na skorzystanie z alternatywnego sposobu dostępu, który zaproponowaliśmy Ci w odpowiedzi na Twój wniosek o zapewnienie dostępności cyfrowej.</p>";
	$sec_content .= "<p>Ewentualną skargę złóż listownie lub mailem do kierownictwa naszego Muzeum:</p>";
	$sec_content .= "<ul>";
	$sec_content .= "<li>Agnieszka Lajus - dyrektorka</li>";
	$sec_content .= "<li>Adres: al. Jerozolimskie 3, 00-495 Warszawa</li>";
	$sec_content .= "<li>mejl: muzeum@mnw.art.pl</li>";
	$sec_content .= "<p><a href=\"https://www.gov.pl/web/gov/zloz-wniosek-o-zapewnienie-dostepnosci-cyfrowej-strony-internetowej-lub-aplikacji-mobilnej\">Pomocne mogą być informacje, które można znaleźć na rządowym portalu gov.pl.</a></p>";
	$sec_content .= "<p>Możesz także poinformować o tej sytuacji <a href=\"https://bip.brpo.gov.pl/\">Rzecznika Praw Obywatelskich</a> i poprosić o interwencję w Twojej sprawie.</p>";
} elseif ($section == 3) {
        $sec_title = "Kontakt";
        $sec_content .= "<h3><a href=\"mailto:audioguide@mnw.art.pl\">audioguide@mnw.art.pl</a></h3>";
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
    <title>MNW Audioguide - <?php echo $sec_title; ?></title>
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
