<a href=indexgeo.php>Zobacz historię logowania</a><br>
Witaj na swoim dysku. 

<?php
session_start(); // zapewnia dostęp do zmienny sesyjnych w danym pliku

$userZal = $_SESSION ['user']; //user wysyłajacy/zalogowany
$user_id= $_SESSION ["id"];

$_SESSION['sciezka']="../z5/$userZal";
echo "<BR>";
echo "Ścieżka, w której akutalnie jesteś: ";
$dobazy="../z5/$userZal";
echo $dobazy;

if (!isset($_SESSION['loggedin']))
{
header('Location: index3.php'); //jeśli nikt się nie zalogował przenieś do formularza logowania
exit();
}
else
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
echo "<p> Jestem zalogowany jako " . $_SESSION ["user"] . " </p>" ; 
echo "<a href=mk.php><img src=../z5/mk.JPG></a>";
echo "<a href=select.php><img src=../z5/uplo.JPG></a>"; echo "</BR>";



    $result = mysqli_query($connection, "Select * from messages WHERE user_id=$user_id AND macierzysty='tak';") or die ("DB error: $dbname");//dla admina wyświetl wszystkie wiadomości
    print "<TABLE CELLPADDING=5 BORDER=1>";
    print "<TR><TD>id</TD><TD>Nazwa</TD><TD>plik</TD><TD>Usuwanie</TD></TR>\n";
    $i=0;
    while ($row = mysqli_fetch_array ($result))
    {
    $id = $row[0];
    //$date = $row[1];
    $message= $row[2];
    $sciez=$row[2];
    $nazwa = $row[3];

    if(substr($message, -4)==('.PNG') || substr($message, -4)==('.JPG') || substr($message, -4)==('.gif')){
        $message="<a href='$message'</a> <img src='$message'/>";
    }
    if(substr($message, -4)=='.mp3'){
        $message="<a href='$message'</a> <audio controls src='$message'/>";
    }
    if(substr($message, -4)=='.mp4'){
        $message="<a href='$message'</a> <video controls src='$message'/>";
    }
   
    //echo "<a href=/z5/rm.JPG </a> <img src='/z5/rm.JPG'>";


    if($message=='../z5/'.$userZal.'/folder'){
        $pobranie="<a href=index2.php?nazwafolderu=$nazwa>$nazwa</a>";   
        //$pobranie="<a href=$sciez>$nazwa</a>";                      
        $kasuj='<center>    <a href="rmdir.php?nazwafolderu='.$nazwa.'"><input type="image" src=../z5/rm.JPG></a>';
    }
    else{
        //$pobranie=$nazwa;             
        $pobranie="<a href=$sciez download>$nazwa</a>";
        $kasuj='<center>    <a href="unlink.php?nazwapliku='.$nazwa.'"><input type="image" src=../z5/rm.JPG></a>';
    }
    $i=$i+1;
    print "<TR><TD>$id</TD><TD>$pobranie</TD><TD>$message</TD><TD>$kasuj</a></TD></TR>\n";
    }
    
    print "</TABLE>";
    




mysqli_close($connection);
echo "<p><a href=logout.php>Link do pliku umożliwiający wylogowanie</a></p>";


}
?>





