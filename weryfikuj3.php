<?php
 $user = $_POST['user'];// login z formularza
 $user = htmlentities ($user, ENT_QUOTES, "UTF-8"); // rozbrojenie potencjalnej bomby w zmiennej $user
 $pass = $_POST['pass'];// hasło z formularza
 $pass = htmlentities ($pass, ENT_QUOTES, "UTF-8"); // rozbrojenie potencjalnej bomby w zmiennej $pass
 $link = mysqli_connect(localhost, 'zjzoqabmgp_z5', '(Ez$mz(z)1', 'zjzoqabmgp_z5'); // połączenie z BD – wpisać swoje dane
 if(!$link) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); } // obsługa błędu połączenia z BD
 mysqli_query($link, "SET NAMES 'utf8'"); // ustawienie polskich znaków
 $result = mysqli_query($link, "SELECT * FROM users WHERE username='$user'"); // wiersza, w którym login=login z formularza
 $rekord = mysqli_fetch_array($result); // wiersza z BD, struktura zmiennej jak w BD
 if(!$rekord) //Jeśli brak, to nie ma użytkownika o podanym loginie
 {
 mysqli_close($link); // zamknięcie połączenia z BD
 echo "Brak użytkownika o takim loginie !"; // UWAGA nie wyświetlamy takich podpowiedzi dla hakerów
echo "<p><a href=index3.php>Spróbuj zalogować się ponownie.</a></p>"; 
}
 else
 { // jeśli $rekord istnieje
 if($rekord['password']==$pass) // czy hasło zgadza się z BD
 {
 echo "Logowanie Ok. User: {$rekord['username']}. Hasło: {$rekord['password']}";
session_start();
$_SESSION ['loggedin'] = true; //zmienne sesyjne
$_SESSION ['id'] = $rekord['id'];
$_SESSION ['user'] = $rekord['username'];
$_SESSION ['login_attempts']=0;
header('Location: indexgeo.php');
 }
 else
 {
 mysqli_close($link);
 echo "Błąd w haśle !"; // UWAGA nie wyświetlamy takich podpowiedzi dla hakerów
 session_start();
 $_SESSION ['login_attempts'] +=1;

  header('Location: index3.php');
 }
 }
?>