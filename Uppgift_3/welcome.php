<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Welcome </title>

</head>

<?php

// can add more users easily
$accounts = array("Hahaha" => "123", "Quad" => "55");

$givenUsername = $_POST["username"];
$givenPassword = $_POST["password"];

// if account exists this message changes
$message = "The Account: '$givenUsername' does not exist";
$login = false;

// Testing password and account
foreach ($accounts as $username => $password){
    if ($givenUsername == $username){

        if ($givenPassword == $password){
            $message = "Welcome $username!";
            $login = true;
            break;
        }
        else{
            $message = "Wrong Password";
            break;
        } 
    }
}

// saving the user name in a session or destroys the session
if ($login == true){
    $_SESSION["currentUser"] = $_POST["username"];
}
else {
    session_destroy();
}

?>
<body>

<!-- Huvudinehåll -->
<div class = "container">
    <h2>
        <?php echo "$message" ?>
    <h2>

    <?php
        if ($login == true){
            echo '
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <lable> Select a image to upload: </lable> <br>
                    <input type="file" name="fileToUpload" id="fileToUpload"> <br>
                    <input type="submit" value="Upload Image" name="submit">
                </form>
            ';
        }
    ?>

</div>

</body>
</html>