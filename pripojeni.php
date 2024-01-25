<?php
$servername = "localhost";
$username = "root";
$password = "";
$databaze='dynamicka';

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully<br><br>";

mysqli_select_db($conn ,$databaze) or die(mysqli_error($conn));
mysqli_query($conn, 'SET NAMES UTF8');
mysqli_query($conn, 'SET COLLATION_CONNECTION=utf8_czech_ci');
?>
