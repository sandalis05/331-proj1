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

function proc_csv ($filename, $delimiter, $quote, $columns_to_show) {
  if (!file_exists($filename)) {
      echo "file does not exist";
      return;
  }

  $file = fopen($filename, "r");
  if (!$file) {
      echo "could not open file";
      return;
  }

  $headers = fgetcsv($file, 0, $delimiter, $quote);
  if (strtolower($columns_to_show) === "all") {
      $columns_to_display = range(0, count($headers) - 1);
  }
  else {
      $columns_to_display = array_map('intval', explode(':', $columns_to_show));
  }

  echo "<table border='1' style='border-collapse: collapse;'>\n";

  echo "<tr style='font-weight: bold;'>\n";
  foreach ($columns_to_display as $col_index) {
      if (isset($headers[$col_index])) {
          echo "<th>" . htmlspecialchars($headers[$col_index]) . "</th>\n";
      }
      else {
          echo "<th>missing header</th>\n";
      }
  }
  echo "</tr>\n";

  while (($row = fgetcsv($file, 0, $delimiter, $quote)) !== false) {
      echo "<tr>\n";
      foreach ($columns_to_display as $col_index) {
          if (isset($row[$col_index])) {
              echo "<td>" . htmlspecialchars($row[$col_index]) . "</td>\n";
          }
          else {
              echo "<td>missing data</td>\n";
          }
      }
      echo "</tr>\n";
  }

  echo "</table>\n";
  fclose($file);
}

// function proc_csv ($filename, $delimiter, $quote, $columns_to_show) {
//   if (!file_exists($filename)){
//     echo "error file not found";
//     return;
//   }

//   $file = fopen($filename, "r");

//   if (!$file) {
//     echo "error unable to open the file";
//     return;
//   }

//   $selected_columns = ($columns_to_show === "ALL") ? null : array_map('intval', explode(':', $columns_to_show));
//   echo '<table border="1">';
//   $row_index = 0;

//   while (($row = fgetcsv($file, 0, $delimiter, $quote)) !== false) {
//     echo $row_index === 0 ? '<tr style="font-weight: bold;">' : '<tr>';
//     $columns = $selected_columns ? array_intersect_key($row, array_flip(array_map(fn($i) => $i - 1, $selected_columns))) : $row;
//     foreach ($columns as $cell) {
//         echo '<td>' . htmlspecialchars($cell) . '</td>';
//     }
//     echo '</tr>';
//     $row_index++;
//   }

//   echo '</table>';
//   fclose($file);

// }

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
