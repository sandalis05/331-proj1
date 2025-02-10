<?php
require_once("proc_gallery.php");

$image_list_filename = "images.csv"; 
$mode = isset($_GET['mode']) ? $_GET['mode'] : "matrix"; 
$sort_mode = isset($_GET['sort']) ? $_GET['sort'] : "orig"; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>
    <script>
        function updateView() {
            const mode = document.getElementById("mode").value;
            const sort = document.getElementById("sort").value;
            window.location.href = `gallery.php?mode=${mode}&sort=${sort}`;
        }

        function applyStyles() {
            document.body.style.fontFamily = "Arial, sans-serif";

            let gallery = document.querySelector(".gallery");
            if (gallery) {
                gallery.style.display = "flex";
                gallery.style.flexWrap = "wrap";
                gallery.style.gap = "10px";
            }

            let imgContainers = document.querySelectorAll(".img-container");
            imgContainers.forEach(container => {
                container.style.border = "1px solid black";
                container.style.padding = "5px";
                container.style.textAlign = "center";
            });

            let images = document.querySelectorAll(".gallery img");
            images.forEach(img => {
                img.style.width = "150px";
                img.style.height = "auto";
                img.style.borderRadius = "5px";
            });

            let listItems = document.querySelectorAll(".list-view li");
            listItems.forEach(li => {
                li.style.display = "flex";
                li.style.alignItems = "center";
                li.style.margin = "10px 0";
            });

            let table = document.querySelector(".details-view");
            if (table) {
                table.style.width = "100%";
                table.style.borderCollapse = "collapse";
            }

            let ths = document.querySelectorAll(".details-view th");
            ths.forEach(th => {
                th.style.border = "1px solid black";
                th.style.padding = "8px";
                th.style.textAlign = "left";
                th.style.backgroundColor = "#f0f0f0";
            });

            let tds = document.querySelectorAll(".details-view td");
            tds.forEach(td => {
                td.style.border = "1px solid black";
                td.style.padding = "8px";
            });
        }

        window.onload = applyStyles;
    </script>
</head>
<body>

<h2>Image Gallery</h2>

<label for="mode">View Mode:</label>
<select id="mode" onchange="updateView()">
    <option value="matrix" <?= $mode == "matrix" ? "selected" : "" ?>>Matrix</option>
    <option value="list" <?= $mode == "list" ? "selected" : "" ?>>List</option>
    <option value="details" <?= $mode == "details" ? "selected" : "" ?>>Details</option>
</select>

<label for="sort">Sort By:</label>
<select id="sort" onchange="updateView()">
    <option value="orig" <?= $sort_mode == "orig" ? "selected" : "" ?>>Original</option>
    <option value="date_newest" <?= $sort_mode == "date_newest" ? "selected" : "" ?>>Newest First</option>
    <option value="date_oldest" <?= $sort_mode == "date_oldest" ? "selected" : "" ?>>Oldest First</option>
    <option value="size_largest" <?= $sort_mode == "size_largest" ? "selected" : "" ?>>Largest First</option>
    <option value="size_smallest" <?= $sort_mode == "size_smallest" ? "selected" : "" ?>>Smallest First</option>
    <option value="rand" <?= $sort_mode == "rand" ? "selected" : "" ?>>Random</option>
</select>

<hr>


<?php
proc_gallery($image_list_filename, $mode, $sort_mode);
?>

</body>
</html>
