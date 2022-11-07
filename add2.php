<?php //rejestracja
 $user = $_POST['user'];// login z formularza
 $user = htmlentities ($user, ENT_QUOTES, "UTF-8"); // rozbrojenie potencjalnej bomby w zmiennej $user
 $pass = $_POST['pass'];// hasło z formularza
 $pass = htmlentities ($pass, ENT_QUOTES, "UTF-8"); // rozbrojenie potencjalnej bomby w zmiennej $pass
 $pass2 = $_POST['pass2'];// hasło z formularza
 $pass2 = htmlentities ($pass2, ENT_QUOTES, "UTF-8"); // rozbrojenie potencjalnej bomby w zmiennej $pass


 $link = mysqli_connect(localhost, 'zjzoqabmgp_z5', '(Ez$mz(z)1', 'zjzoqabmgp_z5'); // połączenie z BD – wpisać swoje dane
 if(!$link) { echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error(); } // obsługa błędu połączenia z BD
 mysqli_query($link, "SET NAMES 'utf8'"); // ustawienie polskich znaków


 $result = mysqli_query($link, "SELECT * FROM users WHERE username='$user'"); // wiersza, w którym login=login z formularza
 $rekord = mysqli_fetch_array($result); // wiersza z BD, struktura zmiennej jak w BD

 if($rekord) //Jeśli istnieje użytkownik o podanym loginie
 {
 mysqli_close($link); // zamknięcie połączenia z BD
 echo "Użytkownik o takim loginie już istnieje!"; // UWAGA nie wyświetlamy takich podpowiedzi dla hakerów
echo "<p><a href=rejestruj.php>Spróbuj zarejestrować się ponownie.</a></p>"; 
}
 else
 { // jeśli $rekord nie istnieje 
 if($pass==$pass2) // czy hasło zgadza się z powtórz hasło
 {

mysqli_query($link, "INSERT INTO users (username, password)
VALUES ('$user','$pass') ");
mkdir ("../z5/$user", 0777);

 echo "Poprawnie zarejestrowano użytkownika. User: $user. Hasło: $pass";
echo "<p><a href=index3.php>Teraz możesz się zalogować.</a></p>"; 
echo "<p><a href=rejestruj.php>Stwórz kolejnego użytkownika.</a></p>"; 
 }
 else
 {
 mysqli_close($link);
 echo "HASŁA SĄ RÓŻNE !"; // UWAGA nie wyświetlamy takich podpowiedzi dla hakerów
  echo "<p><a href=rejestruj.php>Spróbuj zarejestrować się ponownie.</a></p>";
 }
 }
?>







