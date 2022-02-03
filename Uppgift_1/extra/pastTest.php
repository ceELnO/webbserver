<!DOCTYPE html>
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

<div class = "rubrik">

    <h1> hello world </h1>

    <hr>

</div>

<!-- php del -->
<?php

    $array = array("Hello", "no", "hello", "nope");

    for($x = 0; $x < count($array); $x++){
        echo "hej ", $array[$x];
        echo "<br>";
    }



?>




</body>
</html>