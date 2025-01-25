<html>
<body>

<h1>Action.php</h1>

This page can be called by other PHP scripts or from itself. 

<p/>

<?php

# Function
function proc_action($mode) {
  
  echo "<font color=\"green\">Calling function proc_action(): The \$mode was $mode </font> <p/>\n";

}

proc_action($_GET["getName"]);

function proc_csv($filename, $delimiter, $quote, $columns_to_show) {
  if (!file_exists($filename)) {
      echo "file does not exist";
      return;
  }

  $file_handle = fopen($filename, "r");
  if ($file_handle === false) {
      echo "error unavle to open file";
      return;
  }

  $header_row = fgetcsv($file_handle, 0, $delimiter, $quote);
  if (strtolower($columns_to_show) === "all") {
      $selected_columns = array_keys($header_row);
  } else {
    $selected_columns = array_map(function($col) {
      return $col - 1;
    }, array_map('intval', explode(':', $columns_to_show)));
  }

  echo "<table border='1' style='border-collapse: collapse;'>";

  echo "<tr style='font-weight: bold;'>";
  foreach ($selected_columns as $index) {
      $header_value = $header_row[$index] ?? "N/A";
      echo "<th>" . htmlspecialchars($header_value) . "</th>";
  }
  echo "</tr>";

  while (($row = fgetcsv($file_handle, 0, $delimiter, $quote)) !== false) {
      echo "<tr>";
      foreach ($selected_columns as $index) {
          $cell_value = $row[$index] ?? "N/A";
          echo "<td>" . htmlspecialchars($cell_value) . "</td>";
      }
      echo "</tr>";
  }

  echo "</table>";
  fclose($file_handle);
}


# Test function call
proc_action($_GET["getName"]);



# URL usage: action.php?getName=string
if ($_GET["getName"]) {
  echo "<font color=\"red\">The GET keyword was ".$_GET["getName"]."</font>\n";
}

# URL usage: action.php
if ($_POST["name"]) {
  echo "<font color=\"blue\">The POST keyword was ".$_POST["name"]."</font>\n";
}

?>

<p/>

<!-- GET form method testing area ................................ --> 
<form action="action.php" method="get">
GET method test (on self): <input type="text" name="getName">
<input type="Submit">
</form>

<!-- POST form method testing area ................................ --> 
<form action="action.php" method="post">
POST method test (on self): <input type="text" name="name">
<input type="Submit">
</form>

</body>
</html>
