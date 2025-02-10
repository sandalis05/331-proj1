<?php

function proc_gallery($image_list_filename, $mode, $sort_mode) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if (!file_exists($image_list_filename) || !is_file($image_list_filename)) {
        return;
    }

    $images = [];

    $file = fopen($image_list_filename, "r");
    while (($line = fgets($file)) !== false) {
        $line = trim($line);
        $data = explode(",", $line);
        if (count($data) < 2) continue;

        $filename = trim($data[0]);
        $description = trim($data[1]);

        if (file_exists($filename)) {
            $images[] = [
                "filename" => $filename,
                "description" => $description,
                "size" => filesize($filename),
                "date" => filemtime($filename)
            ];
        }
    }
    fclose($file);

    if (empty($images)) {
        return;
    }

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
            break;
    }

    echo "<div class='gallery'>";

    if ($mode == "matrix") {
        echo "<div class='matrix' id='matrix-gallery'>";
        foreach ($images as $img) {
            echo "<div class='img-container'>
                    <img src='{$img['filename']}' alt='Image'>
                    <p>{$img['description']}</p>
                  </div>";
        }
        echo "</div>";

        echo "<script>
                document.getElementById('matrix-gallery').style.display = 'flex';
                document.getElementById('matrix-gallery').style.flexWrap = 'wrap';
                document.getElementById('matrix-gallery').style.justifyContent = 'center';
                document.getElementById('matrix-gallery').style.gap = '10px';

                let containers = document.querySelectorAll('.img-container');
                containers.forEach(container => {
                    container.style.width = '30%'; // Ensures a row format
                    container.style.border = '1px solid black';
                    container.style.padding = '5px';
                    container.style.textAlign = 'center';
                });

                let images = document.querySelectorAll('.gallery img');
                images.forEach(img => {
                    img.style.width = '100%';
                    img.style.height = 'auto';
                    img.style.borderRadius = '5px';
                });
              </script>";
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
