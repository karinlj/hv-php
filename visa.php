<?php session_start();?>    <!--adminsida för att visa aktiviteterna -->

<?php 
//login-koll
if(isset($_SESSION['inloggad'])){
    
    //om inloggad händer detta:
	echo "<p id='rad1'>Du är inloggad som:&nbsp; " .$_SESSION['inloggad']. "</p>";
	echo "<p id='rad2'><a href='logout.php'>Logga ut</a></p>";
    
    require_once ("header.inc.php");        //läser in header
    echo "<h2>Här är våra aktiviteter!</h2>";
    visaAktiviteter();
    require_once ("footer.inc.php");        //läser in footer

}
//om man inte är inloggad
else
    header("Location: logout.php");  //skicka till logout-sidan

function visaAktiviteter() {
	//kopplar upp mig
    require_once ("db.inc.php"); //databasuppkoppling i egen fil för att slippa skriva flera ggr
	//ställer frågan
	$sql_result = $link->query("SELECT * FROM Aktiviteter;") or die ("Kunde inte ställa frågan.");
	//skriver ut svaret
	echo "<table border=1>";
	echo "<tr>";
	echo "<th>Id</th><th>Aktivitet</th><th>Datum</th><th>Tid</th>";
	echo "</tr>";
	
	while ($rad = mysqli_fetch_array($sql_result)){
		echo "<tr>";
		echo "<td>" .$rad['Id']. "</td> \n";
		echo "<td>" .$rad['Aktivitet']. "</td> \n";
		echo "<td>" .$rad['Datum']. "</td> \n";
        echo "<td>" .$rad['Tid']. "</td> \n";

		echo "</tr>"; 
	}
	echo "</table>";
	mysqli_close($link);
}   

?>
