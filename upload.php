<?php
session_start(); // zapewnia dostęp do zmienny sesyjnych w danym pliku
$_SESSION ['id'];
$user_id=$_SESSION ['id'];
$userZal = $_SESSION ['user'];

$user = $_POST['user'];

if (!isset($_SESSION['loggedin']))
{
header('Location: index3.php'); //jeśli nikt się nie zalogował przenieś do formularza logowania
exit();
}
else
{
    echo "Zalogowanay jako: $userZal"; echo "</BR>"; 
    
$target_dir = $_SESSION['sciezka'];

echo "Ścieżka, w której akutalnie jesteś: ";
echo $target_dir;
echo "<BR>";
$plik=basename($_FILES["fileToUpload"]["name"]);
$target_file = $target_dir . "/". basename($_FILES["fileToUpload"]["name"]);
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
 { echo htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " uploaded "; 
    echo "do twojego folderu $target_file";}
 else { echo "Error uploading file.";}

$dbhost='localhost'; $dbuser='zjzoqabmgp_z5'; $dbpassword='(Ez$mz(z)1'; $dbname='zjzoqabmgp_z5'; //logowanie do bazy
$connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
if (!$connection)
{
echo " MySQL Connection error." . PHP_EOL;
echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
echo "Error: " . mysqli_connect_error() . PHP_EOL;
exit;
}

if ($target_dir=='../z5/'.$userZal){
    $result = mysqli_query($connection, "INSERT INTO messages (message, user, user_id, macierzysty) VALUES ('$target_file', '$plik', '$user_id', 'tak');") or die ("DB error: $dbname");
}
else{
    $result = mysqli_query($connection, "INSERT INTO messages (message, user, user_id, macierzysty) VALUES ('$target_file', '$plik', '$user_id', 'nie');") or die ("DB error: $dbname");
}

mysqli_close($connection);
echo "<BR>";
echo "<a href=index1.php><img src=../z5/mac.JPG></a>";
echo "<a href=select.php><img src=../z5/uplo.JPG></a>"; echo "</BR>";
//echo "<p><a href=index1.php>Wróć do komunikatora</a></p>";
}
?>
