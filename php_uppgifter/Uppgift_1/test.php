<!DOCTYPE html>
<html lang = "sv">
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Test </title>

    <!-- Externa filer -->
    <link href = "teststyle.css" rel="stylesheet" type="text/css">

</head>
<body>

<div class = "main">

    <!-- rubrik -->
    <div class = "rubrik">
        <h1>
            Inlämningsuppgift 1: PHP-syntax
        </h1>
        <hr>
    </div>

    <!-- Uppgift 1 -->
    <div class = "uppgift">
        <h2> Uppgift 1: </h2>

        <!-- php -->
        <?php
            $huvudstader = array("Sverige"=>"Stockholm", "Finland"=>"Helsingfors", "Danmark"=> "Köpenhamn", 
            "Norge"=>"Oslo", "Island"=>"Reykjavik", "Estland"=>"Tallinn", "Lettland"=>"Riga", "Litauen"=>"Vilnius");

            foreach($huvudstader as $land => $stad){
                echo "<p class = 'uppgift1'> $land";
                echo "s huvudstad heter $stad <p>";
                // pga den "jobbiga" php-syntaxen behöver "echo" delas upp för att få ett "s" bakom "$land"
            }
        ?>
        <!-- php slutar -->

        <br>
        <hr>
    </div>

    
    <!-- Uppgift 2 -->
    <div class = "uppgift">
            <h2> Uppgift 2: </h2>

            <table id = "table001">
                <tr>
                    <th>
                        Land
                    </th>
                    <th>
                        Huvudstad
                    </th>
                </tr>

                <!-- php -->
                <?php
                    // använder php arrayen från förra uppgiften

                    foreach($huvudstader as $land => $stad){
                        echo "
                        <tr>
                            <td>
                                $land
                            </td>
                            <td>
                                $stad
                            </td>
                        </tr>
                        ";
                    }
                ?>
                <!-- php slutar här -->

            </table>

            <br>
            <hr>
    </div>

    <!-- Uppgift 3 -->
    <div class = "uppgift">
            <h2> Uppgift 3: </h2>

            <?php
            $Larare = array("Webbserverprogrammering" => "Holger", "Matematik" => "Magnus Folkesson");
            ?>

            <table id = "table001">
                <tr>
                    <th>
                        Ämne
                    </th>
                    <th>
                        Lärare 
                    </th>
                </tr>

                <!-- php -->
                <?php
                    // använder php arrayen från förra uppgiften

                    foreach($Larare as $amne => $larare){
                        echo "
                        <tr>
                            <td>
                                $amne
                            </td>
                            <td>
                                $larare
                            </td>
                        </tr>
                        ";
                    }
                ?>
                <!-- php slutar här -->

            </table>

            <br>
            <hr>

    </div>

    <!-- Uppgift 4 -->
    <div class = "uppgift">
        
        <h2> Uppgift 4: </h2>

        <p class = "what"> Jag vet inte vad jag kan göra här </p>

    </div>


<!-- container slutar här -->
</div>


</body>
</html>