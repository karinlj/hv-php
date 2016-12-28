<?php session_start();?>         <!--adminsida för att lägga till aktiviteter -->

<?php
//login-koll
if(isset($_SESSION['inloggad'])){
    
    //om inloggad händer detta:
	echo "<p id='rad1'>Du är inloggad som:&nbsp; " .$_SESSION['inloggad']. "</p>";
	echo "<p id='rad2'><a href='logout.php'>Logga ut</a></p>";
    
    require_once ("header.inc.php");    //header läses in
    echo "<h2>Lägg till aktivitet.</h2>";

    
            //man vill lägga till i databasen
        if (isset($_POST['vill_lagga_till'])) {		//är variabeln satt?
            if ($_POST['vill_lagga_till'] == "1") { //om nån tryckt på 'skicka'
            $_POST['vill_lagga_till'] == "0";	//nollar variabeln
            unset ($_POST['vill_lagga_till']);	//tar bort den

            //hämta in data från formuläret
            $aktivitet	= htmlentities ($_POST['aktivitet']);
            $datum 	= htmlentities ($_POST['datum']);
            $tid 	= htmlentities ($_POST['tid']);


            //sql-frågan
            $sql = "INSERT INTO Aktiviteter
                    (Aktivitet, Datum, Tid) 
                    VALUES ('$aktivitet', '$datum', '$tid');";

            //koppla upp 
            require_once ("db.inc.php"); //databasuppkoppling i egen fil för att slippa skriva flera ggr

            //ställer frågan
            $link->query($sql) or die ("Kunde inte ställa frågan.");    
                echo "<p>Du har nu lagt till aktiviteten " .$aktivitet. " i databasen.<p>";
            mysqli_close($link);
            }

            }
            else {
                //om man ej förut varit på sidan skall formulär ritas ut (se ovan)
                ritaFormular();
            }

    require_once ("footer.inc.php");    //footer läses in
}
//om man inte loggat in
else
    header("Location: logout.php");  //skicka till logout-sidan


//man kan komma till filen på 2 sätt
function ritaformular () {
	echo "<form action ='laggtill.php' method ='post'>";
	echo "<table border =0> \n";
	echo "	<tr><td>Aktivitet</td><td><input type='text' name='aktivitet'></td></tr> \n";
	echo "	<tr><td>Datum</td><td><input type='text' name='datum'></td></tr> \n";
    echo "	<tr><td>Tid</td><td><input type='text' name='tid'></td></tr> \n";

	echo "	<tr><td rowspan='2'><input type='submit' value='Lägg till'></td></tr> \n";
	echo "	<tr><td rowspan='2'><input type='hidden' name='vill_lagga_till' value='1'></td></tr> \n"; //value=1 betyder att jag tryckt på 'skicka'
	echo " </table> \n";
	echo " </form> \n";
}

?>
