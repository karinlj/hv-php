<?php session_start();?>    <!--sida för login till administrationssidan-->
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <title>Djurens Samarittjänst  - login</title>
        <link rel="stylesheet" type="text/css" href="stil.css" />
    </head>

    <body>
        <div id="wrapper">
        <header>
        <h1 id="site-title"><a href="index.php" title='Hem'>Föreningen Djurens Samarittjänst</a></h1>

        </header>
        <section>
            <article>
<?php
	//man vill logga in
	if(isset($_POST['vill_logga_in']) && $_POST['vill_logga_in'] == "1") {
			$_POST['vill_logga_in'] = 0;
            $username = htmlentities( $_POST['txt_username']);  //htmlentities skyddar mot sql-injections
            $pass = htmlentities( $_POST['txt_password']) ;
            $enc_pass = hash ("MD5", $pass); //hash med 128 bitars säkerhet sparas i variabel
            
            require_once ("db.inc.php"); //databasuppkoppling i egen fil för att slippa skriva flera ggr
        
            $sql = "SELECT * FROM Users WHERE db_username= '$username' AND db_pass= '$enc_pass';";  //sql-frågan
            //echo $sql;// utskrift för koll,ok
            $result = $link->query($sql) or die ("Kunde inte ställa frågan");       //ställer sql-frågan
            
            if(mysqli_num_rows($result) == 1) {     //om resultatet är en rad
                $_SESSION['inloggad'] = $username;
                header("Location: admin.php");  //skicka till adminsidan
            }
            else
                echo "<p>Fel login. <a href='login.php'>Försök igen</a></p>";
	        mysqli_close($link);

		
	}
	else {		//1:a gången på sidan, vill ha formulär
		echo '
		<h1>Inloggning</h1>
		<form action="login.php" method="post">
       
			<p>Användarnamn: <input class="login" type"text" name="txt_username"></p>
			<p>Lösenord:  <input class="login" type"text" name="txt_password"></p>
                    <p></p>
			<input type="submit" value="Logga in">
			<input type="hidden" name="vill_logga_in" value="1">
			
		</form>
		';

	}
?>
<?php require_once ("footer.inc.php");?>