<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MNW Audioguide</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
    <header>
        <h1><span class="mnw">MNW</span> / Audioguide</h1>

    <!-- Menu Toggle -->
    <input type="checkbox" id="menu-toggle">

    <!-- Hamburger Icon Label -->
    <label for="menu-toggle" class="menu-icon">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <line x1="3" y1="6" x2="21" y2="6" />
    <line x1="3" y1="12" x2="21" y2="12" />
    <line x1="3" y1="18" x2="21" y2="18" />
    </svg>
    </label>
  <!-- Overlay -->
  <label for="menu-toggle" class="overlay"></label>

  <!-- Menu -->
  <nav class="menu">

    <!-- Menu Toggle -->
    <input type="checkbox" id="menu-toggle">
    <!-- Close Button -->
    <label for="menu-toggle" class="close-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="18" y1="6" x2="6" y2="18" />
        <line x1="6" y1="6" x2="18" y2="18" />
      </svg>
    </label>

    <!-- Menu Items -->
    <a href="index_en.php">EN</a>
    <a href="index.php">PL</a>
    <a href="about.php?section=1">Polityka prywatności</a>
    <a href="about.php?section=2">Deklaracja dostępności</a>
    <a href="about.php?section=3">Kontakt</a>
  </nav>
  </header>

        
        <form action="process.php" method="get" onsubmit="return validateForm()">
            <input type="text" id="number" name="number" placeholder="123" required readonly>
            <label for="number">
            <p id="error-message" class="error-message">Proszę wprowadzić numer.</p>
            </label>
            
            <!-- Custom Numeric Keypad -->
            <div class="keypad">
                <button type="button" onclick="addDigit('1')">1</button>
                <button type="button" onclick="addDigit('2')">2</button>
                <button type="button" onclick="addDigit('3')">3</button>
                
                <button type="button" onclick="addDigit('4')">4</button>
                <button type="button" onclick="addDigit('5')">5</button>
                <button type="button" onclick="addDigit('6')">6</button>
                
                <button type="button" onclick="addDigit('7')">7</button>
                <button type="button" onclick="addDigit('8')">8</button>
                <button type="button" onclick="addDigit('9')">9</button>
                
                <button type="button" onclick="clearInput()" class="clear-btn">C</button>
                <button type="button" onclick="addDigit('0')">0</button>
                <button type="button" onclick="deleteLastDigit()" class="backspace-btn">&#x232b;</button>
            </div>

            <button type="submit">&#x2b95;</button>
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

