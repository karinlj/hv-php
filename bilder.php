<?php

 $cat = $_GET['cat'];
                
     //vilken bild som ska visas beror på inparametern i funktionen talkToSever() i index.php      
switch ($cat) {
    case "0":  echo "<img src='bilder/farg.jpg'>"; break;
    case "1":  echo "<img src='bilder/filip.jpg'>"; break;
    case "2":  echo "<img src='bilder/loke.jpg'>"; break;

    default: echo ""; break;

}
                
?>