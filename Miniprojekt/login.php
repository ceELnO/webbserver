<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "miniprojekt";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT username, password FROM accounts";
    $result = $conn->query($sql);
    $loginsucces = false;

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if ($row["username"] == $_POST["username"] && $row["password"] == $_POST["password"]){
                $loginsucces = true;
                break;
            }
        }
    }
    else {
        echo "error";
    }
    $conn->close();

    if ($loginsucces == true){
        session_start();
        $_session["username"] = $_POST["username"];
        echo "login successful <br> <br>";
        include ("../forms/forms.html");
    }
    else{
        echo "login failed <br> <br>";
        include ("login.html");
    }
?>