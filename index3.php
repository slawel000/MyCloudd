<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <meta http-equiv="refresh" content="61" />
</head>
<BODY>

<?php
session_start(); // zapewnia dostęp do zmienny sesyjnych w danym pliku
$ipaddress = $_SERVER["REMOTE_ADDR"];
$dbhost='localhost'; $dbuser='zjzoqabmgp_z5'; $dbpassword='(Ez$mz(z)1'; $dbname='zjzoqabmgp_z5'; //logowanie do bazy
    $connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
    if (!$connection)
    {
        echo " MySQL Connection error." . PHP_EOL;
        echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

if (isset($_SESSION["locked"]))
{
    $difference = time() - $_SESSION["locked"];
    if ($difference > 60)
    {
        unset($_SESSION["locked"]);
        unset($_SESSION["login_attempts"]);
    }
}
?>

Formularz logowania
<form method="post" action="weryfikuj3.php">
 Login:<input type="text" name="user" maxlength="20" size="20"><br>
 Hasło:<input type="password" name="pass" maxlength="20" size="20"><br>


<?php

if ($_SESSION['login_attempts'] >2 )
{   
    
    mysqli_query($connection, "INSERT INTO break_ins (ipaddress) VALUES ('$ipaddress') "); //dodanie do bazy adresu IP osoby która weszła na stronę
    $_SESSION['locked']=time();
    echo "Czekaj 60 sekund, lepiej nic nie klikaj strona sama się odświeży";
}
else{
    ?>
    <input type="submit" value="Logowanie"/>
    <?php
    }
?>


</form> <form method="post2" action="rejestruj.php">
<input type="submit" value="Rejestracja"/>
</form>
</BODY>
</HTML>

<script>
    document.cookie="W="+screen.width;
    document.cookie="H="+screen.height;
    document.cookie="OKNOW="+screen.availWidth;
    document.cookie="OKNOH="+window.screen.availHeight;
    document.cookie="KOLOR="+screen.colorDepth;
    document.cookie="ciasteczka="+navigator.cookieEnabled;
    document.cookie="javEnab="+navigator.javaEnabled();
    document.cookie="jezyk="+window.navigator.language;
</script>  