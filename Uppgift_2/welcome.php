<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Welcome </title>

    <link href = "welcomeStyle.css" rel = "stylesheet" type = "text/css">

</head>

<?php

// can add more users easily
$accounts = array("Hahaha" => "123", "Quad" => "55");

$givenUsername = $_POST["username"];
$givenPassword = $_POST["password"];

// if account exists this message changes
$message = "The Account: '$givenUsername' <br> does not exist";

// echo "Username: $givenUsername <br> Password: $givenPassword <br>";

// Testing password and account
foreach ($accounts as $username => $password){
    if ($givenUsername == $username){

        if ($givenPassword == $password){
            $message = "Welcome $username!";
            break;
        }
        else{
            $message = "Wrong Password";
            break;
        } 
    }
}

?>

<body>

<!-- Message -->
<div class = "message">
    <p>
        <?php echo "$message" ?>
    </p>
</div>

</body>
</html>