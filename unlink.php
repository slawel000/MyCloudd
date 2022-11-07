
<?php

session_start(); // zapewnia dostęp do zmienny sesyjnych w danym pliku
$_SESSION ['id'];
$user_id=$_SESSION ['id'];
$userZal = $_SESSION ['user']; //user zalogowany
$nazwapliku = $_GET['nazwapliku'];// login z formularza

$fol_=$_GET['fol'];

$_SESSION['sciezka']=''.$userZal.'/'.$fol_.''.$nazwapliku.'';

$sciezka=$_SESSION['sciezka'];
//echo "<BR>";
//echo $sciezka;
//echo "<BR>";
if (!isset($_SESSION['loggedin']))
{
header('Location: index3.php'); //jeśli nikt się nie zalogował przenieś do formularza logowania
exit();
}
else
{   
    //echo $nazwapliku;
    //echo "<BR>";

    unlink('../z5/'.$sciezka); //usuwanie pliku
    echo "Usunięto plik: ";
    echo '../z5/'.$sciezka;
    echo "<BR>";
    echo '<a href=index1.php><img src=../z5/mac.JPG></a>';//sprawdzenie działania 

    //header('Location: index1.php'); //automatyczne przekierowanie
    $dbhost='localhost'; $dbuser='zjzoqabmgp_z5'; $dbpassword='(Ez$mz(z)1'; $dbname='zjzoqabmgp_z5'; //logowanie do bazy
    $connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
    if (!$connection)
    {
    echo " MySQL Connection error." . PHP_EOL;
    echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Error: " . mysqli_connect_error() . PHP_EOL;
    exit;
    }
    $result = mysqli_query($connection, "DELETE FROM messages WHERE user='$nazwapliku' AND user_id=$user_id AND message LIKE '../z5/$sciezka';") or die ("DB error: $dbname");
    mysqli_close($connection);
}
?>
