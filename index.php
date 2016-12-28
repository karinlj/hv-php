<?php session_start();?>    <!--Föreningens startsida-->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Djurens Samarittjänst - start</title>
        <link rel="stylesheet" type="text/css" href="stil.css" />
        <script type="text/javascript" src="jquery.js"></script>

        <script>
            $(document).ready(function(){
                //funktion för att få fram texten under 'månadens katt'
                $( "#katt" ).click(function() {         
                    $( "#info1" ).slideToggle( "slow");
                });
               
            });
            
            //funktion för att läsa in bilder med Ajax
            function talkToServer(cat) {
                //console.log("vald katt: " + cat);
                 $.ajax ({
                    url: "bilder.php",
                    data: "cat=" + cat,
                    type: "get",
                    success: function (output) {
                      $('#result').html (output);
                    }
                }); 
            }
           
        </script>
    </head>
    <body>
        <div id="wrapper">
        <header>
        <h1 id="site-title"><a href="index.php" title='Hem'>Föreningen Djurens Samarittjänst</a></h1>
        
        <nav>   <!--Navigeringen är bara för syns skull-->
            <ul>    
                <li id="login"><a href="#">Våra katter</a></li>
                <li id="login"><a href="#">Om oss</a></li>
                <li id="login"><a href="#">Stöd oss</a></li>
                <li id="login"><a href="#">Bli volontär</a></li>
                
            </ul>
        </nav>
        </header>
        <section>
            <article>
				<h2>Hjärtligt välkommen till Föreningen!</h2>
                <p id='brodtext'>Vi är en ideell förening som tar hand om och omplacerar hemlösa katter. Vi finns i Gråbo utanför
                    Göteborg. Vill du så kan du hjälpa oss genom att bli volontär hos oss, skänka en gåva eller bli medlem och vara fadder till en katt.</p>
                
                <?php
                //login -koll 
                if(isset($_SESSION['inloggad'])){
                   //om inloggad händer detta: 
	               echo "<p id='rad1'>Du är inloggad som:&nbsp; " .$_SESSION['inloggad']. "</p> \n";
                   echo "<p id='rad2'><a href='admin.php'>Tillbaka till adminsidan</a></p> \n";
	               echo "<p id='rad3'><a href='logout.php'>Logga ut</a></p> \n";
                }//om ej inloggad:
                else
                   echo "<p id='rad1'><a href='login.php'>Logga in</a></p> \n";
                
                
                //visa bilden 'månadens katt':
                require_once ("db.inc.php");  //kopplar upp till databasen med fil
                
                $myImage = $link->query("SELECT * FROM Bilder WHERE id = 4;");    //ställer frågan
                
                 $rad = mysqli_fetch_array($myImage);     //vill bara ha en rad 
                 $filnamn = $rad ['Filnamn'];    //vill ha ett filnamn
                 $alt = $rad['AltText'];         //vill ha alt-texten
                
                echo "<h3 id='katt'>Månadens katt: " .$alt. "</h3> \n";
                echo "<div id='info1'><p>Hugo hittades vid motorvägen, utan märkning, smutsig och mager. Nu har han fått nytt hem och är en glad och frisk katt!</p></div>";

                echo "<img src='bilder/" .$filnamn. "' alt='" .$alt. "' > \n"; //skriver ut bilden och texten
              
                
               //visar 5 st aktiviteter som inte har passerat dagens datum
               $datumIdag = date('Y-m-d');
               
               $sql_result = $link->query("SELECT * FROM Aktiviteter WHERE Datum >= '" .$datumIdag. " ' LIMIT 5;") or die ("Kunde inte ställa frågan.");
                
	           //skriver ut svaret
	           echo "<table border=1> \n";
	           echo "<tr> \n";
	           echo "<th>Aktivitet</th><th>Datum</th><th>Tid</th> \n";
               echo "<h2>Våra aktiviteter under våren</h2> \n";            
	           echo "</tr> \n";
	
	           while ($rad = mysqli_fetch_array($sql_result)){
		          echo "<tr> \n";
		          echo "<td id='akt'>" .$rad['Aktivitet']. "</td> \n";

		          echo "<td>" .$rad['Datum']. "</td> \n";
                      
                  echo "<td>" .$rad['Tid']. "</td> \n";

		          echo "</tr> \n"; 
	           }
                
	           echo "</table> \n";
               mysqli_close($link);
              
                
                //bilder som läses in med Ajax:    
                echo'<span onmouseover="talkToServer(1);" onmouseout="talkToServer(0);">December månads katt: Filip</span><br>';
                echo '<p></p>';
                echo'<span onmouseover="talkToServer(2);" onmouseout="talkToServer(0);">Januari månads katt: Loke</span><br>';
                echo'<div id="result"></div>';
                   
                    
 require_once ("footer.inc.php");
 ?>