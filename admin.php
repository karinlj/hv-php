<?php session_start();?>    <!--startsida för administration-->

<?php 
//login-koll
if(isset($_SESSION['inloggad'])){
    
    //om inloggad händer detta:
	echo "<p id='rad1'>Du är inloggad som:&nbsp; " .$_SESSION['inloggad']. "</p>";
	echo "<p id='rad2'><a href='logout.php'>Logga ut</a></p>";
    require_once ("header.inc.php");    //läser in övre delen av sidan
    echo "<h2>Hjärtligt välkommen till Föreningen!</h2>";

    require_once ("footer.inc.php");    //läser in footern
}
//om man inte loggat in:
else
    header("Location: logout.php");  //skicka till logout-sidan
?>

   