<head>
</head>
<body>
Historia logowania i geolokalizacja.
 </body>
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
<?php 
session_start(); // zapewnia dostęp do zmienny sesyjnych w danym pliku
$width=$_COOKIE['W'];
$height=$_COOKIE['H'];
$availWidth=$_COOKIE['OKNOW'];
$availHeight=$_COOKIE['OKNOH'];
$colorDepth=$_COOKIE['KOLOR'];
$ciastka=$_COOKIE['ciasteczka'];
$java=$_COOKIE['javEnab'];
$jezyk=$_COOKIE['jezyk'];

//echo 'testuje';
//echo '<BR />';
//echo $width; echo '<BR />';
//echo $height; echo '<BR />';
//echo $availWidth; echo '<BR />';
//echo $availHeight; echo '<BR />';
//echo $colorDepth; echo '<BR />';
//echo $ciastka; echo '<BR />';
//echo $java; echo '<BR />';
//echo $jezyk; echo '<BR />';

 
echo "<p><a href=index1.php>Link do dysku</a></p>";
echo "<p><a href=logout.php>Link do pliku umożliwiający wylogowanie</a></p>";

if (!isset($_SESSION['loggedin']))
{
header('Location: index3.php'); //jeśli nikt się nie zalogował przenieś do formularza logowania
exit();
}
else
{
echo "<p> Jestem zalogowany jako " . $_SESSION ["user"] . " o id=" . $_SESSION ["id"] . ".</p>" ;
$id2=$_SESSION ["id"];
$userZal=$_SESSION ["user"]; //zmienne z zmiennych sesyjnych

    $dbhost='localhost'; $dbuser='zjzoqabmgp_z5'; $dbpassword='(Ez$mz(z)1'; $dbname='zjzoqabmgp_z5'; //logowanie do bazy
    $polaczenie = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);

     if (!$polaczenie) {
        echo "Błąd połączenia z MySQL." . PHP_EOL;
        echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    else{
        //echo "Twoje dane:"; echo '<BR />';
        $ipaddress = $_SERVER["REMOTE_ADDR"];
        //function ip_details($ip) {
        //$json = file_get_contents ("http://ipinfo.io/{$ip}/geo");
        //$details = json_decode ($json);
        //return $details;
        //}
        //$details = ip_details($ipaddress);
        //echo $details -> region; echo '<BR />';
        //echo $details -> country; echo '<BR />';
        //echo $details -> city; echo '<BR />';
        //echo $details -> loc; echo '<BR />';
        //echo $details -> ip; echo '<BR />';

        //echo $_SERVER['HTTP_USER_AGENT'];
        //$mybrowser = get_browser(null, true);
        //print_r($mybrowser);echo '<BR />';
        //echo $mybrowser -> browser; echo '<BR />';

        function get_browser_name($user_agent) {
            if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
            elseif (strpos($user_agent, 'Edge')) return 'Edge';
            elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
            elseif (strpos($user_agent, 'Safari')) return 'Safari';
            elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
            elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'Internet Explorer';
        
            return 'Other';
        }
        //echo get_browser_name($_SERVER['HTTP_USER_AGENT']);
        $przegladarka = get_browser_name($_SERVER['HTTP_USER_AGENT']);
        
        mysqli_query($polaczenie, "INSERT INTO goscieportalu (ipaddress, user_id, browser, width, height, availWidth, availHeight, colorDepth, ciastka, java, jezyk  ) VALUES ('$ipaddress', '$id2', '$przegladarka', '$width', '$height', '$availWidth', '$availHeight', '$colorDepth', '$ciastka', '$java', '$jezyk') "); //dodanie do bazy adresu IP osoby która weszła na stronę
        if ($userZal == admin){ //jeśli zalogowany jest admin
            $rezultat = mysqli_query($polaczenie, "SELECT * FROM goscieportalu ") or die ("Błąd zapytania do bazy: $dbname");//dla admina wyświetl wszystkie logi
             }
             else{ //jeśli ktoś inny niż admin jest zalogowany
                $rezultat = mysqli_query($polaczenie, "SELECT * FROM goscieportalu where user_id=$id2") or die ("Błąd zapytania do bazy: $dbname");
              }
        //$rezultat = mysqli_query($polaczenie, "SELECT * FROM goscieportalu where user_id=$id2") or die ("Błąd zapytania do bazy: $dbname");
        print "<TABLE CELLPADDING=5 BORDER=1>";
        print "<TR><TD>id</TD><TD>ip</TD><TD>data</TD><TD>współrzędne</TD><TD>lokalizacja</TD><TD>kraj</TD><TD>miasto</TD><TD>uzytkownik</TD><TD>przegladarka</TD><TD>ekran</TD><TD>okno</TD><TD>kolory</TD><TD>ciasteczka</TD><TD>java</TD><TD>jezyk</TD></TR>\n";
        while ($wiersz = mysqli_fetch_array ($rezultat)) {
            $id = $wiersz[0];
            $adresIP = $wiersz[1];
            $date = $wiersz[2];
            $userID=$wiersz[3];
            $przegl=$wiersz[4];
            $width2=$wiersz[5];
            $height2=$wiersz[6];
            $availWidth2=$wiersz[7];
            $availHeight2=$wiersz[8];
            $colorDepth2=$wiersz[9];
            $ciastka2=$wiersz[10];
            $java2=$wiersz[11];
            $jezyk2=$wiersz[12];
            
                $json = file_get_contents ("http://ipinfo.io/{$adresIP}/geo");
                $details = json_decode ($json);
                
                $lok=$details -> loc;
                $kraj=$details -> country;
                $miasto=$details -> city;

                $zapytanie= mysqli_query($polaczenie, "SELECT username FROM users WHERE id='$userID' ") or die ("Błąd zapytania do bazy: $dbname");
                $uzytkownik=mysqli_fetch_array ($zapytanie);

            print "<TR><TD>$id</TD><TD>$adresIP</TD><TD>$date</TD><TD>$lok</TD><TD><a href='https://www.google.pl/maps/place/$lok'>LINK</a> </TD><TD>$kraj</TD><TD>$miasto</TD><TD>$uzytkownik[0]</TD><TD>$przegl</TD><TD>$width2 x $height2</TD><TD>$availWidth2 x $availHeight2</TD><TD>$colorDepth2</TD><TD>$ciastka2</TD><TD>$java2</TD><TD>$jezyk2</TD></TR>\n";
        }
        print "</TABLE>";
        echo "<BR>";
        echo "Historia prób logowania";
        $break_ins = mysqli_query($polaczenie, "SELECT * FROM break_ins ") or die ("Błąd zapytania do bazy: $dbname");//dla admina wyświetl wszystkie logi
        print "<TABLE CELLPADDING=5 BORDER=1 bgcolor=red>";
        print "<TR><TD>id</TD><TD>ip</TD><TD>data</TD></TR>\n";
        while ($wiersze = mysqli_fetch_array ($break_ins)) {
            $id_x=$wiersze[0];
            $date_x=$wiersze[1];
            $ipaddress_x=$wiersze[2];

            print "<TR><TD>$id_x</TD><TD>$date_x</TD><TD>$ipaddress_x</TD></TR>";
        }




       
        mysqli_close($polaczenie);
    }
}
?>