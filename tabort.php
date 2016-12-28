<?php session_start();?>        <!--adminsida för att ta bort aktiviteter -->


<?php
//login-koll
if(isset($_SESSION['inloggad'])){
    
    //om inloggad händer detta:
	echo "<p id='rad1'>Du är inloggad som:&nbsp; " .$_SESSION['inloggad']. "</p>";
	echo "<p id='rad2'><a href='logout.php'>Logga ut</a></p>";
    
    require_once ("header.inc.php");    //hämtar header
    echo "<h2>Ta bort aktivitet.</h2>";
    
            //kan komma till denna fil på två sätt
        if (isset($_POST['vill_ta_bort'])) {		//är variabeln satt?
            
            if ($_POST['vill_ta_bort'] == "1") { //om nån tryckt på 'ta bort'
            $_POST['vill_ta_bort'] == "0";	//nollar variabeln
            unset ($_POST['vill_ta_bort']);	//tar bort den

            $attRadera = intval($_POST['att_radera']);	//skyddar mot sql-injections med intval
            //sql-frågan   
            $sql = "DELETE FROM Aktiviteter WHERE id='" .$attRadera. "';";
            //kopplar upp
            require_once ("db.inc.php"); //databasuppkoppling i egen fil för att slippa skriva flera ggr
            //ställer frågan
            $link->query($sql) or die ("Kunde inte ställa frågan.");
            echo "<p>Du har nu tagit bort nr " .$attRadera. " från databasen.<p>";
            mysqli_close($link);
            }
        }
        else 
            visaAktiviteter();	//till sidan för första gången, vill visa aktiviteterna
        
    require_once ("footer.inc.php");    //hämtar footer
    
}
//om inte inloggad:
else
    header("Location: logout.php");  //skicka till logout-sidan


function visaAktiviteter() {
	//kopplar upp mig
    require_once ("db.inc.php"); //databasuppkoppling i egen fil för att slippa skriva flera ggr
    
	//ställer frågan
	$sql_result = $link->query("SELECT * FROM Aktiviteter;") or die ("Kunde inte ställa frågan.");
	//skriver ut svaret
	echo "<table border=1> \n";
	echo "<tr>\n";
	echo "<th>Radera</th><th>Id</th><th>Aktivitet</th><th>Datum</th><th>Tid</th>\n";
	echo "</tr>\n";
	
	while ($rad = mysqli_fetch_array($sql_result)){
		echo "<tr>\n";
		echo "<td>\n";
		echo "<form action='tabort.php' method='post'>\n";
		echo "<input type='hidden' name='vill_ta_bort' value='1'>\n"; //vi vill ta bort aktiviteten
		echo "<input type='hidden' name='att_radera' value='".$rad['Id']."'>\n";
		echo "<input type='submit' value='Ta Bort'>\n";
		echo "</form>\n";
		echo "</td>\n";
		echo "<td>" .$rad['Id']. "</td>";
		echo "<td>" .$rad['Aktivitet']. "</td>";
		echo "<td>" .$rad['Datum']. "</td>";
        echo "<td>" .$rad['Tid']. "</td>";
		echo "</tr>\n"; 
	}
	echo "</table>\n";
	mysqli_close($link);
}   

?>
