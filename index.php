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
    <title><?php echo $lang['index_page_title']; ?></title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
    <header>
    <h1><?php echo $lang['header_title']; ?></h1>

    <!-- Hamburger button -->
    <a class="menu-icon" href="menu.php<?php echo "?lang=" . $lang['lang_ver']; ?>">
    <svg viewBox="0 0 30 30" fill="none" stroke="black" stroke-width="2">
	<title id="open_menu"><?php echo $lang['index_menu_open']; ?></title>
	<line x1="3" y1="6" x2="21" y2="6" />
	<line x1="3" y1="12" x2="21" y2="12" />
	<line x1="3" y1="18" x2="21" y2="18" />
    </svg>
    </a>
    </header>
  <!-- Overlay -->

        
        <form action="process.php" method="get" onsubmit="return validateForm()">
            <input type="text" id="number" name="number" placeholder="123" tabindex="0" required readonly>
	    <input type="hidden" id="lang" name="lang" value="<?php echo $lang['lang_ver']; ?>">
            <label for="number">
            <p id="error-message" class="error-message"><?php echo $lang['index_error_message']; ?></p>
            </label>
            
            <!-- Custom Numeric Keypad -->
            <div class="keypad" role="keypad">
                <button type="button" tabindex="1" onclick="addDigit('1')">1</button>
                <button type="button" tabindex="2" onclick="addDigit('2')">2</button>
                <button type="button" tabindex="3" onclick="addDigit('3')">3</button>
                
                <button type="button" tabindex="4" onclick="addDigit('4')">4</button>
                <button type="button" tabindex="5" onclick="addDigit('5')">5</button>
                <button type="button" tabindex="6" onclick="addDigit('6')">6</button>
                
                <button type="button" tabindex="7" onclick="addDigit('7')">7</button>
                <button type="button" tabindex="8" onclick="addDigit('8')">8</button>
                <button type="button" tabindex="9" onclick="addDigit('9')">9</button>
                
                <button type="button" onclick="clearInput()" class="clear-btn" title="<?php echo $lang['index_clear_no']; ?>">C</button>
                <button type="button" tabindex="10" onclick="addDigit('0')">0</button>
                <button type="button" tabindex="11" onclick="deleteLastDigit()" class="backspace-btn" title="<?php echo $lang['index_delete_last']; ?>">&#x232b;</button>
            </div>

            <button type="submit" title="<?php echo $lang['index_send']; ?>">&#x2b95;</button>
        </form>
    </div>

    <script>
        function addDigit(digit) {
            var inputField = document.getElementById('number');
            
            if (inputField.value.length < 6) {
                inputField.value += digit;
            }
        }

        function deleteLastDigit() {
            var inputField = document.getElementById('number');
            inputField.value = inputField.value.slice(0, -1);
        }

        function clearInput() {
            document.getElementById('number').value = '';
        }

        function validateForm() {
            var inputField = document.getElementById('number');
            var errorMessage = document.getElementById('error-message');

            if (inputField.value.length === 0) {
                inputField.classList.add('error');
                errorMessage.classList.add('show'); // Show error message
                return false;
            }

            // Remove error styles if input is correct
            inputField.classList.remove('error');
            errorMessage.classList.remove('show');
            return true;
        }
    </script>
</body>
</html>
