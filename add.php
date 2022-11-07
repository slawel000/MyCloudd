<?php
session_start(); // zapewnia dostęp do zmienny sesyjnych w danym pliku
$time = date('H:i:s', time());
$user = $_POST['user'];
$post = $_POST['post'];
$userZal = $_SESSION ['user']; //user zalogowany/wysyłajacy
if (IsSet($_POST['post']))
{
$dbhost='localhost'; $dbuser='zjzoqabmgp_z5'; $dbpassword='(Ez$mz(z)1'; $dbname='zjzoqabmgp_z5'; //logowanie do bazy
$connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
if (!$connection)
{
echo " MySQL Connection error." . PHP_EOL;
echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
echo "Error: " . mysqli_connect_error() . PHP_EOL;
exit;
}
$result = mysqli_query($connection, "INSERT INTO messages (message, user, recipient) VALUES ('$post', '$userZal', '$user');") or die ("DB error: $dbname");
mysqli_close($connection);
}
header ('Location: index1.php');
?>