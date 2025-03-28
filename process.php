<?php
// Allowed media formats
$audioFormats = ['mp3', 'ogg'];
$videoFormats = ['mp4', 'mov'];

// Check if number is provided and valid (digits only)
if (!isset($_GET['number']) || !ctype_digit($_GET['number'])) {
    header('HTTP/1.1 404 Not Found');
    include '404.php';
    exit();
}

$number = $_GET['number'];
$csvFile = 'data.csv';
$found = false;
$apiData = null;

if (($handle = fopen($csvFile, 'r')) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
        if ($data[0] === $number) {
            $id = $data[1];  // API object ID from the second column
            $mediaUrl = $data[2];
            $found = true;
            break;
        }
    }
    fclose($handle);
}

// If number is not found, redirect to 404 page and emit proper 404 error
if (!$found) {
    header('HTTP/1.1 404 Not Found');
    include '404.php';
    exit();
}

// Fetch data from the API
$apiUrl = "https://cyfrowe-api.mnw.art.pl/object/$id";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["accept: application/json"]);
$response = curl_exec($ch);
curl_close($ch);


// Decode API response
$apiData = json_decode($response, true);

if ($apiData['status'] == "404") {

    $apiResponse = "<p class=\"api-data\">Zapraszamy do słuchania.</p>";

} else {

    // Extract required fields
    $author = $apiData['data']['authors'][0]['name'] ?? "Brak autora";
    $title = $apiData['data']['title'] ?? "Bez tytułu";
    $noEvidence = $apiData['data']['noEvidence'] ?? "Brak nru inw.";

    // Construct the image URL if available
    $imagePath = $apiData['data']['image']['filePath'] ?? null;
    $imageExt = $apiData['data']['image']['extension'] ?? null;
    $imageFullName = $imagePath . "." . $imageExt;
    $imageUrl = $imagePath ? "https://cyfrowe-cdn.mnw.art.pl/upload/cache/multimedia_detail/$imageFullName" : null;

    // Format API response for display
    $apiResponse = "<p class=\"api-data\"><strong>$title</strong><br>$author<br>$noEvidence</p>";

    if ($imagePath) {
        $imageResponse = "<img src=\"".htmlspecialchars($imageUrl)."\" alt=\"Miniaturka obiektu\" class=\"thumbnail\" loading=\"lazy\">";
    } else {
        $imageResponse = "";
    }

    $apiResponse = $apiResponse . $imageResponse;


}

// Extract file extension to determine media type
$mediaExt = strtolower(pathinfo($mediaUrl, PATHINFO_EXTENSION));

// Determine media type
if (in_array($mediaExt, $audioFormats)) {
    $mediaType = 'audio';
} elseif (in_array($mediaExt, $videoFormats)) {
    $mediaType = 'video';
} else {
    // Unsupported media type, redirect to 404 and emit proper 404 error
    header("Location: 404.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audioguide: <?php echo $number; ?></title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="stylesheet" href="assets/styles_p.css">

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const audio = document.getElementById("custom-audio");
        const playPauseBtn = document.getElementById("play-pause-btn");
        const playIcon = document.getElementById("play-icon");
        const pauseIcon = document.getElementById("pause-icon");
        const replayBtn = document.getElementById("replay-btn");
        const timeDisplay = document.getElementById("audio-time");

        // Play/Pause Function
        function togglePlayPause() {
            if (audio.paused) {
                audio.play();
                playIcon.style.display = "none";
                pauseIcon.style.display = "block";
            } else {
                audio.pause();
                playIcon.style.display = "block";
                pauseIcon.style.display = "none";
            }
        }

        // Replay Function
        function replayAudio() {
            audio.currentTime = 0;
            audio.play();
            playIcon.style.display = "none";
            pauseIcon.style.display = "block";
        }

        // Update Time Display
        function updateTime() {
            const currentTime = formatTime(audio.currentTime);
            const duration = formatTime(audio.duration);
            timeDisplay.innerText = `${currentTime} / ${duration}`;
        }

        // Format Time to MM:SS
        function formatTime(seconds) {
            if (isNaN(seconds)) return "00:00";
            const min = Math.floor(seconds / 60);
            const sec = Math.floor(seconds % 60);
            return `${String(min).padStart(2, "0")}:${String(sec).padStart(2, "0")}`;
        }

        // Event Listeners
        playPauseBtn.addEventListener("click", togglePlayPause);
        replayBtn.addEventListener("click", replayAudio);
        audio.addEventListener("timeupdate", updateTime);
        audio.addEventListener("loadedmetadata", updateTime);
        audio.addEventListener("ended", function () {
            playIcon.style.display = "block";
            pauseIcon.style.display = "none";
        });
    });
</script>

</head>
<body>
    <div class="container">
    <h1><span class="mnw">MNW</span> / Audioguide</h1>
    <h2><?php echo $number; ?></h2>
        <p><?php echo $apiResponse; ?></p>

        <?php if ($mediaType === 'audio'): ?>

<audio id="custom-audio" autoplay preload="metadata">
        <source src="<?php echo htmlspecialchars($mediaUrl); ?>" type="audio/<?php echo $mediaExt; ?>">
        Your browser does not support the audio element.
    </audio>

    <div class="custom-audio-controls">
        <!-- Play/Pause Button -->
        <button id="play-pause-btn" class="audio-btn" onclick="togglePlayPause()">
            <svg id="play-icon" viewBox="0 0 24 24" width="24" height="24" fill="white">
                <polygon points="5,3 19,12 5,21"></polygon>
            </svg>
            <svg id="pause-icon" viewBox="0 0 24 24" width="24" height="24" fill="white" style="display:none;">
                <rect x="5" y="3" width="5" height="18"></rect>
                <rect x="14" y="3" width="5" height="18"></rect>
            </svg>
        </button>

        <!-- Replay Button -->
        <button id="replay-btn" class="audio-btn" onclick="replayAudio()">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="white">
                <path d="M12 5V1L8 5l4 4V6a7 7 0 1 1-7 7h-2a9 9 0 1 0 9-9z"></path>
            </svg>
        </button>

        <!-- Time Display (Non-Clickable) -->
        <div id="audio-time" class="audio-time">00:00 / 00:00</div>
    </div>

        <?php else: ?>
            <video controls autoplay>
                <source src="<?php echo htmlspecialchars($mediaUrl); ?>" type="video/<?php echo $mediaExt; ?>">
                Twoja przeglądarka nie wspiera odtwarzania wideo.
            </video>
        <?php endif; ?>

        <br>
        <a href="index.php" class="button">&#x2b05;</a>
    </div>
</body>
</html>
