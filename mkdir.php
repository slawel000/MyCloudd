
<?php
 $nazwapliku = $_POST['nazwapliku'];// login z formularza
 $user = htmlentities ($nazwapliku, ENT_QUOTES, "UTF-8"); // rozbrojenie potencjalnej bomby w zmiennej $user
session_start(); // zapewnia dostęp do zmienny sesyjnych w danym pliku
$_SESSION ['id'];
$user_id=$_SESSION ['id'];
$userZal = $_SESSION ['user']; //user wysyłajacy/zalogowany
if (!isset($_SESSION['loggedin']))
{
header('Location: index3.php'); //jeśli nikt się nie zalogował przenieś do formularza logowania
exit();
}
else
{
    mkdir ("../z5/$userZal/$nazwapliku", 0777);
    echo '<a href=index1.php><img src=../z5/mac.JPG></a>';
    echo "<a href=mk.php><img src=../z5/mk.JPG></a>"; echo "</BR>";

    $dbhost='localhost'; $dbuser='zjzoqabmgp_z5'; $dbpassword='(Ez$mz(z)1'; $dbname='zjzoqabmgp_z5'; //logowanie do bazy
    $connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
    if (!$connection)
    {
    echo " MySQL Connection error." . PHP_EOL;
    echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Error: " . mysqli_connect_error() . PHP_EOL;
    exit;
    }
    $sciezka="../z5/$userZal/folder";
    $result = mysqli_query($connection, "INSERT INTO messages (message, user, user_id, macierzysty) VALUES ('$sciezka', '$nazwapliku', '$user_id', 'tak');") or die ("DB error: $dbname");
    mysqli_close($connection);
}
?>
