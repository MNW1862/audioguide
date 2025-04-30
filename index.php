<?php
// Include common elements
require '/var/www/include_audio/common.php';
?>
<!DOCTYPE html>
<html lang="<?php echo $lang['lang_ver']; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang['index_page_title']; ?></title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <link nonce="<?php echo $nonce_string; ?>" rel="stylesheet" href="assets/styles.css">
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

    <form action="process.php" method="get" onsubmit="return validateForm()">
    <input type="text" id="number" name="number" placeholder="123" tabindex="0" required readonly>
    <input type="hidden" id="lang" name="lang" value="<?php echo $lang['lang_ver']; ?>">
    <label for="number">
    <p id="error-message" class="error-message"><?php echo $lang['index_error_message']; ?></p>
    </label>
            
    <!-- Custom Numeric Keypad -->
    <div class="keypad" role="keypad">
        <button type="button" id="b01" tabindex="1">1</button>
        <button type="button" id="b02" tabindex="2">2</button>
        <button type="button" id="b03" tabindex="3">3</button>
        
        <button type="button" id="b04" tabindex="4">4</button>
        <button type="button" id="b05" tabindex="5">5</button>
        <button type="button" id="b06" tabindex="6">6</button>
        
        <button type="button" id="b07" tabindex="7">7</button>
        <button type="button" id="b08" tabindex="8">8</button>
        <button type="button" id="b09" tabindex="9">9</button>
        
        <button type="button" id="bci" class="clear-btn" title="<?php echo $lang['index_clear_no']; ?>">C</button>
        <button type="button" id="b00" tabindex="10">0</button>
        <button type="button" id="bdl" tabindex="11" class="backspace-btn" title="<?php echo $lang['index_delete_last']; ?>">&#x232b;</button>
    </div>

    <button type="submit" title="<?php echo $lang['index_send']; ?>">&#x2b95;</button>
    </form>

    <script nonce="<?php echo $nonce_string; ?>">

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

        // add events to buttons
        document.getElementById("b01").addEventListener("click", function () { addDigit('1'); }, false);
        document.getElementById("b02").addEventListener("click", function () { addDigit('2'); }, false);
        document.getElementById("b03").addEventListener("click", function () { addDigit('3'); }, false);
        document.getElementById("b04").addEventListener("click", function () { addDigit('4'); }, false);
        document.getElementById("b05").addEventListener("click", function () { addDigit('5'); }, false);
        document.getElementById("b06").addEventListener("click", function () { addDigit('6'); }, false);
        document.getElementById("b07").addEventListener("click", function () { addDigit('7'); }, false);
        document.getElementById("b08").addEventListener("click", function () { addDigit('8'); }, false);
        document.getElementById("b09").addEventListener("click", function () { addDigit('9'); }, false);
        document.getElementById("b00").addEventListener("click", function () { addDigit('0'); }, false);
        document.getElementById("bci").addEventListener("click", function () { clearInput(); }, false);
        document.getElementById("bdl").addEventListener("click", function () { deleteLastDigit(); }, false);
    </script>
</body>
</html>
