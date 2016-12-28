<?php session_start();?>    <!--sida för att logga ut-->

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <title>Djurens Samarittjänst - logout</title>
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
if(isset($_SESSION['inloggad'])){
	unset($_SESSION['inloggad']);  //tar bort inloggningen
	echo "<h2>Utloggad!</h2>";
	echo "<p><a href='login.php'>Klicka här</a> för att logga in igen.</p>";
}
else
	echo "<p>Du har inte loggat in ännu: <a href='login.php'>Logga in</a></p>";    //om man försökt surfa direkt
?>

<?php require_once ("footer.inc.php");?>