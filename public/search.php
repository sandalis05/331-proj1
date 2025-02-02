<?php
function search($query) {
    $query = trim(htmlspecialchars($query)); // Sanitize input
    if (empty($query)) {
        return []; // Return an empty array instead of null
    }

    $directory = __DIR__; // Current directory
    $files = scandir($directory);
    $matches = [];

    foreach ($files as $file) {
        // Only search in .php and .html files
        if (pathinfo($file, PATHINFO_EXTENSION) == "php" || pathinfo($file, PATHINFO_EXTENSION) == "html") {
            $content = file_get_contents($file);

            // Search for the keyword (case-insensitive)
            if (stripos($content, $query) !== false) {
                $matches[] = $file; // Store matching filenames
            }
        }
    }

    return $matches; // Always return an array
}
?>
