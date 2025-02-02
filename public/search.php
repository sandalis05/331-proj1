<?php
function search($query) {
    $query = trim(htmlspecialchars($query));
    if (empty($query)) return [];
    
    $directory = __DIR__;
    $files = scandir($directory);
    $matches = [];

    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) == "php" || pathinfo($file, PATHINFO_EXTENSION) == "html") {
            $content = file_get_contents($file);

            if (stripos($content, $query) !== false) $matches[] = $file;
        }
    }
    return $matches; 
}
?>
