<?php
$connection = mysqli_connect($host, $dbUser, $dbPass);
if (!$connection) {
 echo "Faild to connect to database: " . die(mysqli_error($connection));
}
$dbselect = mysqli_select_db($connection, $dbName);
if(!$dbselect){
  echo "Faild to select database: " . die(mysqli_error($connection));
}

?>
