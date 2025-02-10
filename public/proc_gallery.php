<?php

function proc_gallery($folder, $mode, $sort_mode) {
    if (!is_dir($folder)) {
        echo "<p>Error: Image folder not found.</p>";
        return;
    }

    $images = [];

    // Scan the folder for image files
    foreach (scandir($folder) as $file) {
        if (in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif'])) {
            $filePath = $folder . "/" . $file;
            $images[] = [
                "filename" => $filePath,
                "description" => pathinfo($file, PATHINFO_FILENAME), // Use filename as description
                "size" => filesize($filePath),
                "date" => filemtime($filePath)
            ];
        }
    }

    // Sorting logic
    switch ($sort_mode) {
        case "date_newest":
            usort($images, fn($a, $b) => $b["date"] - $a["date"]);
            break;
        case "date_oldest":
            usort($images, fn($a, $b) => $a["date"] - $b["date"]);
            break;
        case "size_largest":
            usort($images, fn($a, $b) => $b["size"] - $a["size"]);
            break;
        case "size_smallest":
            usort($images, fn($a, $b) => $a["size"] - $b["size"]);
            break;
        case "rand":
            shuffle($images);
            break;
        default:
            // Keep original order
            break;
    }

    // Display images based on mode
    echo "<div class='gallery'>";
    if ($mode == "matrix") {
        echo "<div class='matrix'>";
        foreach ($images as $img) {
            echo "<div class='img-container'>
                    <img src='{$img['filename']}' alt='Image'>
                    <p>{$img['description']}</p>
                  </div>";
        }
        echo "</div>";
    } elseif ($mode == "list") {
        echo "<ul class='list-view'>";
        foreach ($images as $img) {
            echo "<li>
                    <img src='{$img['filename']}' alt='Image' class='thumb'>
                    <span>{$img['description']}</span>
                  </li>";
        }
        echo "</ul>";
    } elseif ($mode == "details") {
        echo "<table class='details-view'>
                <tr><th>Image</th><th>Description</th><th>Size (KB)</th><th>Date</th></tr>";
        foreach ($images as $img) {
            echo "<tr>
                    <td><img src='{$img['filename']}' alt='Image' class='thumb'></td>
                    <td>{$img['description']}</td>
                    <td>" . round($img['size'] / 1024, 2) . "</td>
                    <td>" . date("Y-m-d H:i:s", $img['date']) . "</td>
                  </tr>";
        }
        echo "</table>";
    }
    echo "</div>";
}
?>
