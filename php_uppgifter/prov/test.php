<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


<?php
    function up5(){
        $teachers = array( "Magnus"=>"webbutveckling", "Holger"=>"webbserverprogrammering", "Gösta"=> "teknik", "Nikodemus"=>"fysik", 
        "Björne"=>"Matematik") ;
        foreach($teachers as $x => $x_value) {
            echo "". $x ." är lärare i ". $x_value .". ";
        }
    }

    function up2(){
        $img_source = "yes";

        echo '<img src="'. $img_source .'" alt = "En bild" height = "42" width = "42">';
    }
?>



</body>
</html>