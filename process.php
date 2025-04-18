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

// Define data files
// Main data file
if ($lang_param === 'en' && file_exists('data_en.csv')) {
    $csvFile = 'data_en.csv';
} else {
    $csvFile = 'data.csv';
}
// Data for non-muza/cyfrowe entries
if ($lang_param === 'en' && file_exists('data_nm_en.csv')) {
    $csvFile_nm = 'data_nm_en.csv';
} else {
    $csvFile_nm = 'data_nm.csv';
}

// Safely determine media number
// Note: with this approach we cannot use 0001 style numbers
$number = filter_input(
    INPUT_GET, 'number',
    FILTER_VALIDATE_INT, ['options'=>['min_range'=>1]]
);
if ($number === false || $number === null) {
    header('HTTP/1.1 404 Not Found');
    include '404.php';
    exit();
}

// Allowed media formats
$audioFormats = ['mp3', 'ogg', 'wav'];
$videoFormats = ['mp4', 'mov'];

$found = false;
$apiData = null;

if (($handle = fopen($csvFile, 'r')) !== FALSE) {
    while (($data = fgetcsv($handle, 10000, ',')) !== FALSE) {
        if ($data[0] == $number) {
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

// if $id is number look for data in API, elsewhere look for non MUZA objects
if (ctype_digit($id)) {

    // Fetch data from the API
    // TODO: process API data in other languages
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

        $apiResponse = "<p class=\"api-data\">" . $lang['api_listen'] . "</p>";

    } else {

        // Extract required fields
        $author = $apiData['data']['authors'][0]['name'] ?? $lang['api_no_author'];
        $title = $apiData['data']['title'] ?? $lang['api_no_title'];
        $noEvidence = $apiData['data']['noEvidence'] ?? $lang['api_no_invno'];

        // Construct the image URL if available
        $imagePath = $apiData['data']['image']['filePath'] ?? null;
        $imageExt = $apiData['data']['image']['extension'] ?? null;
        $imageFullName = $imagePath . "." . $imageExt;
	// Link to image - no need to include in translations
        $imageUrl = $imagePath ? "https://cyfrowe-cdn.mnw.art.pl/upload/cache/multimedia_detail/$imageFullName" : null;

        // Format API response for display
        $apiResponse = "<p class=\"api-data\"><strong>$title</strong><br>$author<br>$noEvidence</p>";

        if ($imagePath) {
        $imageResponse = "<img src=\"".htmlspecialchars($imageUrl)."\" alt=\"".$lang['alt_no_min']."\" class=\"thumbnail\" loading=\"lazy\">";
        } else {
        $imageResponse = "";
        }

        $apiResponse = $apiResponse . $imageResponse;


    }
} elseif (!empty($id)) {
    // use same or second file to find data about current entry
    if (($handle_nm = fopen($csvFile_nm, 'r')) !== FALSE) {
        while (($data_nm = fgetcsv($handle_nm, 10000, ',')) !== FALSE) {
            if ($data_nm[0] === $id) {
                $mediaUrl = $data_nm[1]; // media

                // Format response for display
                $dataResponse = "<p class=\"api-data\">$data_nm[2]</p>";
                $imageResponse = "<img src=\"".htmlspecialchars($data_nm[3])."\" alt=\"".$lang['alt_no_min']."\" class=\"thumbnail\" loading=\"lazy\">";
                $found = true;

                $apiResponse = $dataResponse . $imageResponse;

                break;
            }
        }
        fclose($handle_nm);
    }
} else {
    $apiResponse = "<p class=\"api-data\">".$lang['api_listen']."</p>";
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
<html lang="<?php echo $lang['lang_ver']; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang['process_title_prefix'] . ": " . $number; ?></title>
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
    <header>
    <h1><?php echo $lang['header_title']; ?></h1>
    </header>
    <h2><?php echo $number; ?></h2>
        <p><?php echo $apiResponse; ?></p>

        <?php if ($mediaType === 'audio'): ?>

<audio id="custom-audio" autoplay preload="metadata">
        <source src="<?php echo htmlspecialchars($mediaUrl); ?>" type="audio/<?php echo $mediaExt; ?>">
	<?php echo $lang['audio_fallback']; ?>
    </audio>

    <div class="custom-audio-controls">
        <!-- Play/Pause Button -->
        <button id="play-pause-btn" class="audio-btn" onclick="togglePlayPause()">
            <svg id="play-icon" viewBox="0 0 24 24" width="24" height="24" fill="white">
        <polygon points="5,3 19,12 5,21">
                <title><?php echo $lang['play_title']; ?></title>
                </polygon>
            </svg>
            <svg id="pause-icon" viewBox="0 0 24 24" width="24" height="24" fill="white" style="display:none;">
    
        <rect x="5" y="3" width="5" height="18">
                <title><?php echo $lang['pause_title']; ?></title>
                </rect>
                <rect x="14" y="3" width="5" height="18"></rect>
            </svg>
        </button>

        <!-- Replay Button -->
        <button id="replay-btn" class="audio-btn" onclick="replayAudio()">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="white">
        <path d="M12 5V1L8 5l4 4V6a7 7 0 1 1-7 7h-2a9 9 0 1 0 9-9z">
        <title><?php echo $lang['replay_title']; ?></title>
                </path>
            </svg>
        </button>

        <!-- Time Display (Non-Clickable) -->
        <div id="audio-time" class="audio-time">00:00 / 00:00</div>
    </div>

        <?php else: ?>
            <video controls autoplay>
                <source src="<?php echo htmlspecialchars($mediaUrl); ?>" type="video/<?php echo $mediaExt; ?>">
		<?php echo $lang['video_fallback']; ?>
            </video>
        <?php endif; ?>

        <br>
         <a href="index.php<?php echo "?lang=" . $lang['lang_ver']; ?>" class="button" title="<?php echo $lang['home_title']; ?>">&#x2b05;</a>
    </div>
</body>
</html>
