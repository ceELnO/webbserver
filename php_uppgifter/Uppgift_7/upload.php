<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload file</title>
</head>

<style>
    p{
        font-size: 20px;
        font-weight:300;
    }
</style>

<body>

<!-- <p> to style text -->
<p>

<?php

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = true;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ". <br>";
        $uploadOk = true;
    }
    else {
        echo "File is not an image. <br>";
        $uploadOk = false;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists. <br>";
    $uploadOk = false;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 40000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = false;
}
// Allow only certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed. <br>";
    $uploadOk = false;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == false) {
    echo "Sorry, your file was not uploaded. <br>";
    // if everything is ok, try to upload file
}
else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded. <br>";
        writeUploadUser();
    }
    else {
        echo "Sorry, there was an error uploading your file. <br>";
    }
}

function writeUploadUser(){
    $file = fopen("uploaduser", "a") or die("unable to open file");

    $userFileName = htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]));
    $currentUser = $_SESSION["username"];

    $writeText = "Filename: $userFileName ; User: $currentUser ;" . PHP_EOL;
    fwrite($file, $writeText);
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "web";
    
    $conn = new mysqli($servername, $username, $password, $dbname);

    if($_SESSION["username"] == "holros") {
        $sql = "INSERT INTO uploads (filename, user, uploadtime, snuskig) VALUES ('$userFileName', '" . $_SESSION["username"] . "', NOW(), TRUE)";
    }
    else{
        $sql = "INSERT INTO uploads (filename, user, uploadtime) VALUES ('$userFileName', '" . $_SESSION["username"] . "', NOW())";
    }
    $conn->query($sql);
}

?>

<!-- End <p> tag -->
</p>
    
</body>
</html>