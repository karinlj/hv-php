<?php session_start();?>         <!--adminsida för att ändra aktiviteterna -->

<?php
//login-koll
if(isset($_SESSION['inloggad'])){
    
     //om inloggad händer detta
	echo "<p id='rad1'>Du är inloggad som:&nbsp; " .$_SESSION['inloggad']. "</p>";
	echo "<p id='rad2'><a href='logout.php'>Logga ut</a></p>";
   
    require_once ("header.inc.php");    //läser in header
    echo"<h2>Ändra uppgifter för en aktivitet.</h2>";
    
            //man vill ändra i databasen, man har tryckt på edit-knappen och kommer till förifyllda fält:

            if (isset($_POST['vill_editera'])) {		//är variabeln satt?
                if ($_POST['vill_editera'] == "1") { //om nån tryckt på 'edit'
                $_POST['vill_editera'] == "0";	//nollar variabeln

                //hämta in data från formuläret
                $id 	= htmlentities ($_POST['id']);    //htmlentities skyddar mot sql-injections
                $aktivitet	= htmlentities ($_POST['aktivitet']);
                $datum 	= htmlentities ($_POST['datum']);
                $tid 	= htmlentities ($_POST['tid']);


                //editerbara textrutor med förifylld info skrivs ut
                echo "<form action ='andra.php' method ='post'>";
                echo "<table border =0> \n";
                echo "	<tr><td>Aktivitet</td><td><input type='text' name='aktivitet' value='" .$aktivitet. "'></td></tr> \n";
                echo "	<tr><td>Datum</td><td><input type='text' name='datum' value='" .$datum. "'></td></tr> \n";
                echo "	<tr><td>Tid</td><td><input type='text' name='tid' value='" .$tid. "'></td></tr> \n";

                echo "	<tr><td rowspan='2'><input type='submit' value='Spara'></td></tr> \n";
                echo "	<tr><td rowspan='2'><input type='hidden' name='har_editerat' value='1'></td></tr> \n"; //value=1 betyder att jag tryckt på 'spara'
                echo "	<tr><td rowspan='2'><input type='hidden' name='attEditera' value='" .$id. "'></td></tr> \n"; 
                echo " </table> \n";
                echo " </form> \n";
                }
            } 
            //man har tryckt på spara-knappen och databasen uppdateras:
            else if (isset($_POST['har_editerat'])) {		//är variabeln satt?
                if ($_POST['har_editerat'] == "1") { //om nån tryckt på 'spara'
                $_POST['har_editerat'] == "0";	//nollar variabeln

                //hämta in data från formuläret
                $aktivitet	= htmlentities ($_POST['aktivitet']);
                $datum 	= htmlentities ($_POST['datum']);
                $tid 	= htmlentities ($_POST['tid']);
                $attEditera = intval ($_POST['attEditera']);

                //sql- frågan
                $sql = "UPDATE Aktiviteter SET " .
                    "Aktivitet=\"" .$aktivitet. "\", ".
                    "Datum=\"" .$datum. "\", ".
                    "Tid=\"" .$tid. "\" WHERE id=\"" .$attEditera. "\";";

                require_once ("db.inc.php"); //databasuppkoppling i egen fil för att slippa skriva flera ggr
                //ställer frågan
                $link->query($sql) or die ("Kunde inte ställa frågan.");
                echo "<p>Dina ändringar har sparats i databasen.</p>";
                //stänger kopplingen
                mysqli_close($link);
                }
            }	

            else   
                visaAktiviteter();//Första gången på sidan (se nedan)
    
    require_once ("footer.inc.php");    //läser in footer

}//om inte inloggad:
else
    header("Location: logout.php");  //skicka till logout-sidan
	
//man kan komma till filen på 3 sätt
//1. första gången på sidan - man vill se aktiviteterna
//2. vill fylla i nya uppgifter för aktiviteten - vill ha editerbara textrutor
//3. gör själva sql-frågan

function visaAktiviteter() { //Första gången på sidan. Visar aktiviteter med edit-knapp
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
		echo "<form action='andra.php' method='post'>\n";
		echo "<input type='hidden' name='vill_editera' value='1'>\n"; //vi vill ändra aktiviteten
		echo "<input type='hidden' name='id' value='".$rad['Id']."'>\n";  //sparar de gamla värdena för att slippa skriva dem igen
		echo "<input type='hidden' name='aktivitet' value='".$rad['Aktivitet']."'>\n";
		echo "<input type='hidden' name='datum' value='".$rad['Datum']."'>\n";
        echo "<input type='hidden' name='tid' value='".$rad['Tid']."'>\n";

		echo "<input type='submit' value='Edit'>\n";
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
