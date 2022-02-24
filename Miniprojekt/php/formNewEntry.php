<?php
    session_start();

    $title = $_POST["title"];
    $description = $_POST["description"];
    $theForm = $_POST["commented_form"];
    $theuser = $_SESSION["username"];

    // add entry
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "miniprojekt_forms";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO $theForm (title, description, user) VALUES('$title', '$description', '$theuser')";

    if ($conn->query($sql) === TRUE) {
        echo "entry added <br>";
        $theId = ltrim($theForm, 'T');
        $theId = strval($theId);
        echo "<a href=form.php?viewproduct=",urlencode($theId),"> return to the form </a>";
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();

?>